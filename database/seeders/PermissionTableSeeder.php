<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return str_contains($route->getName(), '.') && !str_contains($route->getName(), 'login');
        })->pluck('action');

        // Define the mapping for method names
        $methodMappings = [
            'index' => 'list',
            'create' => 'create',
            'edit' => 'edit',
            'destroy' => 'delete',
        ];

        foreach ($routes as $action) {
            // Extract the method name from the route name
            $methodName = last(explode('.', $action['as']));
            // Check if the method is in the allowed methods
            if (array_key_exists($methodName, $methodMappings)) {
                $permissionName = $action['as'];
                // Replace method name with the mapped name
                $permissionName = str_replace($methodName, $methodMappings[$methodName], $permissionName);
                // Replace dots with underscores
                $permissionNameWithUnderscore = str_replace('.', '-', $permissionName);
                // Create a title by removing underscores
                $title = str_replace('-', ' ', ucfirst($permissionNameWithUnderscore));
                // Create or update the permission with the title
                Permission::firstOrCreate(['name' => $permissionNameWithUnderscore, 'title' => $title]);
            }
        }
    }
}
