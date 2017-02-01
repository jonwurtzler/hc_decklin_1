<?php

require_once 'hlt.php';
require_once 'networking.php';
require_once 'src/helpers/BotBrain.php';

use src\helpers\BotBrain;

list($myID, $gameMap) = getInit();
sendInit('jwurtzle');

$brain = new BotBrain();

while (true) {
    $moves   = [];
    $gameMap = getFrame();

    // Set base game variables
    $brain->setMyId($myID)->setGameMap($gameMap);

    for ($y = 0; $y < $gameMap->height; ++$y) {
        for ($x = 0; $x < $gameMap->width; ++$x) {

            $currLocation = new Location($x, $y);
            $currSite     = $gameMap->getSite($currLocation);

            if ($currSite->owner === $myID) {
                $move = $brain->selectMove($currLocation, $currSite);

                $moves[] = new Move(new Location($x, $y), $move);
            }


        }
    }

    sendFrame($moves);
}
