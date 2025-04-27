# Google Authentication (Google Login) in Laravel

This guide walks you through enabling Google Login in your Laravel app using [Laravel Socialite](https://laravel.com/docs/10.x/socialite).

---

## 1. Install Laravel Socialite

```bash
composer require laravel/socialite
```

---

## 2. Get Google OAuth Credentials

- Visit https://console.developers.google.com/
- Create a new project or select an existing one
- Go to **APIs & Services > Credentials**
- Click **Create Credentials > OAuth client ID**
- **Application type:** Web application
- **Authorized redirect URIs:**  
  `http://your-domain.com/auth/google/callback`

Copy the **Client ID** and **Client Secret**.

---

## 3. Configure `.env` and `config/services.php`

### In `.env` file

```
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://your-domain.com/auth/google/callback
```

### In `config/services.php`

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

---

## 4. Create Routes

In `routes/web.php`:

```php
use App\Http\Controllers\GoogleAuthController;

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
```

---

## 5. Create the Controller

Generate a controller (if needed):

```bash
php artisan make:controller GoogleAuthController
```

Then add the implementation as shown in the code artifact.

---

## 6. Add Login Button to Your Frontend

```html
<a href="{{ route('google.login') }}">Login with Google</a>
```

---

## 7. Test

Visit `/auth/google` and ensure everything works!