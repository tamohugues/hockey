<?php

require_once('Team.php');

class Division
{
    private $name;
    private $teams;

    public function __construct($name)
    {
        $this->name = $name;
        $this->teams = array();
        for ($i = 0; $i < 8; $i++) {
            array_push($this->teams, new Team(chr($i + 65)));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeams(): array
    {
        return $this->teams;
    }
}
