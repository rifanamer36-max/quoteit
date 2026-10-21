# Edrak!
سطورٌ تشرح ما تشعر به — a quotes website to read, share, and feel quotes.

Built with Laravel, MySQL, Laravel Breeze, Blade, Tailwind CSS, and Alpine.js.

## Features

- View all quotes without logging in
- Sign up, log in, log out
- Share a quote (3 to 155 characters) with a mood
- Edit and delete your own quotes only
- Like and unlike quotes, with a like counter
- Mood compass: filter quotes by Hope, Calm, Philosophy, or Motivation
- Insight of the Day: one highlighted quote each day
- Quote card: turn a quote into a downloadable PNG image
- Calm session: full-screen quotes for a moment of focus

## Project Structure

- **Frontend:** `resources/views/`, `resources/css/`, `resources/js/`
- **Backend:** `app/Http/Controllers/`, `app/Models/`, `app/Policies/`, `routes/web.php`
- **Database:** `database/migrations/`

## Added Features

Guest Account Registration: Added a option to quickly sign up for a new user account.
Quote Mood Selection: Enabled attaching a specific mood (Hope, Calm, Philosophy, Motivation) when adding or editing quotes.
Downloadable Quote Cards: Implemented exporting quotes as downloadable PNG image cards.
Calm Session View: Designed a full-screen, focused quotes display mode for uninterrupted reading.
Database-Enforced Like System: Logged-in users can like/unlike quotes with real-time counters, secured by a unique database constraint on the quote_likes table to prevent duplicate likes.

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
