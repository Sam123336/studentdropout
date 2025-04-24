<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- 3D Effect Styles -->
        <style>
            /* Custom 3D styling */
            .text-3d {
                text-shadow: 0 4px 0 #4338ca, 0 8px 10px rgba(0,0,0,0.5);
                transform: perspective(500px) rotateX(5deg);
            }
            
            .card-3d {
                box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5), 0 8px 10px -6px rgba(0,0,0,0.3);
                transition: all 0.3s ease;
            }
            
            .card-3d:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5), 0 10px 10px -6px rgba(0,0,0,0.3);
            }
            
            .button-3d {
                box-shadow: 0 4px 0 #4338ca, 0 4px 6px rgba(0,0,0,0.3);
                transition: all 0.2s ease;
            }
            
            .button-3d:hover {
                transform: translateY(-2px) scale(1.05);
                box-shadow: 0 6px 0 #4338ca, 0 6px 8px rgba(0,0,0,0.3);
            }
            
            .button-3d:active {
                transform: translateY(0) scale(0.98);
                box-shadow: 0 2px 0 #4338ca, 0 2px 4px rgba(0,0,0,0.3);
            }
            
            .icon-3d {
                filter: drop-shadow(0 2px 2px rgba(0,0,0,0.3));
            }
            
            .text-shadow-sm {
                text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            }
            
            .text-shadow-md {
                text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            }
            
            /* Custom pagination styling */
            .pagination-dark nav {
                display: flex;
                justify-content: center;
            }

            .pagination-dark span, 
            .pagination-dark a {
                margin: 0 0.25rem;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            }

            .pagination-dark span[aria-current="page"] span {
                background-color: #4f46e5;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0,0,0,0.4);
            }

            .pagination-dark a {
                background-color: #374151;
                color: #e5e7eb;
                transition: all 0.2s ease;
            }

            .pagination-dark a:hover {
                background-color: #4b5563;
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0,0,0,0.4);
            }

            .pagination-dark svg {
                height: 1rem;
                width: 1rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-950">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-900 shadow-lg">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-white text-shadow-md">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        @yield('scripts')
    </body>
</html>