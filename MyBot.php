<?php

require_once 'hlt.php';
require_once 'networking.php';

list($myID, $gameMap) = getInit();
sendInit('myPHPBot');

while (true) {
    $moves   = [];
    $gameMap = getFrame();

    for ($y = 0; $y < $gameMap->height; ++$y) {
        for ($x = 0; $x < $gameMap->width; ++$x) {
            $currSite = $gameMap->getSite(new Location($x, $y));
            if ($currSite->owner === $myID) {
                if ($currSite->strength < (5 * $currSite->production)) {
                    return STILL;
                }

                $moves[] = new Move(new Location($x, $y), rand(0, 4));
            }
        }
    }
    sendFrame($moves);
}
