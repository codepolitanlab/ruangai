# Copilot Instructions — RuangAI

Guidelines for GitHub Copilot when working in this repository. Read this before making
changes so generated code follows the project's architecture, conventions, and constraints.

## 1. Project Overview

- **RuangAI** is a PHP **CodeIgniter 4.6.x** membership platform (e-learning, scholarship,
  bootcamp/classroom, challenge, referral, certificates, payments).
- It has **two UI layers**:
  1. **Member pages** — `app/Pages/<feature>/` (SSR + Alpine.js, MobileKit theme in `public/mobilekit/`).
  2. **Admin panel** — `modules/Heroicadmin/` + business modules (Bootstrap 5 theme in `public/admin/`), routed under `{urlScope}` (default `/ruangpanel`).
- Built on two in-house packages: `yllumi/heroic` (base `HeroicController` + `Heroicadmin` module)
  and `yllumi/ci4-pages` (`PageRouter` + `pageview` helper).
- UI copy/labels are **Bahasa Indonesia**.

## 2. Tech Stack (verified)

| Concern | Technology |
|---------|-----------|
| Language | PHP ^8.1 (composer platform `8.3.30`) |
| Framework | CodeIgniter 4.6.x |
| Database | MySQL (MySQLi), db `ruangai` |
| ORM | `CodeIgniter\Model` + Query Builder; CI4 Migrations |
| Member frontend | Raw PHP views + Tailwind CSS (CDN) + Alpine.js 3 (CDN) |
| Admin frontend | Bootstrap 5 + jQuery + DataTables + Alpine.js + Select2 + TinyMCE |
| Queue | Beanstalkd (`pda/pheanstalk`) — worker `app/Commands/ProcessWaQueue.php` |
| Email | PHPMailer via `app/Libraries/EmailSender.php` |
| Payment | Xendit (`XenditPaymentMethod`) + 25+ channels in `app/Libraries/PaymentMethods/` |
| Auth | Admin: session `user_id()` + `role_slug`; Member: session/token (`getUserFromToken()`), JWT |
| Testing | PHPUnit (`phpunit.xml.dist`) |
| Deploy | Deployer (`deploy.php`) + GitHub Actions (`.github/workflows/deploy-main.yml`) |

## 3. Architecture & Key Patterns

### Module system (`modules/<Module>/`)

Business/domain features are CodeIgniter modules under `modules/`. Each module:

```
modules/<Module>/
├── Config/Routes.php           # route group {urlScope}/<module>
├── Controllers/                # extends Heroicadmin\Controllers\AdminController
├── Models/                     # extends CodeIgniter\Model
├── Views/                      # extends Heroicadmin\Views\_layouts\admin
├── Libraries/ Helpers/ Validation/   # optional
└── Database/Migrations/        # module tables (auto-discovered)
```

To add a module: create the folder, register its namespace in `app/Config/Autoload.php`
(`$psr4`), add menu entries to `modules/Heroicadmin/Config/Heroicadmin.php`
(`sidebarMenu`, keys `module`/`submodule`), run `php spark migrate -n 'Namespace'`.

### Member pages (`app/Pages/<feature>/`)

- Each feature folder has `PageController.php` (extends `App\Pages\BaseController`
  → `Yllumi\Heroic\Controllers\HeroicController`) plus view templates (`template.php`).
- Routes are declared in the static array `app/Pages/Router.php` (`Router::$router`),
  resolved by `Yllumi\Ci4Pages\PageRouter`.
- `getIndex()` renders the shell (`app/Pages/layout.php`) via `pageView('layout', $data)`;
  `getTemplate()` renders the inner page. Dynamic data is fetched in-browser with Alpine.js.
- JSON/AJAX endpoints must use `respondSecure()` (blocks cross-origin + non-AJAX in production).

### API (`/api/*`)

Controllers live in `App\Controllers\Api`, routed in `app/Config/Routes.php`.
Some routes need a Bearer/cookie token (`getUserFromToken()`), others are public.

## 4. Naming Conventions

- Controllers: `XxxController` (admin) / `PageController` (member page folder).
- Admin controller methods: plain verbs (`index`, `store`, `data`, `update`) wired via
  **explicit routes** — do not rely on CI4 auto-routing for admin.
- Models: suffix `Model` (e.g. `SyllabusModel`).
- Tables: plural snake_case with domain prefix (`cls_*`, `course_*`); FK = `{table}_id`.
- Route groups: `{urlScope}/<module>` (e.g. `ruangpanel/classroom`).

## 5. CRITICAL Constraints & Gotchas (verified)

1. **Controllers do NOT have `$this->db`.** `AdminController`/`BaseController` have no `$db`
   property. If a controller needs the DB, declare `protected $db;` and assign
   `\Config\Database::connect()` in the constructor. **Models** do have `$this->db`.
2. **Member table is `mein_users`** (columns: id, name, username, phone, password, token,
   otp, role_id, status, created_at) — NOT `users`. The `users`/`roles` tables are for admin.
   There is no verified email column; when searching members use username/phone/email
   defensively.
3. **`spark migrate --all` / default `spark migrate` can fail** due to a broken App migration
   (`2025-12-30-070448_AddSourceToUsers`). Run module migrations explicitly:
   `php spark migrate -n 'Classroom'` (namespace = module).
4. **`EmailSender` has NO `sendBySlug()`.** API is `setTemplate($name, $data)` +
   `send($to, $subject)`.
5. **Admin auth**: controllers extend `AdminController` which already enforces session login
   + role check. Don't add your own auth unless required.
6. **Member vs admin share tables.** Member pages and admin modules can read/write the same
   tables (e.g. bootcamp member pages `app/Pages/bootcamp/` and admin `modules/Classroom/`
   both use `cls_*` tables). Keep logic consistent on both sides.
7. **File uploads**: blacklist dangerous extensions (`php`, `phar`, `sh`, `exe`), validate
   `allowed_types` and `max_size_mb`; guard file downloads against path traversal.
8. **`respondSecure()`** must be used for AJAX/JSON responses on member pages; it returns 403
   in production for cross-origin or non-XHR requests.
9. **Composer platform** is pinned to PHP `8.3.30` — code must stay compatible with PHP 8.1+.

## 6. Useful Commands

```bash
php spark serve                       # dev server
php spark migrate -n 'Classroom'      # run migrations for one module namespace
php spark migrate:status              # migration status
php spark routes                      # list routes
php spark ProcessWaQueue              # WhatsApp queue worker
composer test                         # run PHPUnit
vendor/bin/php-cs-fixer fix           # apply code style (CodeIgniter standard)
php vendor/bin/dep deploy main|dev    # Deployer deploy (or via GitHub Actions on push)
```

## 7. Do's and Don'ts

- **Do** follow the module pattern for admin features and the page pattern for member features.
- **Do** write UI strings in Bahasa Indonesia.
- **Do** use `CodeIgniter\Model` + Query Builder; prefer explicit routes over auto-routing.
- **Don't** assume `$this->db` exists in controllers.
- **Don't** create new tables without a migration in the owning module's `Database/Migrations/`.
- **Don't** bypass `AdminController`'s auth when adding admin controllers.
- **Don't** run `spark migrate` (all namespaces) expecting success — scope with `-n`.
