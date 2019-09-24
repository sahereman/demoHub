<?php

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_menu_id = 3;
        // base tables
        Menu::truncate();
        Menu::insert(
            [
//                [
//                    "parent_id" => 0,
//                    "order" => 1,
//                    "title" => "Dashboard",
//                    "icon" => "fa-bar-chart",
//                    "uri" => "/",
//                    "permission" => NULL
//                ],
                [
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "我的项目",
                    "icon" => "fa-table",
                    "uri" => "",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 1,
                    "order" => 1,
                    "title" => "项目",
                    "icon" => "fa-tablet",
                    "uri" => "/demos",
                    "permission" => NULL
                ],
                /*[
                    "parent_id" => 2,
                    "order" => 2,
                    "title" => "Demo Assignment",
                    "icon" => "fa-compass",
                    "uri" => "/demos/assignment",
                    "permission" => NULL
                ],*/
                [
                    "parent_id" => 0,
                    "order" => 3,
                    "title" => "管理设置",
                    "icon" => "fa-tasks",
                    "uri" => "",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 1,
                    "title" => "用户",
                    "icon" => "fa-users",
                    "uri" => "auth/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 2,
                    "title" => "角色",
                    "icon" => "fa-user",
                    "uri" => "auth/roles",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 3,
                    "title" => "权限",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 4,
                    "title" => "菜单",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 5,
                    "title" => "操作日志",
                    "icon" => "fa-history",
                    "uri" => "auth/logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 6,
                    "title" => "系统日志",
                    "icon" => "fa-database",
                    "uri" => "logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 7,
                    "title" => "Composer Viewer",
                    "icon" => "fa-gears",
                    "uri" => "composer-viewer",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 8,
                    "title" => "Env Manager",
                    "icon" => "fa-gears",
                    // "uri" => "env-manager",
                    "uri" => "env-envira",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 9,
                    "title" => "PHP info",
                    // "icon" => "fa-exclamation",
                    "icon" => "fa-info",
                    "uri" => "phpinfo",
                    "permission" => NULL
                ],
                [
                    "parent_id" => $admin_menu_id,
                    "order" => 10,
                    "title" => "Horizon",
                    // "icon" => "fa-database",
                    "icon" => "fa-support",
                    "uri" => "horizon",
                    "permission" => NULL
                ]
            ]
        );

        //create a permission
        Permission::truncate();
        Permission::insert(
            [
                [
                    "name" => "All permission",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*"
                ],
                [
                    "name" => "Dashboard",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/"
                ],
                [
                    "name" => "Login",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout"
                ],
                [
                    "name" => "User setting",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting"
                ],
                [
                    "name" => "Auth management",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs"
                ],
                [
                    "name" => "Logs",
                    "slug" => "ext.log-viewer",
                    "http_method" => NULL,
                    "http_path" => "/logs*"
                ],
                [
                    "name" => "DemoHub",
                    "slug" => "demohub",
                    "http_method" => NULL,
                    "http_path" => "/demos*\r\n/categories*"
                ],
            ]
        );

        // create a role.
        Role::truncate();
        Role::insert(
            [
                [
                    "name" => "Administrator",
                    "slug" => "administrator"
                ],
                [
                    "name" => "Designer",
                    "slug" => "designer"
                ],
            ]
        );

        // add a permission to a role.
        // Role::first()->permissions()->save(Permission::first());

        // add role to menu.
        // Menu::find(2)->roles()->save(Role::first());

        // create a user.
        // Administrator::truncate();
        Administrator::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name' => 'Administrator',
        ]);
        Administrator::create([
            'username' => 'designer-1',
            'password' => bcrypt('123456'),
            'name' => 'Designer-1',
        ]);
        Administrator::create([
            'username' => 'designer-2',
            'password' => bcrypt('123456'),
            'name' => 'Designer-2',
        ]);
        Administrator::create([
            'username' => 'designer-3',
            'password' => bcrypt('123456'),
            'name' => 'Designer-3',
        ]);

        // add a role to a user.
        Administrator::first()->roles()->save(Role::first());
        Administrator::find(2)->roles()->save(Role::find(2));
        Administrator::find(3)->roles()->save(Role::find(2));
        Administrator::find(4)->roles()->save(Role::find(2));

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 2
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 4
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 5
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 5
                ],
            ]
        );

        // add role to menu.
        // Menu::find(2)->roles()->save(Role::first());

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 2
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 3
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 6
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 7
                ],
            ]
        );

        // add a permission to a role.
        // Role::first()->permissions()->save(Permission::first());

        // finish
    }
}
