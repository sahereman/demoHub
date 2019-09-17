# demoHub

demoHub based on `Laravel v6.0`

## gitHub

[https://github.com/sahereman/demoHub](https://github.com/sahereman/demoHub)

## Server Requirements

- PHP >= 7.2.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Install Laravel Via Composer Create-Project

```
# 配置 Aliyun composer packagist 镜像
$ composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

$ composer create-project --prefer-dist laravel/laravel demoHub
```

## .gitignore

```
$ vim .gitignore
-----------------------------------------
.idea
/node_modules
/public/fonts
/public/hot
/public/storage
/storage/*.key
/storage/debugbar
/vendor

.env
.env.backup
.env.bak
.env.old
.env.save
.gitignore.bak
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
readme.md.bak
yarn-error.log
yarn.lock

_ide_helper.php
_ide_helper_models.php
.phpstorm.meta.php

-----------------------------------------
```

## composer

```
$ vi composer.json
-----------------------------------------
.
.
.
"autoload": {
    "psr-4": {
        "App\\": "app/"
    },
    "classmap": [
        "database/seeds",
        "database/factories"
    ],
    "files": [
        "app/helpers.php"
    ]
},
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
    }
},
.
.
.
-----------------------------------------

# 阿里巴巴开源镜像提供的 packagist 镜像服务
# 配置 Aliyun packagist
$ composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
# 取消配置
$ composer config -g --unset repos.packagist

$ composer create-project laravel/laravel laravelBbsV5.8 --prefer-dist "5.8.*"

# FAQ:
# Target class [XxYyZz] does not exist.

# Solution:
$ composer dumpautoload
# OR:
$ composer dump-autoload
```

## yarn

```
$ yarn config set registry https://registry.npm.taobao.org

$ yarn install
# OR:
$ yarn install --no-lockfile

# Font Awesome
$ yarn add @fortawesome/fontawesome-free
```

## npm

```
# Dev Mode:
$ npm run watch-poll &
# Check the job list:
$ jobs
# Kill this job:
$ kill %1

# FAQ:
# Additional dependencies must be installed. This will only take a moment.
# Running: yarn add vue-template-compiler --dev --production=false

# Solution:
$ yarn add vue-template-compiler --dev --production=false

# Prod Mode:
$ npm run production
```

## 项目部署 Deployment
```
# Linux服务器环境要求
支持Laravel 6.0 | PHP7.2 | MySql5.7 | Redis3.2
Composer | Git客户端 | crond服务 | Supervisor进程管理工具

# 安装
$ composer install

# crond服务
$ crontab -e # 添加
-------------------
* * * * * php /{项目绝对路径根目录}/artisan schedule:run >> /dev/null 2>&1    保存
-------------------
$ crontab -u root -l # 查看
# restart crond service: [Command for Ubuntu/Mint/Debian based Linux users]
$ sudo systemctl restart|status cron.service
# OR: [Command for RHEL/Fedora/CentOS/Scientific Linux users]
$ sudo systemctl restart|status crond.service
# OR: [Command for Ubuntu/Mint/Debian based Linux users]
$ /etc/init.d/cron restart
# OR: [Command for RHEL/Fedora/CentOS/Scientific Linux users]
$ /etc/init.d/crond restart

# 配置 env
$ cp .env.example .env
$ php artisan key:generate
$ php artisan jwt:secret # 更换这个secret 会导致之前生成的所有 token 无效。

# 静态资源软链接
$ sudo php artisan storage:link

# 运行 Laravel Mix
$ yarn config set registry https://registry.npm.taobao.org
$ sudo SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass yarn --no-bin-links
# OR:
$ SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass
$ sudo yarn [install] --no-bin-links [--no-lockfile]

# 生产环境数据数据迁移
$ php artisan migrate:refresh
$ php artisan db:seed --class=AdminTablesSeeder
$ php artisan db:seed --class=ConfigsSeeder

# 开发环境数据数据迁移(含测试数据)
$ php artisan ide-helper:generate
$ php artisan migrate:refresh --seed
# Note: [涉及外键添加的数据迁移务必注意数据迁移文件的执行次序!!!]

# 后台菜单和权限修改
# 在 `database\seeds\AdminTablesSeeder.php` 中修改后:
$ php artisan admin:make UsersController --model=App\\Models\\User
$ php artisan db:seed --class=AdminTablesSeeder

# 后台系统设置构建
# 在 database\seeds\ConfigsSeeder.php 中修改后:
$ php artisan db:seed --class=ConfigsSeeder
```

## 服务器后台运行的服务:

### Dev Mode:
- `npm run watch-poll &`
- `php artisan horizon &`

### Prod Mode: [生产环境进程管理工具 Supervisor]
- `/path/to/php /path/to/artisan horizon`
- `/path/to/php /path/to/bin/laravels start`
```
$ /path/to/bin/fswatch /path/to/app >> /dev/null 2>&1
# or (二选一):
$ /path/to/php /path/to/bin/laravels start {start|stop|restart|reload|info|help}
```

## 常用 artisan 命令
```
# 查看 artisan 命令列表
$ php artisan list
# OR: 在 homestead 环境下: (art = php artisan)
$ art list

# 创建 API 控制器
$ php artisan make:controller Api/{控制器名称}Controller # 控制器名称一般为模型复数名
$ php artisan make:request Api/{验证器名称}Request
$ php artisan jwt:secret # 更换这个secret 会导致之前生成的所有 token 无效。

# 创建模型 & 数据填充 & 控制器
$ php artisan make:model Models/{模型名称sgl.} -mf                                    # 模型 & 工厂
$ php artisan make:seeder {模型名称pl.}Seeder                                         # 数据填充名称一般为模型复数名
$ php artisan make:controller {控制器名称pl.}Controller                               # 控制器名称一般为模型复数名
$ php artisan admin:make {控制器名称pl.}Controller --model=App\\Models\\{模型名称sgl.} # 控制器名称一般为模型复数名

# 创建验证器
$ php artisan make:request {验证器名称}Request

# 创建任务
$ php artisan make:job {任务名称}

# 快速创建事件与绑定监听器
$ vim app/Providers/EventServiceProvider.php # listen 数组包含所有的事件（键）以及事件对应的监听器（值）来注册所有的事件监听器
$ php artisan event:generate

# 创建事件
$ php artisan make:event {事件名称}

# 创建监听器
$ php artisan make:listener UpdateProductSoldCount --event=OrderPaid

# 创建通知类
$ php artisan make:notification OrderPaidNotification

# 创建授权策略类
$ php artisan make:policy {模型名称}Policy   # OrderPolicy

# 创建队列失败表
$ php artisan queue:failed-table

# 将所有配置文件 publish 出来
$ php artisan vendor:publish

# 重命名工厂文件之后需要执行 ，否则会找不到对应的工厂文件。
$ composer dumpautoload
# OR:
$ composer dump-autoload

# 清除配置文件缓存
$ php artisan config:clear
$ php artisan config:cache
# More:
$ php artisan cache:clear
$ php artisan config:clear
$ php artisan route:clear
$ php artisan view:clear

# 清除异步队列任务
$ php artisan queue:flush

# 数据库查询语句
> DB::connection()->enableQueryLog();
> info(DB::getQueryLog());

# 清空Redis数据
$ redis-cli
> SELECT 1
> FLUSHDB

```

## .env文件详解:

### 基础
- APP_NAME=`项目名称`
- APP_ENV=`开发:local 测试:testing 预上线:staging 正式环境: production`
- APP_KEY=`php artisan key:generate 生成`
- APP_DEBUG=`开启Debug:true   关闭Debug:false 生产环境必须关闭`
- APP_LOG_LEVEL=`日志记录的等级默认记录全部 debug 生成环境应该为:error`
- APP_URL=`项目的Url地址  http://www.xxx.com`
- DEBUGBAR_ENABLED=`是否开启 Debugbar`

## Composer 已安装插件:

### 安装 Laravel-ide-helper IDE & 模型注释助手

[GitHub: https://github.com/barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)

- php artisan ide-helper:generate - phpDoc generation for Laravel Facades
- php artisan ide-helper:models - phpDocs for models
- php artisan ide-helper:meta - PhpStorm Meta file

```
$ composer require [--dev] barryvdh/laravel-ide-helper
$ php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config

# After updating composer, add the service provider to the providers array in `config/app.php`:
$ vim config/app.php # config: append a row to $providers
----------------------------------------------------------
Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
----------------------------------------------------------
# Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

# In Laravel, instead of adding the service provider in the config/app.php file, you can add the following code to your `app/Providers/AppServiceProvider.php` file, within the register() method:
----------------------------------------------------------
public function register()
{
  if ($this->app->environment() !== 'production') {
      $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
  }
  // ...
}
----------------------------------------------------------
# This will allow your application to load the Laravel IDE Helper on non-production enviroments.

# 添加对应配置到 .gitignore 文件中：
$ vim .gitignore
-----------------------------
.idea
_ide_helper.php
_ide_helper_models.php
.phpstorm.meta.php
-----------------------------

# IDE助手:
$ php artisan ide-helper:generate

# 模型注释助手:
$ composer require [--dev] doctrine/dbal
$ php artisan ide-helper:models

$ php artisan ide-helper:meta
```

### 安装 Debugbar

[GitHub: https://github.com/barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)

```
$ composer require [--dev] barryvdh/laravel-debugbar

# 生成配置文件，存放位置 config/debugbar.php：
$ php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

# 打开 config/debugbar.php，将 enabled 的值设置为：
---------------------------------------------
'enabled' => env('DEBUGBAR_ENABLED', false),
---------------------------------------------
```

### 安装 中文语言包

[GitHub: https://github.com/overtrue/laravel-lang](https://github.com/overtrue/laravel-lang)

```
$ composer require overtrue/laravel-lang

$ vim config/app.php # replacement of TranslationServiceProvider
# After completion of the above, Replace the config/app.php content:
----------------------------------------------------------
Illuminate\Translation\TranslationServiceProvider::class,
----------------------------------------------------------
# with:
----------------------------------------------------------
Overtrue\LaravelLang\TranslationServiceProvider::class,
----------------------------------------------------------

# 然后修改系统语言，将原本的值 en 改成 zh-CN：
$ vim config/app.php
--------------------
'locale' => 'zh-CN',
--------------------
```

### 图片处理扩展包，支持裁剪、水印等处理

[GitHub: https://github.com/intervention/image](https://github.com/intervention/image)

```
$ composer require "intervention/image"

$ php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
# OR:
$ php artisan vendor:publish --provider="Intervention\Image\ImageServiceProvider"

$ vim config/app.php # config: append a row to $providers
----------------------------------------------
Intervention\Image\ImageServiceProvider::class,
----------------------------------------------

$ vim config/app.php # config: append a row to $aliases
----------------------------------------------
'Image' => Intervention\Image\Facades\Image::class,
----------------------------------------------
```

### Horizon 是 Laravel 生态圈里的一员，为 Laravel Redis 队列提供了一个漂亮的仪表板，允许我们很方便地查看和管理 Redis 队列任务执行的情况。

[GitHub: https://github.com/laravel/horizon](https://github.com/laravel/horizon)

```
# 使用 Composer 安装：
$ composer require laravel/horizon

# 安装完成后，使用 vendor:publish Artisan 命令发布相关文件：
$ php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"
# 分别是配置文件 config/horizon.php 和存放在 public/vendor/horizon 文件夹中的 CSS 、JS 等页面资源文件。

# Horizon 是一个监控程序，需要常驻运行，我们可以通过以下命令启动：
$ php artisan horizon

# 安装了 Horizon 以后，我们将使用 horizon 命令来启动队列系统和任务监控，无需使用 queue:listen。
```

### Eloquent-Sluggable: Easy creation of slugs for your Eloquent models in Laravel.

[GitHub: https://github.com/cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable)

```
# Installation
# 1. Install the package via Composer:
$ composer require cviebrock/eloquent-sluggable:^4.8
# The package will automatically register its service provider.
# 2. Optionally, publish the configuration file if you want to change any defaults:
$ php artisan vendor:publish --provider="Cviebrock\EloquentSluggable\ServiceProvider"

# Updating your Eloquent Models
# Your models should use the Sluggable trait, which has an abstract method sluggable() that you need to define. This is where any model-specific configuration is set (see Configuration below for details):
--------------------------------------------------------------
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
  use Sluggable;

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
      return [
          'slug' => [
              'source' => 'title',
          ]
      ];
  }
}
--------------------------------------------------------------

# An example using a custom getter:
--------------------------------------------------------------
class Person extends Eloquent
{
  use Sluggable;

  public function sluggable()
  {
      return [
          'slug' => [
              'source' => 'fullname'
          ]
      ];
  }

  public function getFullnameAttribute() {
      return $this->firstname . ' ' . $this->lastname;
  }
}
--------------------------------------------------------------

# SluggableScopeHelpers Trait
# Adding the optional `SluggableScopeHelpers` trait to your model allows you to work with models and their slugs. For example:
--------------------------------------------------------------
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

$post = Post::whereSlug($slugString)->get();

$post = Post::findBySlug($slugString);

$post = Post::findBySlugOrFail($slugString);
--------------------------------------------------------------
```

### encore/laravel-admin 扩展包

[GitHub: https://github.com/z-song/laravel-admin](https://github.com/z-song/laravel-admin)

```
# Installation
$ composer require encore/laravel-admin

$ php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

# 安装
$ php artisan admin:install

# 创建控制器
# Laravel-Admin 的控制器创建方式与普通的控制器创建方式不太一样，要用 admin:make 来创建：
$ php artisan admin:make UsersController --model=App\\Models\\User
# 其中 --model=App\\Models\\User 代表新创建的这个控制器是要对 App\Models\User 这个模型做增删改查。

# export initial migration seeder
$ php artisan admin:export-seed
# Note: 经过实测，该命令的运行结果差强人意，须参考扩展包文件 `vendor/encore/laravel-admin/src/Auth/Database/AdminTablesSeeder.php` 作必要之修正。
```

## Laravel Admin Extensions

[Introduction: https://laravel-admin.org/extensions](https://laravel-admin.org/extensions)

### Composer 查看器

[GitHub: https://github.com/laravel-admin-extensions/composer-viewer](https://github.com/laravel-admin-extensions/composer-viewer)

```
# Composer Viewer for Laravel-admin
# A web interface of composer packages in laravel.

# Installation
# Before you install, make sure the composer command can be executed globally.
$ composer require jxlwqq/composer-viewer

# If you want to add a link entry in the left menu, use the following command to import:
$ php artisan admin:import composer-viewer

# Configuration
# In the extensions section of the config/admin.php file, add configurations
$ vim config/admin.php
-------------------------------
'extensions' => [
  'composer-viewer' => [
      // Set this to false if you want to disable this extension
      'enable' => true,
  ]
]
-------------------------------

# Usage: Open http://your-host/admin/composer-viewer
# And you can find these installed packages.
```

### Config Manager 配置管理工具 [Not Supported Yet]

[GitHub: https://github.com/laravel-admin-extensions/config](https://github.com/laravel-admin-extensions/config)

```
# Config manager for laravel-admin

# Installation
$ composer require laravel-admin-ext/config

$ php artisan migrate

# Open app/Providers/AppServiceProvider.php, and call the Config::load() method within the boot method:
--------------------------------------------------------------
<?php

namespace App\Providers;

use Encore\Admin\Config\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  public function boot()
  {
      $table = config('admin.extensions.config.table', 'admin_config');
      if (Schema::hasTable($table)) {
          Config::load();
      }
  }
}
--------------------------------------------------------------

# Then run:
$ php artisan admin:import config

# Open http://your-host/admin/config
# Usage: After add config in the panel, use config($key) to get value you configured.
```

### Env 文件管理 .Env文件的web管理界面

[GitHub: https://github.com/laravel-admin-extensions/env-manager](https://github.com/laravel-admin-extensions/env-manager)

```
# Env Manager extension for laravel-admin

# Requirements
# laravel-admin >= 1.6

# Installation
$ composer require jxlwqq/env-manager

# If you want to add a link entry in the left menu, use the following command to import:
$ php artisan admin:import env-manager

# Configuration: Add extensions option in your config/admin.php configuration file:
$ vim config/admin.php
-------------------------------
'extensions' => [
  'env-manager' => [
      // If the value is set to false, this extension will be disabled
      'enable' => true
  ]
]
-------------------------------
```

### File Browser 文件浏览器 [Not Supported Yet]

[GitHub: https://github.com/laravel-admin-extensions/file-browser](https://github.com/laravel-admin-extensions/file-browser)

```
# a simple file browser extension for laravel-admin

# install 安装
$ composer require laravel-admin-ext/file-browser

# publish 发布media-manager的文件(如已发布，可跳过)
$ php artisan admin:import media-manager

# configuration 配置config/admin.php文件的 (本扩展共用media-manager的配置)
$ vim config/admin.php
-------------------------------
'extensions' => [

    'media-manager' => [

        // Select a local disk that you configured in `config/filesystem.php`
        'disk' => 'public'
    ],
],
-------------------------------

# register: append a line to app/Admin/bootstrap.php
$ vim app/Admin/bootstrap.php
-------------------------------
Encore\Admin\Form::extend('media', \Encore\FileBrowser\FileBrowserField::class);
-------------------------------

# demo of usage
-------------------------------
$form->media('ColumnName', 'LabelName')->path('uploads');
$form->media('ColumnName', 'LabelName')->path('uploads/images');
-------------------------------

# Note:
# 1.本扩展不支持识别目录(即文件夹)，仅识别path设定的一级目录下的所有文件；
# 2.本扩展默认可多选，字段存为json字符串，模型文件需添加如下修改器：
-------------------------------
/* Accessors */
public function getImagesAttribute($v)
{
    return json_decode($v, true);
}
-------------------------------
```

### Log Viewer 日志查看

[GitHub: https://github.com/laravel-admin-extensions/log-viewer](https://github.com/laravel-admin-extensions/log-viewer)

```
# Log viewer for laravel-admin 方便在管理后台查看日志

# Installation
$ composer require laravel-admin-ext/log-viewer [-vvv]

$ php artisan admin:import log-viewer

# Usage: Open http://localhost/admin/logs.
```

### Media manager 本地文件管理 [Not Supported Yet]

[GitHub: https://github.com/laravel-admin-extensions/media-manager](https://github.com/laravel-admin-extensions/media-manager)

```
# Media manager for laravel-admin

# Installation
$ composer require laravel-admin-ext/media-manager -vvv

$ php artisan admin:import media-manager

# Configuration: Add a disk config in config/admin.php:
$ vim config/admin.php
-------------------------------
'extensions' => [

  'media-manager' => [

      // Select a local disk that you configured in `config/filesystem.php`
      'disk' => 'public'
  ],
],
-------------------------------

# Usage: Open http://localhost/admin/media.
```

### phpinfo phpinfo()函数的web界面

[GitHub: https://github.com/laravel-admin-extensions/phpinfo](https://github.com/laravel-admin-extensions/phpinfo)

```
# Outputs information about PHP's configuration

# Installation
$ composer require laravel-admin-ext/phpinfo

# If you want to add a link entry in the left menu, use the following command to import
$ php artisan admin:import phpinfo

# Configuration
# In the extensions section of the config/admin.php file, add configurations
--------------------------------------------------------------
'extensions' => [

  'phpinfo' => [

      // Set this to false if you want to disable this extension
      'enable' => true,

      // What information to show，see http://php.net/manual/en/function.phpinfo.php#refsect1-function.phpinfo-parameters
      'what' => INFO_ALL,

      // Set access path，defaults to `phpinfo`
      //'path' => '~phpinfo',
  ]
]
--------------------------------------------------------------

# Usage
# Open http://localhost/admin/phpinfo in your broswer after install
```

### Redis Manager Redis 管理器 [Not Supported Yet]

[GitHub: https://github.com/laravel-admin-extensions/redis-manager](https://github.com/laravel-admin-extensions/redis-manager)

```
# Redis manager for laravel-admin 一个友好的Redis WEB管理工具

# Installation
$ composer require laravel-admin-ext/redis-manager

$ php artisan admin:import redis-manager

# Usage: Open http://your-host/admin/redis in your browser.
```

### wangEditor富文本编辑器 (基于wangEditor的富文本编辑器)

[GitHub: https://github.com/laravel-admin-extensions/wangEditor](https://github.com/laravel-admin-extensions/wangEditor)

```
# wangEditor extension for laravel-admin
# 这是一个laravel-admin扩展，用来将wangEditor集成进laravel-admin的表单中

# 安装
$ composer require laravel-admin-ext/wang-editor

# 然后
$ php artisan vendor:publish --tag=laravel-admin-wangEditor

# 配置
# 在 `config/admin.php` 文件的 `extensions`，加上属于这个扩展的一些配置:
--------------------------------------------------------------
'extensions' => [

  'wang-editor' => [

      // 如果要关掉这个扩展，设置为false
      'enable' => true,

      // 编辑器的配置
      'config' => [

      ]
  ]
]
--------------------------------------------------------------

# 编辑器的配置可以到wangEditor文档找到，比如配置上传图片的地址上传图片:
--------------------------------------------------------------
'config' => [
  // `/upload`接口用来上传文件，上传逻辑要自己实现，可参考下面的`上传图片`
  'uploadImgServer' => '/upload'
]
--------------------------------------------------------------

# Usage: 使用
# 在form表单中使用它：
--------------------------------------------------------------
$form->editor('content');
--------------------------------------------------------------

# 上传图片
# 图片上传默认使用base64格式化后与文本内容一起存入数据库，如果要上传图片到本地接口，那么下面是这个接口对应的action代码示例：
--------------------------------------------------------------
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

public function upload(Request $request)
{
  $urls = [];

  foreach ($request->file() as $file) {
      $urls[] = Storage::url($file->store('images'));
  }

  return [
      "errno" => 0,
      "data"  => $urls,
  ];
}
--------------------------------------------------------------
# Note: 配置路由指向这个action，存储的disk配置在config/filesystem.php中，这个需参考laravel官方文档。
```

