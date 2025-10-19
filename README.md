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

## Creating a User

To access the Filament admin panel, you'll need to create a user account. You have several options:

### Option 1: Interactive Command

Run the following command to create a new Filament user interactively:

```bash
php artisan make:filament-user
```

This command will prompt you to enter the user's name, email, and password.

### Option 2: Database Seeding

Alternatively, you can create default users with predefined roles by running the database seeder:

```bash
php artisan db:seed
```

This will create users with the following credentials and roles:

| Name              | Email                     | Role        | Password  |
|-------------------|---------------------------|-------------|-----------|
| Super Admin User  | superadmin@filamentum.com | Super Admin | password  |
| Admin User        | admin@filamentum.com      | Admin       | password  |
| Regular User      | user@filamentum.com       | User        | password  |

Additionally, a default administrator user will be created:
- Name: `Filamentum Administrator`
- Email: `filamentum@example.com`
- Password: `password`
- Role: Default admin access

Once created, you can log in to the admin panel at `/admin` using these credentials.

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

- [laravel/octane](https://github.com/laravel/octane) v2 - Supercharge your Laravel application's performance with high-powered application servers
- [laravel/boost](https://github.com/laravel/boost) v1 - Laravel Boost for enhanced AI-assisted development experience with Laravel
- [laravel/sail](https://github.com/laravel/sail) v1 - Docker files for running a basic Laravel application
- [laravel/telescope](https://github.com/laravel/telescope) v5 - An elegant debug assistant for the Laravel framework
- [filament/filament](https://github.com/filamentphp/filament) v4 - A powerful open source UI framework for Laravel to build admin panels & apps fast
- [bezhansalleh/filament-shield](https://github.com/bezhanSalleh/filament-shield) v4 - Easily manage roles & permissions for Filament's resources, pages & widgets through spatie/laravel-permission
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission) v6 - Permission handling for Laravel with roles and permissions management
- [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) v6 - Easily build Eloquent queries from API requests
- [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) v3 - Debugbar for Laravel (Integrates PHP Debug Bar)
- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) v3 - IDE Helper for generating helper files for Laravel facades and adding PHPDocs

## Recommended Additional Packages

To further enhance your Laravel application, consider adding these recommended packages:

- [laravel/horizon](https://github.com/laravel/horizon) - Dashboard and code-driven configuration for Laravel queues
- [laravel/nightwatch](https://github.com/laravel/nightwatch) - Laravel Nightwatch for application monitoring and performance insights
- [laravel/passport](https://github.com/laravel/passport) - OAuth2 server and API authentication package that is simple and enjoyable to use
- [laravel/sanctum](https://github.com/laravel/sanctum) v - Featherweight authentication system for SPAs and simple APIs
- [laravel/socialite](https://github.com/laravel/socialite) - Laravel Socialite for OAuth authentication with social networks
- [sentry/sentry-laravel](https://github.com/getsentry/sentry-laravel) - The official Laravel SDK for Sentry error tracking and monitoring

Refer to each package's documentation for specific installation and configuration instructions.

## License

Filamentum is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
