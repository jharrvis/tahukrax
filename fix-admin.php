<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'admin@rcgo.test';
$pass = 'password';

$user = User::where('email', $email)->first();

if (!$user) {
    $user = new User();
    $user->email = $email;
}

$user->name = 'Admin RCGO';
$user->password = Hash::make($pass);
$user->role = 'admin';
$user->save();

echo "Admin user synched: $email / $pass\n";
echo "Hashed password in DB: " . $user->password . "\n";
echo "Role in DB: " . $user->role . "\n";
echo "Can access 'admin' panel: " . ($user->canAccessPanel(Filament\Facades\Filament::getPanel('admin')) ? 'YES' : 'NO') . "\n";
