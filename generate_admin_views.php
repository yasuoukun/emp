<?php

$dirs = [
    __DIR__ . '/resources/views/admin/orders',
    __DIR__ . '/resources/views/central_admin/products',
    __DIR__ . '/resources/views/central_admin/categories',
    __DIR__ . '/resources/views/central_admin/brands',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

$template = '<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("PAGE_TITLE") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>PAGE_TITLE Management</h3>
                    <p>CRUD interface goes here.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>';

file_put_contents(__DIR__ . '/resources/views/admin/orders/index.blade.php', str_replace("PAGE_TITLE", "Orders", $template));
file_put_contents(__DIR__ . '/resources/views/central_admin/products/index.blade.php', str_replace("PAGE_TITLE", "Products", $template));
file_put_contents(__DIR__ . '/resources/views/central_admin/categories/index.blade.php', str_replace("PAGE_TITLE", "Categories", $template));
file_put_contents(__DIR__ . '/resources/views/central_admin/brands/index.blade.php', str_replace("PAGE_TITLE", "Brands", $template));

echo "Admin views generated.";
