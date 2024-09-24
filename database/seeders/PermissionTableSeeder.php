<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'users-list',
           'users-create',
           'users-edit',
           'users-delete',
           'roles-list',
           'roles-create',
           'roles-edit',
           'roles-delete',
        //    'permission-list',
        //    'permission-create',
        //    'permission-edit',
        //    'permission-delete',
           'products-list',
           'products-create',
           'products-edit',
           'products-delete'
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
