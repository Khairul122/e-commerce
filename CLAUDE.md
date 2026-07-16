# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

PHP-native (no framework, no Composer) MVC e-commerce site for UKM ARC, a home-based pastry/ready-to-eat food business in Padang. Backend is hand-rolled MVC on plain PHP 8.3 + PDO/MySQL; frontend is server-rendered PHP views styled with Tailwind CSS via CDN (no npm/build step). Requirements and full feature spec live in `PRD.pdf` at the repo root — consult it before adding features not already listed in README.md.

## Commands

```bash
# Import schema (run once, or after schema.sql changes)
mysql -u root < database/schema.sql

# Seed demo data (categories, dummy products, admin user, testimonials, banners, settings)
php database/seed.php

# Syntax-check every PHP file (there is no test suite / PHPUnit in this project)
find app config public database -name "*.php" -exec php -l {} \;
```

There is no build step, linter, or automated test suite. Verification is done by syntax-checking (`php -l`) plus manual/curl smoke tests against a running Laragon Apache+MySQL instance.

**Run the app**: via Laragon, accessed at `http://e-commerce.test/` (Laragon's auto vhost, document root = repo root). Do **not** access it as `http://localhost/e-commerce/` — the router matches raw `REQUEST_URI` against route patterns with no subfolder-prefix handling, so it only works when the vhost's document root is the project root itself.

Default accounts (seeded): admin `admin@ukmarc.test` / `admin123`; customer `customer@example.test` / `customer123`.

## Architecture

**Request flow**: every request hits `public/index.php` (front controller) via `.htaccess` rewrites (root `.htaccess` → `public/`, then `public/.htaccess` → `index.php`). `index.php` registers a `spl_autoload_register` namespace-to-path autoloader, then builds an `App\Core\Router` with an explicit regex-based route table (see the route list directly in `index.php` — there's no controller attribute/annotation discovery). Route handlers are strings like `'ProductController@show'` or `'Admin\\ProductController@index'`, with an optional middleware array (`['auth']`, `['admin']`) checked before dispatch.

**Namespace-to-folder mapping** (enforced by the autoloader in `public/index.php`):
- `App\Core\*` → `app/core/`
- `App\Models\*` → `app/models/`
- `App\Controllers\Admin\*` → `app/controllers/admin/`
- `App\Controllers\*` → `app/controllers/`

Public and admin controllers can reuse the same class name (e.g. `ProductController`) because they live in different namespaces — this is why the `Admin\` prefix matters in route handler strings.

**Core classes** (`app/core/`):
- `Database.php` — PDO singleton (`Database::getInstance()`), `ERRMODE_EXCEPTION`, utf8mb4.
- `Router.php` — regex route matching, `{param}` placeholders, runs `auth`/`admin` middleware (checks `$_SESSION['user']['role']`) before calling the handler.
- `Controller.php` — base class every controller extends. Provides `view()`, `redirect()`, `requireLogin()`/`requireAdmin()`, `csrfToken()`/`verifyCsrf()` (call `verifyCsrf()` at the top of every POST handler — CSRF failures return **403**, not 419: Apache remaps unrecognized status codes like 419 to 500), `json()`, `input()`, `old()`/`setOld()` (flash old form input via session), `flash()`/`getFlash()` (one-shot session flash messages).
- `Model.php` — base class with generic `all()/find()/where()/create()/update()/delete()`. Complex queries (joins, aggregates) are written as bespoke methods directly on the model (e.g. `Order::createOrderWithItems()`, `Product::getActive()`), not forced through the generic query builder.
- `UploadHelper.php` — `validateAndMove()` checks MIME via `finfo_file()` (not just extension), enforces size limits, and writes a `uniqid()`-based filename. Used by both admin product-image uploads and customer payment-proof uploads.
- `helpers.php` — global functions (not namespaced): `e()` (htmlspecialchars), `rupiah()` (currency format), `slugify()`, `generateOrderCode()`, `uploadUrl()`.

**Uploads are served through a proxy, never directly**: `uploads/{products,payment_proofs,banners,testimonials}/` live outside `public/` and are also `.htaccess`-denied. All image `src` attributes go through `public/uploads.php?type=...&file=...`, which validates the type whitelist, uses `basename()` to block path traversal, re-checks MIME before streaming, and sets `Content-Type` explicitly. Use the `uploadUrl($type, $filename)` helper in views rather than constructing these URLs by hand.

**Views** (`app/views/`) are plain PHP templates included by `Controller::view($path, $data)` — `$data` is `extract()`-ed into scope, plus an auto-injected `$old` array from session flash. Every page includes a layout pair manually at top/bottom rather than a wrapping template engine:
- Customer pages: `layouts/header.php` + `layouts/footer.php`
- Admin pages: `layouts/admin_header.php` + `layouts/admin_footer.php` (includes `admin/layout/sidebar.php`)

Tailwind is loaded via `cdn.tailwindcss.com` with an inline `tailwind.config` (brand colors: primary `#7A2E1D`, secondary `#D98324`, cream `#FBF3EA` — defined in both header variants, keep them in sync if changed). AOS.js, Swiper.js, SweetAlert2, Chart.js, and Font Awesome are also CDN-loaded, no bundling.

**Money/state invariants worth knowing before touching checkout/orders**:
- `Order::createOrderWithItems()` wraps insert + stock decrement in a DB transaction and rolls back on any failure (e.g. insufficient stock) — don't split this across separate non-transactional calls.
- Orders are never hard-deleted (only `status` transitions: `pending → diproses → dikirim → selesai`, or `dibatalkan`) — this is a deliberate PRD requirement, unlike products/categories/banners/testimonials which do support hard delete from the admin panel.
- Payment verification (`Payment::verify()`) is transactional and also flips the parent order's status to `diproses` — the two are not independently updatable from the admin UI once a payment proof exists.

**Out of scope by design** (don't reintroduce without asking): Composer/DomPDF (reports export via native `fputcsv()` CSV and a `window.print()`-friendly HTML view instead — see `admin/ReportController.php`), payment gateway integration, courier API integration, multi-vendor support, "forgot password" (no SMTP configured).
