<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin name
    |--------------------------------------------------------------------------
    |
    | This value is the name of laravel-admin, This setting is displayed on the
    | login page.
    | 站点标题
    */
    'name' => 'YCC',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages. You can also set it as an image by using a
    | `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
    | 页面顶部logo
    */
    'logo' => '<b>YCC</b> admin',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin mini logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages when the sidebar menu is collapsed. You can
    | also set it as an image by using a `img` tag, eg
    | '<img src="http://logo-url" alt="Admin logo">'.
    | 页面顶部小logo
    */
    'logo-mini' => '<b>YCC</b>',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin bootstrap setting
    |--------------------------------------------------------------------------
    |
    | This value is the path of laravel-admin bootstrap file.
    | Laravel-Admin 启动文件路径
    */
    'bootstrap' => app_path('Admin/bootstrap.php'),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    | 路由配置
    */
    'route' => [
        // 路由前缀
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),
        // 控制器命名空间前缀
        'namespace' => 'App\\Admin\\Controllers',
        // 默认中间件列表
        'middleware' => ['web', 'admin'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin install directory
    |--------------------------------------------------------------------------
    |
    | The installation directory of the controller and routing configuration
    | files of the administration page. The default is `app/Admin`, which must
    | be set before running `artisan admin::install` to take effect.
    | Laravel-Admin 的安装目录
    */
    'directory' => app_path('Admin'),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin html title
    |--------------------------------------------------------------------------
    |
    | Html title for all pages.
    | Laravel-Admin 页面标题
    */
    'title' => 'Admin',

    /*
    |--------------------------------------------------------------------------
    | Access via `https`
    |--------------------------------------------------------------------------
    |
    | If your page is going to be accessed via https, set it to `true`.
    | 是否使用 https
    */
    'https' => env('ADMIN_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin auth setting
    |--------------------------------------------------------------------------
    |
    | Authentication settings for all admin pages. Include an authentication
    | guard and a user provider setting of authentication driver.
    |
    | You can specify a controller for `login` `logout` and other auth routes.
    | Laravel-Admin 用户认证设置
    */
    'auth' => [

        'controller' => App\Admin\Controllers\AuthController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => Encore\Admin\Auth\Database\Administrator::class,
            ],
        ],
        // 是否展示 保持登录 选项
        // Add "remember me" to login form
        'remember' => true,
        // 登录页面 URL
        // Redirect to the specified URI when user is not authorized.
        'redirect_to' => 'auth/login',
        // 无需用户认证即可访问的地址
        // The URIs that should be excluded from authorization.
        'excepts' => [
            'auth/login',
            'auth/logout',
            '_handle_action_',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin upload setting
    |--------------------------------------------------------------------------
    |
    | File system configuration for form upload files and images, including
    | disk and upload path.
    |  Laravel-Admin 文件上传设置
    */
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => 'admin',

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for laravel-admin builtin model & tables.
    | Laravel-Admin 数据库设置
    */
    'database' => [
        // 数据库连接名称，留空即可
        // Database connection for following tables.
        'connection' => '',
        // 管理员用户表及模型
        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,
        // 角色表及模型
        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,
        // 权限表及模型
        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,
        // 菜单表及模型
        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,
        // 多对多关联中间表
        // Pivot table for table above.
        'operation_log_table'    => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | User operation log setting
    |--------------------------------------------------------------------------
    |
    | By setting this option to open or close operation log in laravel-admin.
    | Laravel-Admin 操作日志设置
    */
    'operation_log' => [

        'enable' => true,

        /* 只记录以下类型的请求
         * Only logging allowed methods in the list
         */
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /* 不记操作日志的路由
         * Routes that will not log to database.
         *
         * All method to path like: admin/auth/logs
         * or specific method to path like: get:admin/auth/logs.
         */
        'except' => [
            'admin/auth/logs*',
        ],
    ],

    /* 路由是否检查权限
    |--------------------------------------------------------------------------
    | Indicates whether to check route permission.
    |--------------------------------------------------------------------------
    */
    'check_route_permission' => true,

    /* 菜单是否检查权限
    |--------------------------------------------------------------------------
    | Indicates whether to check menu roles.
    |--------------------------------------------------------------------------
    */
    'check_menu_roles'       => true,

    /*
    |--------------------------------------------------------------------------
    | User default avatar
    |--------------------------------------------------------------------------
    | 管理员默认头像
    | Set a default avatar for newly created users.
    |
    */
    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',

    /*
    |--------------------------------------------------------------------------
    | Admin map field provider
    |--------------------------------------------------------------------------
    |
    | Supported: "tencent", "google", "yandex".
    | 地图组件提供商
    */
    'map_provider' => 'google',

    /* 页面风格
    |--------------------------------------------------------------------------
    | Application Skin
    |--------------------------------------------------------------------------
    |
    | This value is the skin of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |
    | Supported:
    |    "skin-blue", "skin-blue-light", "skin-yellow", "skin-yellow-light",
    |    "skin-green", "skin-green-light", "skin-purple", "skin-purple-light",
    |    "skin-red", "skin-red-light", "skin-black", "skin-black-light".
    |
    */
    'skin' => 'skin-blue-light',

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |
    | Supported: "fixed", "layout-boxed", "layout-top-nav", "sidebar-collapse",
    | "sidebar-mini".
    | 后台布局
    */
    'layout' => ['sidebar-mini', 'sidebar-collapse'],

    /*
    |--------------------------------------------------------------------------
    | Login page background image
    |--------------------------------------------------------------------------
    | 登录页背景图
    | This value is used to set the background image of login page.
    |
    */
    'login_background_image' => '',

    /*
    |--------------------------------------------------------------------------
    | Show version at footer
    |--------------------------------------------------------------------------
    |
    | Whether to display the version number of laravel-admin at the footer of
    | each page
    | 显示版本
    */
    'show_version' => true,

    /*
    |--------------------------------------------------------------------------
    | Show environment at footer
    |--------------------------------------------------------------------------
    |
    | Whether to display the environment at the footer of each page
    | 显示环境
    */
    'show_environment' => true,

    /*
    |--------------------------------------------------------------------------
    | Menu bind to permission
    |--------------------------------------------------------------------------
    | 菜单绑定权限
    | whether enable menu bind to a permission
    */
    'menu_bind_permission' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable default breadcrumb
    |--------------------------------------------------------------------------
    | 默认启用面包屑
    | Whether enable default breadcrumb for every page content.
    */
    'enable_default_breadcrumb' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable assets minify
    |--------------------------------------------------------------------------
    压缩资源文件
    */
    'minify_assets' => [
        // 不需要被压缩的资源
        // Assets will not be minified.
        'excepts' => [

        ],

    ],

    /* 启用菜单搜索
    |--------------------------------------------------------------------------
    | Enable/Disable sidebar menu search
    |--------------------------------------------------------------------------
    */
    'enable_menu_search' => true,

    /* 顶部警告信息
    |--------------------------------------------------------------------------
    | Alert message that will displayed on top of the page.
    |--------------------------------------------------------------------------
    */
    'top_alert' => '',

    /* 表格操作展示样式
    |--------------------------------------------------------------------------
    | The global Grid action display class.
    |--------------------------------------------------------------------------
    */
    'grid_action_class' => \Encore\Admin\Grid\Displayers\DropdownActions::class,

    /* 扩展所在的目录.
    |--------------------------------------------------------------------------
    | Extension Directory
    |--------------------------------------------------------------------------
    |
    | When you use command `php artisan admin:extend` to generate extensions,
    | the extension files will be generated in this directory.
    */
    'extension_dir' => app_path('Admin/Extensions'),

    /*
    |--------------------------------------------------------------------------
    | Settings for extensions.
    |--------------------------------------------------------------------------
    | 扩展设置.
    | You can find all available extensions here
    | https://github.com/laravel-admin-extensions.
    |
    */
    'extensions' => [
        'tinymce' => [
            // Set to false if you want to disable this extension
            'enable' => true,
            // Editor configuration
            'config' => [
                'resize'=> false,
                'plugins'=> 'advlist autolink link image lists preview code help fullscreen table autoresize ',   // 插件
                'toolbar'=> 'undo redo | styleselect | fontsizeselect bold italic | link image blockquote removeformat | indent outdent bullist numlist code',   // 配置工具栏
                'images_upload_url'=> '/api/v1/images',  //图片上传接口  返回格式：{ location : "/demo/image/1.jpg" }
            ]
        ],
        'iframe-tabs' => [
            // Set to `false` if you want to disable this extension
            'enable' => true,
            // The controller and action of dashboard page `/admin/dashboard`
            'home_action' => App\Admin\Controllers\HomeController::class . '@index',
            // Default page tab-title
            'home_title' => 'Home',
            // Default page tab-title icon
            'home_icon' => 'fa-home',
            // Whether show icon befor titles for all tab
            'use_icon' => true,
            // dashboard css
            'tabs_css' =>'vendor/laravel-admin-ext/iframe-tabs/dashboard.css',
            // layer.js path
            'layer_path' => 'vendor/laravel-admin-ext/iframe-tabs/layer/layer.js',
            /**
             * href links do not open in tab .
             * selecter : .sidebar-menu li a,.navbar-nav>li a,.sidebar .user-panel a,.sidebar-form .dropdown-menu li a
             * if(href.indexOf(pass_urls[i]) > -1) //pass
             */
            'pass_urls' => ['/auth/logout', '/auth/lock'],
            // When login session state of a tab-page was expired , force top-level window goto login page .
            //登录超时是是否强制整体跳转到登录页面，设为false的话只在触发超时登录的页面跳转，最大程度保留已打开页面。
            'force_login_in_top' => true,
            // tabs left offset
            'tabs_left'  => 42,
            // bind click event of table actions [edit / view]
            'bind_urls' => 'popup', //[ popup / new_tab / none]
            //table actions dom selecter
            'bind_selecter' => 'a.grid-row-view,a.grid-row-edit,.column-__actions__ ul.dropdown-menu a,.box-header .pull-right .btn-success,.popup',
            //table action links [view edit] and create button ,and any thing has class pupop : <a class="pupop" popw="400px" poph="200px" href="someurl">mylink</a>
        ],
        // 新增编辑器配置开始
        'quill' => [
            // If the value is set to false, this extension will be disabled
            'enable' => true,
            'config' => [
                'modules' => [
                    'syntax' => true,
                    'toolbar' =>
                        [
                            ['size' => []],
                            ['header' => []],
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            ['script' => 'super'],
                            ['script' => 'sub'],
                            ['color' => []],
                            ['background' => []],
                            'blockquote',
                            'code-block',
                            ['list' => 'ordered'],
                            ['list' => 'bullet'],
                            ['indent' => '-1'],
                            ['indent' => '+1'],
                            'direction',
                            ['align' => []],
                            'link',
                            'image',
                            'video',
                            'formula',
                            'clean'
                        ],
                ],
                'theme' => 'snow',
                'height' => '200px',
            ]
        ]
        // 新增编辑器配置结束
    ],
];
