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
# 配置 Aliyun packagist
$ composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

$ composer create-project --prefer-dist laravel/laravel demoHub
```

## .gitignore

```
$ vim .gitignore

.idea
/node_modules
/public/fonts
/public/hot
/public/storage
/storage/*.key
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
# 创建API 控制器
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

- php artisan ide-helper:generate - phpDoc generation for Laravel Facades
- php artisan ide-helper:models - phpDocs for models
- php artisan ide-helper:meta - PhpStorm Meta file

```
$ composer require [--dev] barryvdh/laravel-ide-helper
$ php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config
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

```
$ composer require overtrue/laravel-lang

# 然后修改系统语言，将原本的值 en 改成 zh-CN：
$ vim config/app.php
--------------------
'locale' => 'zh-CN',
--------------------
```

### 图片处理扩展包，支持裁剪、水印等处理

```
$ composer require "intervention/image"

$ php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
# OR:
$ php artisan vendor:publish --provider="Intervention\Image\ImageServiceProvider"

$ vim config/app.php # config: apend a row to $providers
----------------------------------------------
Intervention\Image\ImageServiceProvider::class,
----------------------------------------------

$ vim config/app.php # config: apend a row to $aliases
----------------------------------------------
'Image' => Intervention\Image\Facades\Image::class,
----------------------------------------------
```

### Horizon 是 Laravel 生态圈里的一员，为 Laravel Redis 队列提供了一个漂亮的仪表板，允许我们很方便地查看和管理 Redis 队列任务执行的情况。
```
# 使用 Composer 安装：
$ composer require laravel/horizon
# 安装完成后，使用 vendor:publish Artisan 命令发布相关文件：
$ php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"
# 分别是配置文件 config/horizon.php 和存放在 public/vendor/horizon 文件夹中的 CSS 、JS 等页面资源文件。

# Horizon 是一个监控程序，需要常驻运行，我们可以通过以下命令启动：
& php artisan horizon
# 安装了 Horizon 以后，我们将使用 horizon 命令来启动队列系统和任务监控，无需使用 queue:listen。
```

### encore/laravel-admin 扩展包
```
$ composer require encore/laravel-admin

$ php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

# 安装
$ php artisan admin:install

# 创建控制器
# Laravel-Admin 的控制器创建方式与普通的控制器创建方式不太一样，要用 admin:make 来创建：
$ php artisan admin:make UsersController --model=App\\Models\\User
# 其中 --model=App\\Models\\User 代表新创建的这个控制器是要对 App\Models\User 这个模型做增删改查。
```

