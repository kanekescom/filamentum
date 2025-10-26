<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Filamentum') }}</title>
        <style>
            :root {
                color-scheme: light dark;
            }
            body {
                margin: 0;
                padding: 0;
                font-family: system-ui, -apple-system, sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #fff;
                color: #1a1a1a;
            }
            @media (prefers-color-scheme: dark) {
                body {
                    background: #0f172a;
                    color: #fff;
                }
                .nav-link {
                    color: #94a3b8 !important;
                }
                .nav-link:hover {
                    color: #fff !important;
                }
            }
            .container {
                text-align: center;
                padding: 2rem;
            }
            .product-name {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .description {
                font-size: 1.25rem;
                color: #666;
                margin-bottom: 2rem;
            }
            @media (prefers-color-scheme: dark) {
                .description {
                    color: #94a3b8;
                }
            }
            .links {
                display: flex;
                gap: 1.5rem;
                justify-content: center;
                flex-wrap: wrap;
            }
            .link {
                text-decoration: none;
                color: #e2e8f0;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
                background-color: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                font-weight: 500;
                margin: 0 0.5rem;
            }
            .link:hover {
                color: #fff;
                background-color: rgba(255, 255, 255, 0.2);
                border-color: rgba(255, 255, 255, 0.4);
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            @media (prefers-color-scheme: dark) {
                .link {
                    color: #e2e8f0;
                    background-color: rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }
                .link:hover {
                    color: #fff;
                    background-color: rgba(255, 255, 255, 0.2);
                    border-color: rgba(255, 255, 255, 0.4);
                }
            }
            .nav {
                position: absolute;
                top: 1rem;
                right: 1rem;
            }
            .nav-links {
                display: flex;
                gap: 1rem;
            }
            .nav-link {
                text-decoration: none;
                color: #666;
                font-size: 0.875rem;
                transition: color 0.2s;
            }
            .nav-link:hover {
                color: #1a1a1a;
            }
        </style>
    </head>
    <body>
        @if (Route::has('filament.app.auth.login'))
            <nav class="nav">
                <div class="nav-links">
                    @auth
                        <a href="{{ route('filament.app.pages.dashboard') }}" class="nav-link">Dashboard</a>
                    @else
                        @if (Route::has('filament.app.auth.login'))
                            <a href="{{ route('filament.app.auth.login') }}" class="nav-link">Log in</a>
                        @endif
                        @if (Route::has('filament.app.auth.register'))
                            <a href="{{ route('filament.app.auth.register') }}" class="nav-link">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        @endif

        <main class="container">
            <h1 class="product-name">Filamentum</h1>
            <p class="description">Laravel 12 starter kit with popular and essential packages pre-installed.</p>

            <div class="links">
                <a href="https://github.com/kanekescom/filamentum" class="link">Repository</a>
                <a href="https://github.com/kanekescom/filamentum?tab=readme-ov-file#filamentum" class="link">Get Started</a>
            </div>
        </main>
    </body>
</html>
