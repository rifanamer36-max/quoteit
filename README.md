# QuoteIt

A simple website where anyone can read quotes, and registered users can share, edit, delete, and like quotes.

Built with Laravel, MySQL, Laravel Breeze, Blade, Tailwind CSS, and Alpine.js.

## Features

- View all quotes without logging in
- Sign up, log in, log out
- Share a quote (3 to 155 characters)
- Edit and delete your own quotes only
- Like and unlike quotes, with a like counter (added feature)

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

Open http://127.0.0.1:8000

## Documentation

The full requirements are in `docs/QuoteIt_SRS.docx`.
