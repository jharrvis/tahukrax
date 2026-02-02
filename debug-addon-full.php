<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ADD-ON IMAGE DEBUG REPORT ===\n\n";

$addons = \App\Models\Addon::all();

foreach ($addons as $addon) {
    echo "-----------------------------------\n";
    echo "Name: {$addon->name}\n";
    echo "Image URL (DB): '{$addon->image_url}'\n";

    if ($addon->image_url) {
        $storageUrl = \Illuminate\Support\Facades\Storage::url($addon->image_url);
        echo "Storage::url() Output: {$storageUrl}\n";

        $fullPath = storage_path('app/public/' . $addon->image_url);
        echo "Expected File Path: {$fullPath}\n";
        echo "File Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";

        if (file_exists($fullPath)) {
            echo "File Size: " . filesize($fullPath) . " bytes\n";
        }
    } else {
        echo "Image URL is EMPTY - no file to check\n";
    }
    echo "\n";
}

echo "-----------------------------------\n";
echo "Storage Disk Config: " . config('filesystems.default') . "\n";
echo "Public Disk Root: " . config('filesystems.disks.public.root') . "\n";
echo "Public Disk URL: " . config('filesystems.disks.public.url') . "\n";
echo "\n";

$symlinkPath = public_path('storage');
echo "public/storage path: {$symlinkPath}\n";
echo "public/storage exists: " . (file_exists($symlinkPath) ? 'YES' : 'NO') . "\n";
echo "public/storage is link: " . (is_link($symlinkPath) ? 'YES (symlink)' : 'NO (regular directory or not exists)') . "\n";

if (file_exists($symlinkPath) && is_dir($symlinkPath)) {
    echo "Contents of public/storage:\n";
    $contents = scandir($symlinkPath);
    foreach ($contents as $item) {
        if ($item !== '.' && $item !== '..') {
            echo "  - {$item}\n";
        }
    }
}
