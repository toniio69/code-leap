<?php

// Scans app/, database/, tests/ and builds $map = [FQCN => relative path] used
// by regen_classmap.php and regen_static.php.

$baseDir = dirname(__DIR__);
$dirs = ['app', 'database/factories', 'database/seeders', 'tests'];

$map = [];
foreach ($dirs as $dir) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir.'/'.$dir, FilesystemIterator::SKIP_DOTS));
    foreach ($rii as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }
        $path = str_replace('\\', '/', $file->getPathname());
        $contents = file_get_contents($path);
        if (! preg_match('/^\s*(?:abstract\s+|final\s+)?(?:class|interface|trait|enum)\s+(\w+)/m', $contents, $m)) {
            continue;
        }
        if (! preg_match('/^\s*namespace\s+([\w\\\\]+);/m', $contents, $n)) {
            continue;
        }
        $class = $n[1].'\\'.$m[1];
        $map[$class] = substr($path, strlen($baseDir) + 1);
    }
}
ksort($map);
