<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetCodeLeapPassword;

$user = User::factory()->create(['email' => 'testdebug@example.com']);

Notification::fake();

$response = \Illuminate\Support\Facades\Route::dispatch(
    \Illuminate\Http\Request::create(route('password.email'), 'POST', ['email' => 'testdebug@example.com'])
);

$sent = Notification::sentNotifications();

echo "Response status: " . $response->getStatusCode() . "\n";
echo "Notifications sent:\n";
foreach ($sent as $notification) {
    echo "  - " . get_class($notification) . "\n";
}
