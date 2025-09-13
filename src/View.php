<?php
namespace App;

class View
{
    public static string $basePath = __DIR__ . '/Views';

    public static function render(string $template, array $data = []): string
    {
        $path = self::$basePath . '/' . str_replace('..', '', $template) . '.php';
        if (!is_file($path)) {
            return 'Шаблон не найден: ' . htmlspecialchars($path);
        }
        extract($data, EXTR_SKIP);
        ob_start();
        $template = $template;
        include __DIR__ . '/Views/_layout.php';
        return ob_get_clean();
    }

    public static function includePartial(string $template, array $data = []): void
    {
        $path = self::$basePath . '/' . str_replace('..', '', $template) . '.php';
        extract($data, EXTR_SKIP);
        include $path;
    }
}
