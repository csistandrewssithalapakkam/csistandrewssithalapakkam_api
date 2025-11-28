<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;

$roles = [
    'admin',
    'visitor',
    'developer',
    'pastor',
];

foreach ($roles as $roleName) {
    $exists = Role::where('role_name', $roleName)->exists();
    if (!$exists) {
        Role::create([
            'role_name' => $roleName,
            'created_by' => 1,
        ]);
        echo "Created role: $roleName\n";
    } else {
        echo "Role already exists: $roleName\n";
    }
}

echo "Done. All roles seeded.\n";
