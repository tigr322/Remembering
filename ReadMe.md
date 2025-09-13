# PHP Мини-сайт: роутер + контроллеры + шаблоны (PSR-4)

Мини-каркас для практики PHP 8.x. Проект показывает базовые принципы:
- **Front Controller** (входная точка)
- **Роутер** с динамическими сегментами (`/year/{y}`)
- **Контроллеры** и передача данных в представления
- **Шаблоны (Views)** и общий layout
- **Composer PSR-4 автозагрузка**

---

## 📦 Стек и требования
- PHP **8.0+** (желательно 8.1/8.2)
- Composer
- Веб-сервер (Apache/Nginx) или встроенный сервер PHP

---

## 🚀 Быстрый старт

```bash
git init
git clone https://github.com/tigr322/Remembering.git
docker compose up --build
```

Открой в браузере: [http://localhost:8000](http://localhost:8000)

---

## 🗂️ Структура проекта

```
Remembering/
├── composer.json
├── README.md
├── public/
│   ├── .htaccess
│   └── index.php
└── src/
    ├── Controllers/
    │   └── HomeController.php
    ├── Router.php
    ├── View.php
    └── Views/
        ├── _layout.php
        ├── about.php
        ├── home.php
        ├── year.php
        └── errors/
            └── 404.php
```

---

## 📖 Файлы и концепции

### `public/index.php` — Front Controller
Точка входа в приложение:

- Подключает Composer автозагрузку.
- Регистрирует маршруты.
- Запускает роутер.

```php
$router->dispatch();
```

---

### `src/Router.php` — Роутер
- Поддерживает маршруты GET и POST.
- Преобразует паттерны с `{param}` в регулярные выражения.
- Передаёт параметры в контроллер.
- Возвращает 404, если маршрут не найден.

Пример регистрации маршрутов:

```php
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/year/{y}', [HomeController::class, 'year']);
```

---

### `src/View.php` — Мини view-движок
- `render($template, $data)` — рендер страницы через общий layout.
- `includePartial()` — подключает конкретный шаблон.

Данные (`$data`) становятся переменными внутри шаблонов.

Пример:

```php
return View::render('home', ['title' => 'Главная', 'year' => 2025]);
```

---

### `src/Controllers/HomeController.php` — Контроллер
- `index()` — главная страница, выводит текущий год.
- `about()` — статическая страница.
- `year($y)` — динамическая страница, проверяет високосный год.

---

### `src/Views/_layout.php` — Общий шаблон
Содержит HTML-каркас (`<html>`, `<head>`, меню, футер).

Вставляет контент конкретной страницы:

```php
View::includePartial($template ?? 'home', get_defined_vars());
```

---

### `src/Views/home.php`, `about.php`, `year.php` — Страницы
Простые шаблоны с контентом.  
Получают данные от контроллеров (`$year`, `$isLeap` и др.).

---

### `src/Views/errors/404.php` — Страница 404
Отображается, если маршрут не найден.  
Показывает URI и ссылку на главную.

---

### `public/.htaccess` — ЧПУ для Apache
Позволяет направлять все запросы в `index.php`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

---

### `composer.json` — PSR-4 автозагрузка
Определяет неймспейс `App\` и папку `src/`:

```json
"autoload": {
  "psr-4": {
    "App\": "src/"
  }
}
```

После изменений выполняем:

```bash
composer dump-autoload
```

---

## ✨ Как добавить новую страницу

В `HomeController`:

```php
public function contacts(): string {
    return View::render('contacts', ['title' => 'Контакты']);
}
```

В `src/Views/contacts.php`:

```php
<h1>Контакты</h1>
<p>Email: info@example.com</p>
```

В `public/index.php`:

```php
$router->get('/contacts', [HomeController::class, 'contacts']);
```

---

## 🔗 Динамические параметры

Маршрут:

```php
$router->get('/hello/{name}', [HomeController::class, 'hello']);
```

Контроллер:

```php
public function hello(string $name): string {
    return View::render('hello', ['name' => htmlspecialchars($name)]);
}
```

Шаблон `src/Views/hello.php`:

```php
<h1>Привет, <?= $name ?></h1>
```

---

## 📅 Работа с датами

В `HomeController::year()`:

```php
$isLeap = (new DateTimeImmutable("$year-01-01"))->format('L') === '1';
```

---

## 🌐 Развёртывание(необязательно, есть Doker)

### Apache

```apache
<VirtualHost *:80>
    ServerName php-mini-site.local
    DocumentRoot /path/to/php-mini-site/public

    <Directory /path/to/php-mini-site/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Nginx

```nginx
server {
    server_name php-mini-site.local;
    root /path/to/php-mini-site/public;
    index index.php;

    location / {
        try_files $uri /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## 💡 Идеи для расширения

- Вынести маршруты в отдельный файл `routes.php`.
- Добавить модель `Event` и список событий.
- Подключить шаблонизатор Twig/Plates.
- Сделать форму с обработкой POST-запроса.
- Добавить логи и middleware.
