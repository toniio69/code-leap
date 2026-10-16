<?php

// One-off helper: extract a composer dist zip into a target directory using PHP's ZipArchive.
// Handles case-insensitive collisions by skipping duplicates that come from the zip's
// internal folder-prefix (googleapis-google-api-php-client-services-<sha>/...).
$zipPath = $argv[1] ?? null;
$target = $argv[2] ?? null;
if (! $zipPath || ! $target || ! file_exists($zipPath)) {
    fwrite(STDERR, "usage: php extract_zip.php <zip> <target>\n");
    exit(1);
}

$zip = new ZipArchive;
if ($zip->open($zipPath) !== true) {
    fwrite(STDERR, "cannot open zip\n");
    exit(1);
}

if (! is_dir($target)) {
    mkdir($target, 0777, true);
}
$target = rtrim(str_replace('\\', '/', realpath($target)), '/');

$count = 0;
for ($i = 0; $i < $zip->numFiles; $i++) {
    $name = $zip->getNameIndex($i);
    // strip the leading googleapis-.../ prefix
    $name = preg_replace('#^[^/]+/#', '', $name);
    if ($name === '' || substr($name, -1) === '/') {
        continue;
    }
    $out = $target.'/'.$name;
    $dir = dirname($out);
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    $data = $zip->getFromIndex($i);
    if ($data === false) {
        continue;
    }
    file_put_contents($out, $data);
    $count++;
}
$zip->close();
echo "extracted {$count} files to {$target}\n";
