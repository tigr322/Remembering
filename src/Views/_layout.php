<?php
/** @var string $title */
use App\View;
?><!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Мини-сайт на PHP') ?></title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin: 0; }
    header { background: #111827; color: #fff; padding: 16px 24px; }
    nav a { color: #93c5fd; margin-right: 12px; text-decoration: none; }
    main { max-width: 900px; padding: 24px; margin: 0 auto; }
    .card { border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; margin: 12px 0; }
    .muted { color: #6b7280; }
    footer { border-top: 1px solid #e5e7eb; padding: 16px 24px; margin-top: 48px; font-size: 14px; color: #6b7280; }
    code { background:#f3f4f6; padding:2px 6px; border-radius:6px; }
  </style>
</head>
<body>
  <header>
    <strong>PHP Мини-сайт</strong>
    <nav style="margin-top:8px;">
      <a href="/">Главная</a>
      <a href="/about">О проекте</a>
      <a href="/year/2024">Пример года</a>
    </nav>
  </header>
  <main>
    <?php View::includePartial($template ?? 'home', get_defined_vars()); ?>
  </main>
  <footer>Сделано для практики ООП, роутинга и шаблонов на чистом PHP.</footer>
</body>
</html>
