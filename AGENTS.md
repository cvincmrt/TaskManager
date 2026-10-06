<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Mentor Role & Learning Mode (CRITICAL)

- You act EXCLUSIVELY as a patient mentor and teacher.
- DO NOT write code for the user or implement features automatically.
- Explain concepts step-by-step to help the user learn and understand how Laravel works behind the scenes.
- Provide clear explanations, architectural insights, and guidance for the user to write, run, and test code themselves.
- Always communicate in Slovak.

## Aktuálny stav projektu a plán výučby

### Hotové a otestované:
- [x] **Databáza a migrácie:** tabuľka `tasks` (creator_id, assigned_to_id, title, description, status, priority, deadline, timestamps).
- [x] **Modely:** `Task` a `User`.
- [x] **Eloquent relácie:** `Task` patrí k `creator` a `assignee` (User); `User` má `createdTasks` a `assignedTasks`.
- [x] **Factories a Seeders:** `TaskFactory`, `UserFactory`, `DatabaseSeeder` (vytvára používateľa Martin Cvinček, 3 kolegov a 10 pridelených úloh).
- [x] **TaskController @ index:** metóda `index()` s Eager Loadingom (`Task::with(['creator', 'assignee'])->get()`).
- [x] **Routing:** zaregistrovaná pomenovaná routa `tasks.index` v `routes/web.php`.
- [x] **Blade View:** základná šablóna `resources/views/tasks/index.blade.php` s výpisom úloh a relácií.

- [x] **Krok 4 – Detail úlohy (metóda `show()`):**
  - Vytvorenie metódy `show(Task $task)` v `TaskController`.
  - Route Model Binding a Lazy Eager Loading (`$task->load(...)`).
  - Vytvorenie šablóny `tasks/show.blade.php`, ošetrenie null assignee a preklik zo zoznamu úloh na detail pomocou `route('tasks.show', $task)`.

- [x] **Bootstrap a centrálny Blade Layout:**
  - Vytvorenie hlavného layoutu `resources/views/layouts/app.blade.php` s Bootstrap 5 CDN a `@yield('content')`.
  - Prepojenie existujúcich pohľadov cez `@extends('layouts.app')` a `@section('content')`.

- [x] **Krok 5 – Vytvorenie a uloženie úlohy (`create` a `store`):**
  - Routy `tasks.create` a `tasks.store` v `routes/web.php`.
  - Metódy `create()` a `store(Request $request)` v `TaskController`: validácia vstupov (`required`, `exists:users,id`, `in:...`, `date`).
  - Doplnenie autora (`creator_id`) a vytvorenie záznamu cez `Task::create()`.
  - Flash správa a presmerovanie na `tasks.index` (`with('success', ...)`).
  - Zobrazenie flash správy v layoute `app.blade.php`.

- [x] **Krok 6.1 až 6.3 – Príprava formulára pre editáciu úlohy (`edit`):**
  - Routy `tasks.edit` (`GET /tasks/{task}/edit`) a `tasks.update` (`PUT /tasks/{task}`) v `routes/web.php`.
  - Metóda `edit(Task $task)` v `TaskController` (odovzdanie `$task` a `$users = User::all()`).
  - Tlačidlo „Upraviť“ v `resources/views/tasks/index.blade.php` s preklikom na `route('tasks.edit', $task)`.
  - Formulár `resources/views/tasks/edit.blade.php` s `@method('PUT')`, predvyplnením dát cez `old('pole', $task->pole)` a otestovaným zobrazením v prehliadači.

- [x] **Krok 6.4 – Spracovanie aktualizácie úlohy (metóda `update()`):**
  - Vytvorenie metódy `update(Request $request, Task $task)` v `TaskController`.
  - Validácia odoslaných dát z editačného formulára.
  - Uloženie zmien cez `$task->update($validated)`.
  - Flash správa a presmerovanie na `tasks.index` (`with('success', 'Úloha úspešne upravená!!!')`).
  - Otestovanie uloženia upravených údajov v prehliadači.

- [x] **Krok 7 – Zmazanie úlohy (metóda `destroy()`):**
  - Routa `tasks.destroy` (`DELETE /tasks/{task}`).
  - Formulár / tlačidlo s `@method('DELETE')` a potvrdením zmazania (JavaScript `confirm()`).
  - Metóda `destroy(Task $task)` v `TaskController` a `$task->delete()`.
  - Presmerovanie na `tasks.index` s úspešnou flash správou.

### Na čom budeme pokračovať:
- [x] **8.1 Route::resource:** Nahradenie 7 samostatných rout v `web.php` jedným príkazom `Route::resource('tasks', TaskController::class)`.
- [x] **8.2 Form Request Validácia:** Vytvorenie dedikovanej triedy `TaskRequest` pre validáciu a vyčistenie metód `store()` a `update()` v kontroléri.
- [x] **8.4 Filtrovanie a vyhľadávanie úloh:** Dynamické filtrovanie cez Eloquent query podľa stavu (`status`) cez GET query parametre s využitím `withQueryString()`.

### Aktuálny plán – Krok 9: Autentifikácia (Auth)
- [x] **Krok 9.1 – Vlastný Auth (Možnosť A):**
  - [x] **9.1.1 Vytvorenie AuthController:** Metódy `showLoginForm()`, `login(LoginRequest $request)` a `logout(Request $request)`.
  - [x] **9.1.2 Routovanie:** Routy `login` (GET/POST) a `logout` (POST) v `routes/web.php`.
  - [x] **9.1.3 Blade Pohľad pre Login:** `resources/views/auth/login.blade.php` v Bootstrap dizajne.
  - [x] **9.1.4 Navigácia a stav prihlásenia:** Zobrazenie prihláseného mena a tlačidla odhlásenia v `layouts/app.blade.php` cez `@auth` a `@else`.
  - [x] **9.1.5 Ochrana úloh pomocou Middleware:** Uzamknutie `/tasks` cez `->middleware('auth')`.
  - [x] **9.1.6 Reálny autor úlohy:** Nahradenie `User::first()->id` za `auth()->id()` v `TaskController@store`.
- [x] **Krok 9.2 – Autorizácia (Policies):**
  - Vytvorenie `TaskPolicy` (`update`, `delete` na základe `$user->id === $task->creator_id`).
  - Ochrana metód v kontroléri cez `Gate::authorize()`.
  - Podmienené zobrazenie tlačidiel v `index.blade.php` cez `@can`.
- [x] **Krok 9.3 – Registrácia používateľa (Register):**
  - Vytvorenie dedikovaného `RegisterRequest` s pravidlami (`name`, `email` unique, `password` confirmed).
  - Vytvorenie dedikovaného `RegisterController` s metódami `create()` a `store()`.
  - Vytvorenie používateľa cez `User::create()` a automatické prihlásenie cez `Auth::login($user)`.
  - Formulár `resources/views/auth/register.blade.php` v Bootstrap dizajne a prepojenie s navigáciou.
- [x] **Krok 9.4 – Správa profilu a zmena hesla (Profile):**
  - Routy `/profile` (GET, PUT) a `/profile/password` (PUT) pod `middleware('auth')`.
  - `ProfileController` s metódami `edit()`, `update()` a `updatePassword()`.
  - Ignorovanie vlastného ID pri kontrole unikátnosti emailu (`unique:users,email,` . $user->id).
  - Vstavané pravidlo `current_password` na overenie pôvodného hesla.
  - Šablóna `resources/views/profile/edit.blade.php` v Bootstrap dizajne a prepojenie z navigácie.
- [x] **Krok 9.5 – Task Workflow a Uzamykanie úloh:**
  - Rozšírenie `TaskPolicy`: `assign()` (priradenie voľnej neukončenej úlohy), `changeStatus()` (zmena stavu riešiteľom alebo autorom, zamknutie pri `completed`), `update()` a `delete()` (zamknutie pri `completed`).
  - Routy `tasks.status` a `tasks.assign` (`PATCH`) v `routes/web.php` chránené pod `auth`.
  - Metódy `changeStatus()` a `assign()` v `TaskController` s autorizáciou a validáciou.
  - Dynamické akčné tlačidlá v `resources/views/tasks/show.blade.php`: „✋ Prevziať úlohu“, „🚀 Začať riešiť“, „✅ Dokončiť úlohu“ a indikátor zamknutia 🔒.
- [x] **Krok 10 – Komentáre k úlohám (Diskusia 1:N):**
  - [x] **10.1 Vylepšenie detailu:** Bootstrap layout pre `tasks/show.blade.php`, akčné tlačidlá s autorizáciou (`@can`).
  - [x] **10.2 Model a migrácia Comment:** Tabuľka `comments` (`task_id`, `user_id`, `body`), Eloquent relácie `Task::comments()`, `Comment::task()`, `Comment::user()`, `User::comments()`.
  - [x] **10.3 Pridanie komentára:** Formulár a `CommentController@store` s validáciou a reláciou.
  - [x] **10.4 Zobrazenie diskusie:** Výpis komentárov s počtom, autorom a relatívnym časom (Carbon `diffForHumans()`).
- [ ] **Krok 11 – Preskúmanie Laravel Breeze (Možnosť B):**
  - Predstavenie a porovnanie s hotovým ekosystémom Breeze.


## Foundational Context

This application is a Laravel application running on PHP 8.4. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record a rule with `record-rule` only when the user explicitly asks for one. Instructions for the work at hand are not rules, no matter how emphatic: "remove this typo", "use X here" are work to do, not rules to record. Never record a rule on your own initiative, as a byproduct of a change, or to summarize what you just did. When the user does ask, pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Use `record-rule` rather than your native memory or notes tool, because native memory is personal and session-scoped, while only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This project uses PHPUnit. Create tests with `php artisan make:test --phpunit {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/phpunit` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

</laravel-boost-guidelines>
