# AGENTS.md — CodeIgniter 4 starter (sayurku)

Repo-specific context only; skip generic framework docs.

## Mandatory workflow (do not skip)
- Large/new feature: /prd -> /trd -> confirm with user -> code.
- Before styling UI: follow /frontend-guidelines; ask for visual reference first.
- Before backend coding: follow /backend-architecture layer rules.
- Before calling done: /security-review and /bug-hunt.
- Big decisions (DB schema, auth, library choice): ask user; don't assume.
- If mimicking a visual reference: take your own screenshot, compare with reference (use MCP playwright) before reporting done.

## Project identity
- CodeIgniter 4 starter (`codeigniter4/appstarter`), PHP ^8.2, framework ^4.7.
- Namespace `App\` -> `app/`, `Config\` -> `app/Config/`.
- No monorepo; single package.

## Setup (must do, not optional)
- `cp env .env` and set `app.baseURL` and DB settings. `.env` is required; `env` is template.
- Web server must point to `public/` (docroot), not repo root (`index.php` lives inside `public/`).
- `writable/` must be writable (cache/logs/uploads); verify permissions if errors appear.

## Key commands (exact, not guesses)
- Server: `php spark serve` (dev server from `public/`).
- CLI tasks: `php spark` (migrate, make:test, etc.).
- Tests: `composer test` (== `phpunit`) or `vendor/bin/phpunit`; symlink with `ln -s ./vendor/bin/phpunit ./phpunit` if desired.
- Coverage: `vendor/bin/phpunit --colors --coverage-text=tests/coverage.txt --coverage-html=tests/coverage/ -d memory_limit=1024m` (needs Xdebug + `xdebug.mode=coverage`).
- Tests that hit DB need `tests` group in `app/Config/Database.php` or `.env` configured; some tests require a running DB engine.
- Framework stability toggle (rare): `php builds [release|development|next]`; do not run accidentally.

## Testing / verification quirks
- PHPUnit ^10.5; `tests/_support/` holds support classes (`Tests\Support\`).
- `autoload-dev` excludes migrations from classmap (`**/Database/Migrations/**`).
- Single directory: `vendor/bin/phpunit app/Controllers` etc.

## Structure that changes agent behavior
- `app/Controllers/` — controllers (`BaseController.php`, `Home.php` exist); most dirs empty.
- `public/` — only web-accessible folder.
- `writable/` — runtime data.
- `tests/` — PHPUnit, not a separate package.
- `spark` — executable CLI entrypoint (not installed globally).

## Style / convention differences from defaults
- Migrations excluded from autoload classmap; if adding migrations, they won't be loaded by classmap (expected CI4 behavior).
- `builds` script modifies `composer.json` stability/repositories; revert if accidentally changed.

## Do not claim unverified things
- If you haven't actually run tests/coverage, don't write "tested" or "passing" in docs/code comments.
- If docs conflict with `composer.json` or `spark`, trust executable source.
