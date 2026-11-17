<?php
// Assignment 11: Photo Contest — GUIDED STUDENT VERSION
// Receives contest.html, validates visitor information and the uploaded image,
// saves an approved image under a safe name, and displays the results.

// STEP 1 — Only process submissions sent using POST.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: contest.html');
    exit;
}

// STEP 2 — Retrieve form values and prepare variables.
$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));


$photos = $_FILES['photos'] ?? null;

$errors = [];               // Collect validation messages.
$storedFilename = [];       // Unique name assigned by PHP.
$uploadDirectory = __DIR__ . '/uploads/';
$maximumFileSize = 1048576; // 1 MiB, expressed in bytes.
$allowedMimeTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
];

// STEP 3 — Reusable HTML-escaping function (Chapter 10).
function escapeHtml(string $value): string
{
    // Completed example from Chapter 10: safely display text in HTML.
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// STEP 4 — Validate the visitor's name and email address.
if ($name === '') {
    $errors[] = 'Please enter your name.';
}

// Validate the visitor's email address

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

// STEP 5 - Confirm 1 to 3 photographs were uploaded with no PHP upload errors.
$readyIndexes = [];

if (
    !is_array($photos)
    || !isset($photos['name'], $photos['error'], $photos['size'], $photos['tmp_name'])
    || !is_array($photos['name'])
) {
    $errors[] = 'Please select at least one photograph to upload.';
} else {
    $fileCount = count($photos['name']);

    if ($fileCount === 1 && ($photos['error'][0] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Please select at least one photograph to upload.';
    } elseif ($fileCount > 3) {
        $errors[] = "You may upload a maximum of 3 photographs (you selected $fileCount).";
    } else {
        for ($i = 0; $i < $fileCount; $i++) {
            $fileLabel = 'File ' . ($i + 1) . ' (' . ($photos['name'][$i] ?: 'unnamed') . ')';

            if (!is_int($photos['error'][$i]) || !is_int($photos['size'][$i]) || !is_string($photos['tmp_name'][$i])) {
                $errors[] = "$fileLabel could not be processed.";
            } elseif ($photos['error'][$i] === UPLOAD_ERR_NO_FILE) {
                $errors[] = "$fileLabel was not uploaded.";
            } elseif ($photos['error'][$i] === UPLOAD_ERR_FORM_SIZE || $photos['error'][$i] === UPLOAD_ERR_INI_SIZE) {
                $errors[] = "$fileLabel exceeds the upload size limit.";
            } elseif ($photos['error'][$i] !== UPLOAD_ERR_OK) {
                $errors[] = "$fileLabel could not be uploaded (error " . $photos['error'][$i] . ').';
            } else {
                $readyIndexes[] = $i;
            }
        }
    }
}

// STEP 6 - Check file size and inspect the actual MIME type with Fileinfo.
$validFiles = [];

foreach ($readyIndexes as $i) {
    $fileLabel = 'File ' . ($i + 1) . ' (' . ($photos['name'][$i] ?: 'unnamed') . ')';
    $size = $photos['size'][$i];
    $tmpName = $photos['tmp_name'][$i];

    if ($size <= 0) {
        $errors[] = "$fileLabel is empty.";
    } elseif ($size > $maximumFileSize) {
        $errors[] = "$fileLabel must not exceed 1 MB (1,048,576 bytes).";
    } elseif (!is_uploaded_file($tmpName)) {
        $errors[] = "$fileLabel could not be verified.";
    } else {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($fileInfo === false) {
            $errors[] = 'The server could not inspect the photograph.';
        } else {
            $mimeType = finfo_file($fileInfo, $tmpName);
            finfo_close($fileInfo);

            if ($mimeType === false || !isset($allowedMimeTypes[$mimeType])) {
                $errors[] = "$fileLabel: Only JPEG and PNG photographs are allowed.";
            } else {
                $validFiles[] = [
                    'tmp_name' => $tmpName,
                    'extension' => $allowedMimeTypes[$mimeType],
                    'label' => $fileLabel,
                ];
            }
        }
    }
}

// STEP 7 - Confirm directory permissions, assign a new name, and move the files.
if (!empty($validFiles) && empty($errors)) {
    if (!is_dir($uploadDirectory)) {
        $errors[] = 'The uploads directory does not exist.';
    } elseif (!is_writable($uploadDirectory)) {
        $errors[] = 'The uploads directory is not writable.';
    } else {
        // Create a safe filename and save each validated photograph.
        foreach ($validFiles as $file) {
            $newFilename = bin2hex(random_bytes(16)) . '.' . $file['extension'];
            $destination = $uploadDirectory . $newFilename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $storedFilenames[] = $newFilename;
            } else {
                $errors[] = $file['label'] . ' could not be saved. Please try again.';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Contest Results</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="wrapper">
        <header>
            <h1>Photo Contest</h1>
        </header>
        <main>
            <h2>Submission Results</h2>

            <?php if (!empty($errors)): ?>
                <h3>Please correct the following:</h3>
                <ul class="error">
                    <?php foreach ($errors as $error): ?>
                        <li><?= escapeHtml($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif (!empty($storedFilenames)): ?>
                <!-- STEP 8 - Display the confirmation and all saved photographs. -->
                <p class="message">Thank you, <?= escapeHtml($name) ?>, for entering our contest!</p>
                <p><?= count($storedFilenames) ?> photo(s) uploaded successfully.</p>
                <?php foreach ($storedFilenames as $filename): ?>
                    <img class="photo-preview" src="uploads/<?= escapeHtml($filename) ?>"
                        alt="Photograph submitted by <?= escapeHtml($name) ?>">
                <?php endforeach; ?>
            <?php else: ?>
                <p class="error">Your photograph has not been saved. Check the TODO sections and try again.</p>
            <?php endif; ?>

            <p><a class="back-link" href="contest.html">Return to the Photo Contest form</a></p>
        </main>
    </div>
</body>

</html>