<?php

use Illuminate\Database\Seeder;

class AddPermissionTollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::updateOrCreate(
            ['name' => 'ModuleToll'],
            [
                'name' => 'ModuleToll',
                'parent_id' => 2319,
                'is_menu' => 1,
                'url' => null,
                'order' => 980,
                'icon' => 'fa fa-newspaper-o'
            ]
        );

        $permission1 = Permission::updateOrCreate(
            ['name' => 'SettingTolls'],
            [
                'name' => 'SettingTolls',
                'parent_id' => $permission->id,
                'is_menu' => 1,
                'order' => 981,
                'url' => '/admin/toll/settings'
            ]
        );

        $permission2 = Permission::updateOrCreate(
            ['name' => 'listTolls'],
            [
                'name' => 'listTolls',
                'parent_id' => $permission->id,
                'is_menu' => 1,
                'order' => 982,
                'url' => '/admin/toll/list'
            ]
        );

        $permission3 = Permission::updateOrCreate(
            ['name' => 'listTollCategories'],
            [
                'name' => 'listTollCategories',
                'parent_id' => $permission->id,
                'is_menu' => 1,
                'order' => 983,
                'url' => '/admin/toll_category/list'
            ]
        );

        $admins = \Admin::select('id','profile_id')->get();
        
        if($admins && $permission){
            $findProfiles = array();
            foreach($admins as $admin){
                \AdminPermission::updateOrCreate(
                    ['admin_id' => $admin->id, 'permission_id' => $permission->id],
                    ['admin_id' => $admin->id, 'permission_id' => $permission->id]
                );
                \AdminPermission::updateOrCreate(
                    ['admin_id' => $admin->id, 'permission_id' => $permission1->id],
                    ['admin_id' => $admin->id, 'permission_id' => $permission1->id]
                );
                \AdminPermission::updateOrCreate(
                    ['admin_id' => $admin->id, 'permission_id' => $permission2->id],
                    ['admin_id' => $admin->id, 'permission_id' => $permission2->id]
                );
                \AdminPermission::updateOrCreate(
                    ['admin_id' => $admin->id, 'permission_id' => $permission3->id],
                    ['admin_id' => $admin->id, 'permission_id' => $permission3->id]
                );
                
                if ($admin->profile_id && !in_array($admin->profile_id, $findProfiles)) {
                    $findProfiles = array_merge($findProfiles, array($admin->profile_id));
                    \ProfilePermission::updateOrCreate(
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission->id],
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission->id]
                    );
                    \ProfilePermission::updateOrCreate(
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission1->id],
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission1->id]
                    );
                    \ProfilePermission::updateOrCreate(
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission2->id],
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission2->id]
                    );
                    \ProfilePermission::updateOrCreate(
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission3->id],
                        ['profile_id' => $admin->profile_id, 'permission_id' => $permission3->id]
                    );
                }
            }
        }
    }
}
