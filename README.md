# QuoteIt

A simple website where anyone can read quotes, and registered users can share, edit, delete, and like quotes.

Built with Laravel, MySQL, Laravel Breeze, Blade, Tailwind CSS, and Alpine.js.

## Features

- View all quotes without logging in
- Sign up, log in, log out
- Share a quote (3 to 155 characters)
- Edit and delete your own quotes only
- Like and unlike quotes, with a like counter (added feature)

## Project Structure

- **Frontend:** `resources/views/`, `resources/css/`, `resources/js/`
- **Backend:** `app/Http/Controllers/`, `app/Models/`, `app/Policies/`, `routes/web.php`
- **Database:** `database/migrations/`

## Added Feature (Likes)

Logged-in users can like and unlike any quote, and everyone, including guests, can see the like count. A user can like a quote only once, which is enforced by a unique constraint in the database (`quote_likes` table).

## How to run

Requirements: PHP 8.2+, Composer, MySQL, Node.js

```bash
git clone https://github.com/rifanamer36-max/quoteit.git
cd quoteit
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create a MySQL database named `quoteit`, then set these in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quoteit
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate
npm run build
php artisan serve
```

Then open (`http://127.0.0.1:8000`) in your browser.

> Note: this is a local address. It works only on the computer where `php artisan serve` is running, so the app is not hosted online.

## Documentation

The full requirements are in [docs/QuoteIt_SRS.docx](docs/QuoteIt_SRS.docx).
