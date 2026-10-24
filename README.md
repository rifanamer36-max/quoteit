# Edrak! (QuoteIt)

سطورٌ تشرح ما تشعر به — a website to read, share, and feel quotes.

Built with Laravel, MySQL, Laravel Breeze, Blade, Tailwind CSS, and Alpine.js.

## Features

- View all quotes without logging in
- Sign up, log in, log out
- Share a quote (3 to 155 characters) with a mood
- Edit (text and mood) and delete your own quotes only
- Like and unlike quotes, with a like counter
- Mood compass: filter quotes by Hope, Calm, Philosophy, or Motivation
- Insight of the Day: one highlighted quote each day
- Quote card: turn a quote into a downloadable PNG (made in the browser)
- Calm session: full-screen quotes for a moment of focus
- My Insights: save quotes to your own page

## Project Structure

- **Frontend:** `resources/views/`, `resources/css/`, `resources/js/`
- **Backend:** `app/Http/Controllers/`, `app/Http/Requests/`, `app/Models/`, `app/Policies/`, `routes/web.php`
- **Database:** `database/migrations/`, `database/seeders/`
- **Tests:** `tests/Feature/QuoteTest.php`
- **Documentation:** `docs/QuoteIt_SRS.docx`

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
php artisan migrate --seed
npm run build
php artisan serve
```

Open (`http://127.0.0.1:8000`)
(a local address: it works only while `php artisan serve` is running).

Demo accounts created by the seeder (password: `password`): `sara@example.com` and `omar@example.com`.

## Tests

```bash
php artisan test --filter=QuoteTest
```
