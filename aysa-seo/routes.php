<?php

use Aysa\Core\Route_Type as Route_Type;

$router->register_route_of_type(ROUTE_TYPE::ADMIN)
    ->with_controller('Admin_Dashboard@register_hook_callbacks')
    ->with_model('Admin_Dashboard')
    ->with_view('Admin_Dashboard');

// Route for Wizard Page.
$router->register_route_of_type(ROUTE_TYPE::ADMIN)
    ->with_controller('Aysa\App\Controllers\Admin\Wizard@register_hook_callbacks')
    ->with_model('Wizard')
    ->with_view('Wizard');

// Route for Rank Tracker Page.
$router->register_route_of_type(ROUTE_TYPE::ADMIN)
    ->with_controller('Aysa\App\Controllers\Admin\Rank_Tracker@register_hook_callbacks')
    ->with_model('Rank_Tracker')
    ->with_view('Rank_Tracker');

//Route for seo suggestion ajax data
$router->register_route_of_type(ROUTE_TYPE::AJAX)
    ->with_controller('Aysa\App\Controllers\Admin\Get_Suggestions@register_hook_callbacks')
    ->with_model('Aysa\App\Models\Admin\Get_Suggestions');

$router->register_route_of_type(ROUTE_TYPE::ADMIN)
    ->with_controller('Aysa\App\Controllers\Admin\Custom_Attachment_Fields@register_hook_callbacks');

//Route for running get rank tracker data cron
$router->register_route_of_type(ROUTE_TYPE::CRON)
    ->with_controller('Aysa\App\Controllers\Cron\Get_Ranks_Cron@register_hook_callbacks');

$router->register_route_of_type(ROUTE_TYPE::ADMIN)
    ->with_controller('Aysa\App\Controllers\Admin\Product_Metabox@register_hook_callbacks')
    ->with_view('Admin_Product_Metabox');

//Route for adding a new product
$router->register_route_of_type(ROUTE_TYPE::ANY)
    ->with_controller('Aysa\App\Controllers\Admin\Admin_Product@register_hook_callbacks');

$router->register_route_of_type(ROUTE_TYPE::ANY)
    ->with_controller('Aysa\App\Controllers\Admin\Admin_Category@register_hook_callbacks');