<?php

declare(strict_types=1);

require_once('Team.php');
require_once('Division.php');

$east = new Division('East');
$west = new Division('West');

$east_winner = Rounds($east);
$west_winner = Rounds($west);
finalRound($east_winner, $west_winner, $east->getName(), $west->getName());

function finalRound(Team $team1, Team $team2, string $divisionName1, string $divisionName2)
{
    printf('%s===========================================%s', PHP_EOL, PHP_EOL);
    printf('========= Final East %s vs West %s  =========%s', $team1->getName(), $team2->getName(), PHP_EOL);
    printf('===========================================%s%s', PHP_EOL, PHP_EOL);

    $winner = Serie($team1, $team2, 'Final', $divisionName1, $divisionName2);

    printf('%s%s', PHP_EOL, PHP_EOL);
}

function Rounds(Division $division): Team
{
    $winners = array_values($division->getTeams());
    $round = 0;

    printf('%s==================================%s', PHP_EOL, PHP_EOL);
    printf('========= Division: %s =========%s', $division->getName(), PHP_EOL);
    printf('==================================%s', PHP_EOL);

    do {
        printf('%sRound #%d: %s-------------------------------%s', PHP_EOL, $round, PHP_EOL, PHP_EOL, PHP_EOL);
        $winners = match($winners);
        $round++;
    } while (count($winners) > 1);
    return $winners[0];
}

function match(array $teams): array
{
    $winners = array();
    for ($i = 0; $i < count($teams) / 2; $i++) {
        $winner = Serie($teams[$i * 2], $teams[$i * 2 + 1], 'Serie');
        array_push($winners, $winner);
    }
    return $winners;
}

function Serie(Team $team1, Team $team2, string $type, string $divisionName1 = null, string $divisionName2 = null): Team
{
    $diff = getDiffRating($team1->getRating(), $team2->getRating());
    $victory = array(0, 0);

    while ($victory[0] < 4 && $victory[1] < 4) {
        $result1 = rand((int)($diff * 100), 100) / 100;
        $result2 = rand((int)($diff * 100), 100) / 100;

        if ($result1 > $result2) {
            $victory[0] += 1;
        }
        if ($result1 < $result2) {
            $victory[1] += 1;
        }
    }

    displayResult($team1->getName(), $team2->getName(), $victory, $type, $divisionName1, $divisionName2);
    return $victory[0] == 4 ? $team1 : $team2;
}

function getDiffRating(float $value1, float $value2): float
{
    $diff = $value1 - $value2;
    if ($diff < 0) {
        $diff *= -1;
    }
    return $diff;
}

function displayResult(string $teamName1, string $teamName2, array $victory, string $type, string $divisionName1 = null, string $divisionName2 = null)
{
    if ($type == 'Final') {
        printf('%s %s %s vs %s %s - Winner : ', $type, $divisionName1, $teamName1, $divisionName2, $teamName2);
    } else {
        printf('%s %s vs %s - Winner : ', $type, $teamName1, $teamName2);
    }

    if ($victory[0] == 4) {
        rsort($victory);
        printf('%s %s (%d/%d)%s', $divisionName1, $teamName1, $victory[0], $victory[1], PHP_EOL);
    } else {
        rsort($victory);
        printf('%s %s (%d/%d)%s', $divisionName2, $teamName2, $victory[0], $victory[1], PHP_EOL);
    }
}
