<?php


namespace Jarosoft;


class TickCounter
{
    private static $instance;

    private $value = 0;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new TickCounter();
        }
        return self::$instance;
    }

    public function increment() {
        $this->value++;
    }

    public function getTicks() {
        return $this->value;
    }
}