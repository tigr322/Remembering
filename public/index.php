<?php
require_once __DIR__ . '/../src/app.php';
require_once __DIR__ . '/../src/User.php';
echo "Hello from PHP!<br>";
echo "ENV APP_ENV = " . ($_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'not set') . "<br>";
echo "App says: " . app::hello();
$user = new User("Tigran", 22);
$user1 = new User("Anna", 21);
$user2 = new User("Anna-Maria", 20);
echo $user->introduce() . "\n";
echo $user->isAdult();
echo User::getCount();