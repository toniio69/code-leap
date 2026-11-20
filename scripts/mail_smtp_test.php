<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Mail;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo 'mailer: '.config('mail.default').PHP_EOL;
echo 'host: '.config('mail.mailers.smtp.host').':'.config('mail.mailers.smtp.port').PHP_EOL;
echo 'from: '.config('mail.from.address').PHP_EOL;

try {
    Mail::raw('Password reset SMTP test from Code Leap.', function ($m) {
        $m->to('159bc043491f8b+test@inbox.mailtrap.io')
            ->subject('Code Leap SMTP test')
            ->from(config('mail.from.address'), config('mail.from.name'));
    });
    echo 'SENT OK'.PHP_EOL;
} catch (Throwable $e) {
    echo 'FAILED: '.$e->getMessage().PHP_EOL;
}
