<?php

declare(strict_types=1);

class Player
{
    private $rating;

    public function __construct()
    {
        $this->rating = mt_rand(15, 100) / 100;
    }

    public function getRating(): float
    {
        return $this->rating;
    }
}
