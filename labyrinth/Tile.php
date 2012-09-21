<?php

/**
 * Represents one tile from labyrinth
 */
class Tile {


    const TOP_MOVE = 1;
    const RIGHT_MOVE = 2;
    const DOWN_MOVE = 4;
    const LEFT_MOVE = 8;
    const NO_MOVE = 0;

    /** Each tile has movement possibility represented by binary number - 1 means opportunity to pass
     * Four walls counting starts from top, clockwise
     * e.g. tile with left and righ wall is represented as 0101(2) = 5(10)
     * @var int
     */
    private $_movmentPossibility;

    /**
     * Direction from wich tile was entered for the first time
     * @var int - one of the class constants
     */
    private $_enterMove;

    /**
     * Direction of last move - helps to find path after solving
     * @var int - one of the class constants
     */
    private $_lastMove;


    /**
     * Creates tile
     *
     * @param int - Movement possibility represented by binary number
     * @return void
     */
    public function __construct($movementPossibility){
        $this->_movmentPossibility = $movementPossibility;
    }

    /**
     * Checks if there is any movement possibility left
     * If no returns to enter move and rejects tile
     * If yes returns move
     *
     * @access public
     * @return int
     */
    public function move(){
        if($this->_movmentPossibility == self::NO_MOVE){
            $move = $this->_enterMove;
        }

        if(($this->_movmentPossibility & self::TOP_MOVE) != self::NO_MOVE){
            $this->_movmentPossibility = ~ self::TOP_MOVE & $this->_movmentPossibility;
            $move = self::TOP_MOVE;
        }elseif(($this->_movmentPossibility & self::DOWN_MOVE) != self::NO_MOVE){
            $this->_movmentPossibility = ~ self::DOWN_MOVE & $this->_movmentPossibility;
            $move = self::DOWN_MOVE;
        }elseif(($this->_movmentPossibility & self::RIGHT_MOVE) != self::NO_MOVE){
            $this->_movmentPossibility = ~ self::RIGHT_MOVE & $this->_movmentPossibility;
            $move = self::RIGHT_MOVE;
        }elseif(($this->_movmentPossibility & self::LEFT_MOVE) != self::NO_MOVE){
            $this->_movmentPossibility = ~ self::LEFT_MOVE & $this->_movmentPossibility;
            $move = self::LEFT_MOVE;
        }

        $this->_lastMove = $move;
        return $move;
    }

    /**
     * Sets enter move, subtract movement possibility
     *
     * @access public
     * @param int $direction
     * @return void
     */
    public function enter($direction){
        $enter = $this->_getOpositeDirection($direction);
        $this->_movmentPossibility = ~ $enter & $this->_movmentPossibility;
        if(empty($this->_enterMove)){
            $this->_enterMove = $enter;
        }
    }

    /**
     * Gets opposite direction
     *
     * @access private
     * @param int $direction
     * @return int
     */
    private function _getOpositeDirection($direction){
        switch ($direction) {
            case self::TOP_MOVE:
                return self::DOWN_MOVE;
            case self::DOWN_MOVE:
                return self::TOP_MOVE;
            case self::RIGHT_MOVE:
                return self::LEFT_MOVE;
            case self::LEFT_MOVE:
                return self::RIGHT_MOVE;
        }
    }

    /**
     * Gets lat move for finding right path
     *
     * @access public
     * @return int
     */
    public function getLastMove(){
        return $this->_lastMove;
    }

}