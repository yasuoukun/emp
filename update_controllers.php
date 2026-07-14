<?php

function updateController($path, $viewName) {
    $content = file_get_contents($path);
    $content = str_replace(
        "    //\n",
        "    public function index() { return view('$viewName'); }\n",
        $content
    );
    file_put_contents($path, $content);
}

updateController(__DIR__ . '/app/Http/Controllers/Admin/OrderController.php', 'admin.orders.index');
updateController(__DIR__ . '/app/Http/Controllers/Admin/ProductController.php', 'central_admin.products.index');
updateController(__DIR__ . '/app/Http/Controllers/Admin/CategoryController.php', 'central_admin.categories.index');
updateController(__DIR__ . '/app/Http/Controllers/Admin/BrandController.php', 'central_admin.brands.index');

echo "Controllers updated.";
