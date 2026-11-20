<?php

// Also fixes the stale entries in vendor/composer/autoload_static.php
// (used by the optimized autoloader) to mirror the regenerated classmap.

$baseDir = dirname(__DIR__);
require $baseDir.'/scripts/regen_classmap_data.php';

$staticPath = $baseDir.'/vendor/composer/autoload_static.php';
$contents = file_get_contents($staticPath);

$fixed = 0;
foreach ($map as $class => $rel) {
    $classEsc = str_replace('\\', '\\\\', $class);
    $rel = str_replace('\\', '/', $rel);
    // Match single- or multi-line entries pointing to any path for this class
    $pattern = "#'".preg_quote($classEsc, '#')."'\\s*=>\\s*__DIR__ \\. '/\\.\\./' \\.\n?\\s*'[^']*',#s";
    $replacement = "'".$classEsc."' => __DIR__ . '/../..' . '/".$rel."',";
    $contents = preg_replace($pattern, $replacement, $contents, 1, $count);
    if ($count) {
        $fixed++;
    } else {
        echo "no entry found for {$class}".PHP_EOL;
    }
}

file_put_contents($staticPath, $contents);
echo "autoload_static.php updated: {$fixed} of ".count($map).' app classes fixed.'.PHP_EOL;
