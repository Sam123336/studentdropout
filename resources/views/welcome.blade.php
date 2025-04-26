<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | Your App</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|inter:300,400,500,600" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-container {
            max-width: 1200px;
            width: 100%;
            display: flex;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .auth-image {
            flex: 1;
            background-image: url('/api/placeholder/600/800');
            background-size: cover;
            background-position: center;
            display: none;
        }
        
        .auth-content {
            flex: 1;
            background-color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            font-family: 'Instrument Sans', sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: #1a202c;
        }
        
        h1 {
            font-size: 2.4rem;
            margin-bottom: 1rem;
            color: #1a202c;
            font-weight: 600;
        }
        
        p {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        
        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: #3182ce;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #2c5282;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: white;
            color: #2d3748;
            border: 1px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            background-color: #f7fafc;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }
        
        .dashboard-link {
            margin-top: 2rem;
            text-align: center;
        }
        
        .dashboard-link a {
            color: #3182ce;
            text-decoration: none;
            font-weight: 500;
        }
        
        .dashboard-link a:hover {
            text-decoration: underline;
        }
        
        .dark-mode-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: #718096;
            font-size: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .auth-image {
                display: block;
            }
            
            .auth-buttons {
                flex-direction: row;
            }
        }
    </style>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="auth-container">
        <div class="auth-image"></div>
        <div class="auth-content">
            @auth
                <!-- Show only Dashboard when logged in -->
                <div class="logo">YourApp</div>
                <h1>Welcome Back</h1>
                <p>You are currently logged in. Access your personal dashboard to manage your account.</p>
                <div class="auth-buttons">
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                </div>
            @else
                <!-- Show Login/Register when logged out -->
                <div class="logo">YourApp</div>
                <h1>Welcome</h1>
                <p>Access your account or create a new one to get started with our platform.</p>
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
    
    <button class="dark-mode-toggle">☀️</button>
    
    <script>
        // Simple dark mode toggle
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const body = document.body;
        const container = document.querySelector('.auth-content');
        
        darkModeToggle.addEventListener('click', () => {
            body.style.background = body.style.background.includes('linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%)') ? 
                'linear-gradient(135deg, #1a202c 0%, #2d3748 100%)' : 
                'linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%)';
            
            container.style.backgroundColor = container.style.backgroundColor === 'white' ? '#1a202c' : 'white';
            container.style.color = container.style.color === '#718096' ? '#a0aec0' : '#718096';
            
            const logo = document.querySelector('.logo');
            const heading = document.querySelector('h1');
            
            logo.style.color = logo.style.color === '#1a202c' ? '#f7fafc' : '#1a202c';
            heading.style.color = heading.style.color === '#1a202c' ? '#f7fafc' : '#1a202c';
            
            darkModeToggle.innerHTML = darkModeToggle.innerHTML === '☀️' ? '🌙' : '☀️';
        });
    </script>
</body>
</html>