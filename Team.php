<?php

require_once('Player.php');

class Team
{
    private $name;
    private $rating;
    private $players;

    public function __construct($name)
    {
        $this->name = $name;
        $this->players = array();

        for ($i = 0; $i < 21; $i++) {
            $player = new Player();
            $this->rating += $player->getRating();
            array_push($this->players, $player);
        }

        $this->rating = (float) round($this->rating / 21, 2);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getRating(): float
    {
        return $this->rating;
    }
}
