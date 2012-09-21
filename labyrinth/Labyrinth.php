<?php

require_once "Tile.php";

/**
 * Main class for application, represents labyrinth and its structure
 */
class Labyrinth {

    /**
     * Start point coordinates
     * @var array - two elemnts 'x' and 'y' eg. array('x' =>0, 'y' => 0)
     */
    private $_startPoint;

    /**
     * End point coordinates
     * @var array
     */
    private $_endPoint;

    /**
     * Contains model od labyrinth
     *
     * $var array Array of Tile objects
     */
    private $_structure;

    /**
     * Sets structure for labyrinth, creates table with Tile objects, sets start point and end point
     *
     * @param array $structure
     * @param array $start
     * @param array $end
     * @return void
     */
    public function __construct(array $structure,array $start,array $end){
        foreach($structure as $rowNumber => $row){
            foreach($row as $columnNumber =>$tile){
                $this->_structure[$columnNumber][$rowNumber] = new Tile($tile);
            }
        }

        $this->_startPoint['x'] = $start[0];
        $this->_startPoint['y'] = $start[1];
        $this->_endPoint['x'] = $end[0];
        $this->_endPoint['y'] = $end[1];
    }

    /**
     * Main method - finds path in labyrinth
     *
     * @access public
     * @return array Array with path coordinates
     */
    public function findPath(){

        $position = $this->_startPoint;
        $tile = $this->_getTile($position);

        while(!$this->_checkEnd($position)){
            $direction = $tile->move();
            $position = $this->_getNewPosition($position,$direction);
            $newTile = $this->_getTile($position);
            $newTile->enter($direction);
            $tile = $newTile;
        }

        return $this->_getResult();
    }

    /**
     * Gets one Tile object from structure
     *
     * @access private
     * @param array $position
     * @return Tile
     */
    private function _getTile($position){
        return $this->_structure[$position['x']][$position['y']];
    }

    /**
     * Checks if end point was reached
     *
     * @access private
     * @param array position
     * @return bool
     */
    private function _checkEnd($position){
        return $position == $this->_endPoint ? true : false;
        /*
         * If it's possible that there is no solution for labyrinth
         * this function should check if algorithm didn't go back to start tile
         */
    }

    /**
     * Finds new position
     *
     * @access private
     * @param array $position Old position
     * @param int $direction Move direction - constant from Tile
     * @return array
     */
    private function _getNewPosition($position,$direction){
        switch ($direction) {
            case Tile::TOP_MOVE:
                $position['y'] -= 1;
                break;
            case Tile::DOWN_MOVE:
                $position['y'] += 1;
                break;
            case Tile::RIGHT_MOVE:
                $position['x'] += 1;
                break;
            case Tile::LEFT_MOVE:
                $position['x'] -= 1;
                break;
        }

        return $position;
    }

    /**
     * Gathers coordinates for path
     * Labytinth must be solved before
     *
     * @access private
     * @return array
     */
    private function _getResult(){

        $position = $this->_startPoint;
        $tile = $this->_getTile($position);
        $path[] = $position;

        while(!$this->_checkEnd($position)){
            $direction= $tile->getLastMove();
            $position = $this->_getNewPosition($position,$direction);
            $tile = $this->_getTile($position);
            $path[] = $position;
        }

        return $path;
    }

}