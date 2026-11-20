<?php

// Regenerate composer autoload files (PSR-4 + classmap) without running composer scripts.
putenv('COMPOSER_NO_SCRIPTS=1');
passthru('composer dump-autoload --no-scripts 2>&1', $code);
echo 'exit code: '.$code.PHP_EOL;
