# Deploying Asian Groom to Hostinger

This app is a standard Laravel 10 + Filament 3 project (PHP ^8.1, MySQL, Vite for
frontend assets). There's no queue worker, no scheduled commands, and no payment
gateway integration yet, so the deploy is a plain "upload code, point the domain
at `public/`, run migrations" setup.

## 0. What you need on the Hostinger side

- A **Business** (or higher) hosting plan, or a VPS/Cloud plan. Shared **Premium**
  plans don't give SSH or Composer access, which this guide assumes.
- PHP **8.1 or newer** selected for the domain (hPanel → Advanced → PHP Configuration).
- A MySQL database + user created in hPanel → Databases → MySQL Databases.
- SSH access enabled (hPanel → Advanced → SSH Access).

## 1. Build assets locally first

Hostinger's shared/Business PHP environment doesn't have Node.js, so compile the
frontend before you upload anything:

```bash
npm ci
npm run build
```

This produces `public/build/` — make sure it's included in whatever you upload
(it's git-ignored for local dev, so a plain `git pull` on the server won't have it;
either run the build on a machine that then uploads over SFTP, or drop `/public/build`
from `.gitignore` for deploys, or build in a CI step that uploads the artifact).

## 2. Get the code onto the server

Pick one:

**Git (recommended, needs SSH + Composer via SSH):**
```bash
ssh u123456789@your-server -p 65002
cd domains/yourdomain.com
git clone <your-repo-url> app
cd app
```

**SFTP/ZIP upload:** zip the whole project (excluding `/vendor` and `/node_modules`,
including the built `/public/build`), upload via File Manager or FileZilla, extract
it into a folder outside the public web root, e.g. `domains/yourdomain.com/app`.

Either way, **do not** put the Laravel project directly in `public_html`. Keep it
in a sibling folder (e.g. `app/`) and point the domain's document root at
`app/public` instead — this keeps `.env`, `app/`, `storage/`, etc. unreachable from
the web.

To set the document root: hPanel → **Domains** → your domain → **Manage** →
**Advanced** → **Website → Change document root**, and set it to
`domains/yourdomain.com/app/public`.

> If your plan doesn't let you change the document root, the fallback is to put
> the whole app in `public_html/app` and copy the contents of `app/public/` into
> `public_html/` (keeping `index.php`), then edit the two `require`/`define` paths
> at the top of that `index.php` to point at `../app/vendor/autoload.php` and
> `../app/bootstrap/app.php`. The document-root approach above is much cleaner —
> use it if at all possible.

## 3. Install PHP dependencies

```bash
cd app   # wherever you cloned/uploaded it
composer install --no-dev --optimize-autoloader
```

## 4. Configure `.env`

Copy `.env.example` to `.env` and fill in the real values:

```bash
cp .env.example .env
php artisan key:generate
```

Key values to set:

```env
APP_NAME="Asian Groom"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_agsite      # from hPanel → MySQL Databases
DB_USERNAME=u123456789_agadmin
DB_PASSWORD=your-db-password

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync              # no queued jobs in this app — sync is fine
FILESYSTEM_DISK=local

MAIL_MAILER=smtp                   # only needed once a mail feature is wired up
```

Leave `MAIL_*`, `GOOGLE_*`, and `META_PIXEL_*` for later — those are configured
from the admin panel (Settings → SEO Settings) once the site is live, not from
`.env`.

## 5. Database & storage

```bash
php artisan migrate --force
php artisan storage:link
```

`storage:link` creates the `public/storage` symlink that serves everything
uploaded through the admin panel (banner video/image, product photos, collection
videos). This symlink is git-ignored and must be created on the server — it won't
come across in a git pull or zip upload.

> Some shared hosts disable `symlink()`. If `storage:link` errors out, as a
> workaround you can instead copy `storage/app/public/` into `public/storage/`
> and re-copy it after every upload — but try the real symlink first; Hostinger's
> Business/Cloud plans generally allow it.

## 6. Create an admin login

There's no seeded admin user. Create one so you can log into `/admin`:

```bash
php artisan make:filament-user
```

Follow the prompts for name/email/password.

## 7. Cache the config/routes/views for production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Re-run these three any time you change `.env`, routes, or a config file — cached
config means `.env` changes won't take effect until you `config:cache` again (or
`config:clear`).

## 8. File permissions

```bash
chmod -R 755 storage bootstrap/cache
```

The web server user needs write access to `storage/` (logs, sessions, cache,
uploaded files) and `bootstrap/cache/`.

## 9. HTTPS

Turn on Hostinger's free SSL (hPanel → Security → SSL) and keep `APP_URL` on
`https://`. The app doesn't force a redirect from HTTP to HTTPS itself, so also
enable "Force HTTPS" under hPanel → Domains → your domain, or add it via `.htaccess`.

## 10. Smoke test

- `https://yourdomain.com/` — homepage loads, banner video/image shows, product
  grid shows the newest products first.
- `https://yourdomain.com/admin` — log in with the user from step 6.
- Upload a test image via Settings → Home Banner in the admin and confirm it
  renders on the homepage (this exercises the `storage:link` setup end-to-end).
- Place a test order through checkout and confirm it shows up under Admin → Orders.

## Redeploying after future changes

```bash
git pull                      # or re-upload changed files
composer install --no-dev --optimize-autoloader
npm run build                 # done locally, then upload public/build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If you only changed PHP/Blade code and no new migrations or assets, the cache
commands are the only step that matters — skip `migrate` if nothing changed in
`database/migrations/`.

## Notes specific to this project

- No queue worker or cron job is required today — there are no scheduled
  commands in `app/Console/Kernel.php` and no `ShouldQueue` jobs in the codebase.
  If that changes later (e.g. queued emails), add a Hostinger cron entry for
  `php artisan schedule:run` every minute and configure a real queue driver.
- No payment gateway is wired in — checkout currently just records the order.
- `storage/app/public/` (product photos, collection videos) is tracked in git in
  this repo, so a `git pull` brings existing media across; only new uploads made
  through the admin panel need the storage symlink from step 5 to be reachable.
