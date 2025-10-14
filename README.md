# Filamentum

<p align="center">
<a href="https://github.com/kanekescom/filamentum/actions"><img src="https://github.com/kanekescom/filamentum/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/kanekescom/filamentum"><img src="https://img.shields.io/packagist/dt/kanekescom/filamentum" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/kanekescom/filamentum"><img src="https://img.shields.io/packagist/v/kanekescom/filamentum" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/kanekescom/filamentum"><img src="https://img.shields.io/github/license/kanekescom/filamentum" alt="License"></a>
</p>

## About

Filamentum is a Laravel starter kit with Filament admin panel.

## Installation

You can install Filamentum in two ways:

### 1. Via Laravel Installer

Create a new project using Laravel installer with Filamentum as the starter kit:

```bash
laravel new my-app --using=kanekescom/filamentum
```

### 2. Via Composer

You can install Filamentum in two ways:

a. Using Composer Create-Project:
```bash
composer create-project kanekescom/filamentum my-app
```

b. Clone from GitHub:
```bash
git clone https://github.com/kanekescom/filamentum.git my-app
cd my-app
composer install
```

After installation, your application will be ready with all the essential packages and configurations set up.

## AI Coding Assistance

For developers using AI coding assistants, run the following command to install the MCP server and coding guidelines:

```bash
php artisan boost:install
```

This will set up the Model Context Protocol (MCP) server and configure coding guidelines that enhance your AI-assisted development experience.

### Keeping Guidelines Up-to-Date

You may want to periodically update your local AI guidelines to ensure they reflect the latest versions of the Laravel ecosystem packages you have installed. To do so, you can use the boost:update Artisan command:

```bash
php artisan boost:update
```

You may also automate this process by adding it to your Composer "post-update-cmd" scripts:

```json
{
  "scripts": {
    "post-update-cmd": [
      "@php artisan boost:update --ansi"
    ]
  }
}
```

## Laravel Octane

This project comes with Laravel Octane pre-installed for high-performance serving of your Laravel application. To use Octane with FrankenPHP (the default server for this project), you need to run the installation command:

```bash
php artisan octane:install
```

When prompted, select "frankenphp" as your server.

After installation, you can start your application using Octane with:

```bash
php artisan octane:start
```

For more information about Laravel Octane configuration and usage, please refer to the [official Laravel Octane documentation](https://laravel.com/docs/12.x/octane).

## Installed Packages

Filamentum comes with several pre-installed packages to help you build your application:

- [laravel/octane](https://github.com/laravel/octane) v2 - Laravel Octane for high-performance Laravel applications with FrankenPHP
- [laravel/boost](https://github.com/laravel/boost) v1 - Laravel Boost for enhanced development experience with Laravel
- [laravel/telescope](https://github.com/laravel/telescope) v5 - Laravel Telescope for debugging and monitoring your Laravel applications
- [filament/filament](https://github.com/filamentphp/filament) v4 - A collection of beautiful TALL stack admin panel components
- [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) v6 - Easily build Eloquent queries from API requests
- [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) v3 - Laravel Debugbar for debugging and profiling your Laravel applications
- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) v3 - IDE Helper for generating helper files for Laravel facades and adding PHPDocs

## License

Filamentum is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
