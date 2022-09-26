<?php

declare(strict_types=1);

interface Chair
{
    public function seatOn();
}

interface Sofa
{
    public function layOn();
}

interface Table
{
    public function putOn();
}

interface AbstractFactory
{
    public function createChair(): Chair;

    public function createSofa(): Sofa;

    public function createTable(): Table;
}

class ModernChair implements Chair
{

    public function seatOn()
    {
        echo 'Сесть на модерн' . PHP_EOL;
    }
}

class ModernSofa implements Sofa
{

    public function layOn()
    {
        echo 'Лечь на модерн' . PHP_EOL;
    }
}

class ModernTable implements Table
{

    public function putOn()
    {
        echo 'Положить на модерн' . PHP_EOL;
    }
}

class VictorianChair implements Chair
{

    public function seatOn()
    {
        echo 'Сесть на викторианский' . PHP_EOL;
    }
}

class VictorianSofa implements Sofa
{

    public function layOn()
    {
        echo 'Лечь на викторианский' . PHP_EOL;
    }
}

class VictorianTable implements Table
{

    public function putOn()
    {
        echo 'Положить на викторианский' . PHP_EOL;
    }
}

class VictorianFactory implements AbstractFactory
{

    public function createChair(): Chair
    {
        return new VictorianChair();
    }

    public function createSofa(): Sofa
    {
        return new VictorianSofa();
    }

    public function createTable(): Table
    {
        return new VictorianTable();
    }
}

class ModernFactory implements AbstractFactory
{

    public function createChair(): Chair
    {
        return new ModernChair();
    }

    public function createSofa(): Sofa
    {
        return new ModernSofa();
    }

    public function createTable(): Table
    {
        return new ModernTable();
    }
}


class User
{
    private AbstractFactory $factory;
    public function __construct(AbstractFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getFurniture()
    {
        $this->factory->createChair()->seatOn();
        $this->factory->createSofa()->layOn();
        $this->factory->createTable()->putOn();
    }
}

class Leruamerlen
{
    public function main(string $config)
    {
        if ($config === 'модерн') {
            $factory = new ModernFactory();
        } else {
            $factory = new VictorianFactory();
        }

        (new User($factory))->getFurniture();
    }
}

echo 'Модерн:' . PHP_EOL;
(new Leruamerlen())->main('модерн');

echo PHP_EOL . 'Викторианский:' . PHP_EOL;
(new Leruamerlen())->main('');