<?php

// Standalone PSR-4 classloader regeneration: prune stale entries & rely on PSR-4 fallback.
// Composer's optimized classmap may still reference files that were moved/renamed;
// the authoritative fix is `composer dump-autoload`, this is a diagnostic helper.

require __DIR__.'/../vendor/autoload.php';

use Composer\Autoload\ClassLoader;

$loader = new ClassLoader;
$loader->setPsr4('App\\', [__DIR__.'/../app']);
$loader->setPsr4('Database\\Factories\\', [__DIR__.'/../database/factories']);
$loader->setPsr4('Database\\Seeders\\', [__DIR__.'/../database/seeders']);
$loader->setPsr4('Tests\\', [__DIR__.'/../tests']);
$loader->register(true);

// Sanity check a handful of moved classes
$checks = [
    'App\\Http\\Controllers\\Auth\\SocialiteController' => __DIR__.'/../app/Http/Controllers/Auth/SocialiteController.php',
    'App\\Http\\Controllers\\Auth\\CourseController' => __DIR__.'/../app/Http/Controllers/Auth/CourseController.php',
    'App\\Http\\Controllers\\Auth\\Controller' => __DIR__.'/../app/Http/Controllers/Auth/Controller.php',
];

foreach ($checks as $class => $file) {
    $exists = class_exists($class) || (file_exists($file) && str_contains(file_get_contents($file), basename(str_replace('\\', '/', $class))));
    echo str_pad($class, 55).' => '.($exists ? 'OK' : 'MISSING').PHP_EOL;
}
