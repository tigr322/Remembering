<?php
namespace App\Controllers;

use App\View;
use DateTimeImmutable;

class HomeController
{
    public function index(): string
    {
        $year = (int) (new DateTimeImmutable())->format('Y');
        return View::render('home', ['title' => 'Главная', 'year' => $year]);
    }

    public function about(): string
    {
        return View::render('about', ['title' => 'О проекте']);
    }

    public function year(string $y): string
    {
        $year = (int) $y;
        $isLeap = (new DateTimeImmutable("$year-01-01"))->format('L') === '1';
        return View::render('year', ['title' => "Год: $year", 'year' => $year, 'isLeap' => $isLeap]);
    }
}
