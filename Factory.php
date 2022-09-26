<?php

declare(strict_types=1);

interface Transport
{
    public function deliver();
}

class Sheep implements Transport
{
    public function deliver()
    {
        echo 'Доставляю по морю' . PHP_EOL;
    }
}

class Truck implements Transport
{
    public function deliver()
    {
        echo 'Доставляю на суше' . PHP_EOL;
    }
}

interface Factory
{
    public function createTransport(): Transport;
}

class SeaDelivery implements Factory
{
    public function createTransport(): Transport
    {
        return new Sheep();
    }
}

class RoadDelivery implements Factory
{
    public function createTransport(): Transport
    {
        return new Truck();
    }
}

function deliver(string $item)
{
    if ($item === 'Контейнер') {
        $a = new SeaDelivery();
    } else {
        $a = new RoadDelivery();
    }

    $transport = $a->createTransport();
    $transport->deliver();
}

deliver('Контейнер');
deliver('a');