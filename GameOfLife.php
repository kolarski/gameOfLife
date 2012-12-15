<?php

/**
 * Class: Game of life
 * 
 * 
 */

class GameOfLife
{
    function __construct()
    {

    }

}

class Board
{
    public function init($size)
    {
        $this->size = $size;
        $this->board = str_pad('', $size * $size, '0');
        $this->new_board = str_pad('', $size * $size, '0');
    }
    public function addPoint($point)
    {
        $this->board[$point[0] * $this->size + ($point[1])] = 1;
    }
    public function removePoint($point)
    {
        $this->board[$point[0] * $this->size + ($point[1])] = 0;
    }

    public function getPoint($point)
    {
        return $this->board[$point[0] * $this->size + ($point[1])];
    }
    public function pointExists($point)
    {
        $location = $point[0] * $this->size + ($point[1]);
        return $location >= 0 && ($location <= $this->size * $this->size-1) && $point[1] <= $this->size;
    }
    public function getNeighbours($point)
    {
        $count = 0;
        $x = $point[0];
        $y = $point[1];

        $count += (int) ($this->pointExists(array($x+1, $y)) && $this->getPoint(array($x+1, $y)));
        $count += (int) ($this->pointExists(array($x+1, $y+1)) && $this->getPoint(array($x+1, $y+1)));
        $count += (int) ($this->pointExists(array($x+1, $y-1)) && $this->getPoint(array($x+1, $y-1)));
        $count += (int) ($this->pointExists(array($x-1, $y)) && $this->getPoint(array($x-1, $y)));
        $count += (int) ($this->pointExists(array($x-1, $y+1)) && $this->getPoint(array($x-1, $y+1)));
        $count += (int) ($this->pointExists(array($x-1, $y-1)) && $this->getPoint(array($x-1, $y-1)));
        $count += (int) ($this->pointExists(array($x, $y+1)) && $this->getPoint(array($x, $y+1)));
        $count += (int) ($this->pointExists(array($x, $y-1)) && $this->getPoint(array($x, $y-1)));

        return $count;
    }

    public function cellNextGen($point)
    {
        $neighbours = $this->getNeighbours($point);
        $is_alive = $this->getPoint($point);

        return (int) ( ($is_alive) && ($neighbours == 2 || $neighbours == 3) || ($neighbours == 3) );
    }

    public function newGeneration($point_location = 0)
    {
        $x = (int) floor($point_location / $this->size);
        $y = (int) ($point_location % $this->size);
        
        $this->new_board[$point_location] = $this->cellNextGen(array($x, $y));
        
        return (($point_location == $this->size * $this->size - 1) && ($this->board = $this->new_board)) || $this->newGeneration($point_location + 1);
    }

    public function debug()
    {
        echo "\n\n\n";
        for ($i=0; $i < $this->size * $this->size; $i++)
        { 
            echo $this->board[$i] == "1" ? "X " : ". ";
            if ($i % $this->size == 4)
            {
                echo "\n";
            } 

        }
    }

}
?>
