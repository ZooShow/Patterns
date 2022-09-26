<?php

declare(strict_types=1);

class Singletone {
    private static array $instanses;

    protected function construct()
    {
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public static function getInstance()
    {
        $subclass = static::class;
        if (!isset(self::$instanses[$subclass])) {
            self::$instanses[$subclass] = new static();
        }

        return self::$instanses[$subclass];
    }
}

class Foo extends Singletone
{
    public function doSomething()
    {
        echo 'Foo делает'  . PHP_EOL;
    }
}

class Bar extends Singletone
{
    public function doSomething()
    {
        echo 'Bar делает' . PHP_EOL;
    }
}

$a = Foo::getInstance();
$a1 = Foo::getInstance();

echo $a === $a1;

//$b = Bar::getInstance();
//
//$a->doSomething();
//$b->doSomething();
