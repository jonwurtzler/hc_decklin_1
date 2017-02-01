<?php

namespace src\helpers;

use GameMap;
use Location;
use Site;

class BotBrain
{
    /**
     * @var GameMap
     */
    private $gameMap;

    /**
     * @var int
     */
    private $myId;

    /**
     * @param GameMap $gameMap
     *
     * @return BotBrain
     */
    public function setGameMap($gameMap)
    {
        $this->gameMap = $gameMap;

        return $this;
    }

    /**
     * @param int $myId
     *
     * @return $this
     */
    public function setMyId($myId)
    {
        $this->myId = $myId;

        return $this;
    }

    /**
     * @param Location $location
     * @param Site     $site
     *
     * @return int
     */
    public function selectMove($location, $site)
    {
        if ($site->strength < (5 * $site->production)) {
            return STILL;
        }

        $neighbors = $this->gameMap->getNeighbors($location);

        if (!empty($neighbors)) {
            /**
             * @var int  $direction
             * @var Site $neighbor
             */
            foreach ($neighbors as $direction => $neighbor) {
                if ($this->myId != $neighbor->owner) {

                    if ($site->strength > 250) {
                        return $direction;
                    }

                    if ($neighbor->strength < $site->strength) {
                        return $direction;
                    }
                }

                if ($this->myId == $neighbor->owner) {
                    if (($neighbor->strength > 50) && ($neighbor->strength + $site->strength) < 255) {
                        return $direction;
                    }
                }
            }
        }

        if (255 === $site->strength) {
            return array_rand([NORTH, WEST]);
        }

        return STILL;

    }
}
