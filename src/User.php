<?php

class User {
    public $name;
    public $age;
    public static int $count = 0;
    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
        self::$count++;
    }
    public function introduce(): string {
        return "Привет, меня зовут " . $this->name . " , мне " . $this->age . " лет";
    }
    public function isAdult() {
        return $this->age > 18 ? "Совершенолетний" : "Ребенок";
    }
    public static function getCount(): int {
        return self::$count;
    }
}
