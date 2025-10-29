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
            * {
                box-sizing: border-box;
            }
            body {
                margin: 0;
                padding: 0;
                font-family: system-ui, -apple-system, sans-serif;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background: #fff;
                color: #1a1a1a;
                overflow-x: hidden;
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
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 2rem;
                max-width: 800px;
                margin: 0 auto;
                width: 100%;
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
                max-width: 600px;
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
                width: 100%;
            }
            .link {
                text-decoration: none;
                color: #3b82f6;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
                background-color: transparent;
                border: 1px solid #3b82f6;
                font-weight: 500;
                margin: 0 0.5rem;
                white-space: nowrap;
            }
            .link:hover {
                color: #3b82f6;
                background-color: rgba(59, 130, 246, 0.1);
                border-color: #3b82f6;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .link-primary {
                background-color: #3b82f6;
                color: white;
                border: 1px solid #3b82f6;
            }
            .link-primary:hover {
                color: white;
                background-color: #2563eb;
                border-color: #2563eb;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            @media (prefers-color-scheme: dark) {
                .link {
                    color: #93c5fd;
                    border: 1px solid #93c5fd;
                }
                .link:hover {
                    color: #93c5fd;
                    background-color: rgba(147, 197, 253, 0.1);
                    border-color: #93c5fd;
                }
                .link-primary {
                    background-color: #3b82f6;
                    color: white;
                    border: 1px solid #3b82f6;
                }
                .link-primary:hover {
                    color: white;
                    background-color: #2563eb;
                    border-color: #2563eb;
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
                font-weight: 500;
            }
            .nav-link:hover {
                color: #1a1a1a;
            }
            @media (prefers-color-scheme: dark) {
                .nav-link:hover {
                    color: #fff;
                }
            }
            footer {
                text-align: center;
                padding: 1.5rem 1rem 1rem;
                color: #666;
                font-size: 0.875rem;
            }
            @media (prefers-color-scheme: dark) {
                footer {
                    color: #94a3b8;
                }
            }
            .copyright {
                margin-top: 0.5rem;
                font-size: 0.8rem;
            }
            @media (max-width: 768px) {
                body {
                    overflow-x: hidden;
                }
                .container {
                    padding: 1rem;
                }
                .product-name {
                    font-size: 2rem;
                }
                .description {
                    font-size: 1rem;
                }
                .links {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: center;
                }
                .link {
                    width: 100%;
                    max-width: 300px;
                    margin: 0;
                }
                .nav {
                    position: absolute;
                    top: 0.5rem;
                    right: 0.5rem;
                }
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
            <p class="description">Laravel 12 starter kit with the Filament admin panel and essential packages pre-installed.</p>

            <div class="links">
                <a href="https://github.com/kanekescom/filamentum" class="link">View on GitHub</a>
                <a href="https://github.com/kanekescom/filamentum?tab=readme-ov-file#filamentum" class="link link-primary">Get Started</a>
            </div>
        </main>

        <footer>
            <p>Built with Laravel and Filament.</p>
            <p class="copyright">© {{ date('Y') }} <a href="https://filamentum.kanekes.com" style="color: #3b82f6; text-decoration: none;">Filamentum</a>. A product of <a href="https://kanekes.com" style="color: #3b82f6; text-decoration: none;">Kanekes</a>.</p>
        </footer>
    </body>
</html>
