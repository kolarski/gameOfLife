<?php

/**
 * Class: GameOfLife 
 * Extends: PHPUnit_Framework_TestCase
 *
 */

class GameOfLifeTest extends PHPUnit_Framework_TestCase
{

    /*
     * SetUp Test cases
     *
     */
    public function setUp()
    {
      require_once('./GameOfLife.php');
      $this->board = new Board();
    }

    /*
     * Test: Test if class Game of life exists. (dummy test)
     */
    public function testGameOfLifeClass()
    {
        $this->assertEquals(class_exists('GameOfLife'), true);
    }

    public function testBoard()
    {
        $this->size = 5;
        $this->board->init($this->size);
        $point = array(rand(0, $this->size-1), rand(0, $this->size-1));
        $this->board->addPoint($point);
        $this->assertEquals($this->board->getPoint($point), 1);
        $this->board->removePoint($point);
        $this->assertEquals($this->board->getPoint($point), 0);

        $point = array($this->size-1, $this->size-1);
         $this->board->addPoint($point);
        $this->assertEquals($this->board->getPoint($point), 1);
        $this->board->removePoint($point);
        $this->assertEquals($this->board->getPoint($point), 0);

        $point = array(0,0);
        $this->board->addPoint($point);
        $this->assertEquals($this->board->getPoint($point), 1);
        $this->board->removePoint($point);
        $this->assertEquals($this->board->getPoint($point), 0);
    }

    public function testPointExists()
    {
        $this->size = 5;
        $this->board->init($this->size);

        $point = array(-1,-1);
        $this->assertEquals($this->board->pointExists($point), false);
        $point = array(0,-1);
        $this->assertEquals($this->board->pointExists($point), false);
        $point = array($this->size+1,0);
        $this->assertEquals($this->board->pointExists($point), false);
        $point = array(0, $this->size + 1);
        $this->assertEquals($this->board->pointExists($point), false);
        $point = array(1,1);
        $this->assertEquals($this->board->pointExists($point), true);
    }

    public function testGetNeighbours()
    {
        $this->size = 5;
        $this->board->init($this->size);

        $this->board->addPoint(array(0,1));
        $this->board->addPoint(array(1,0));
        $this->assertEquals($this->board->getNeighbours(array(0,0)), 2);

        $this->board->addPoint(array(1,1));
        $this->assertEquals($this->board->getNeighbours(array(0,0)), 3);
    }

    public function testCellNextGen()
    {
        $this->size = 5;
        $this->board->init($this->size);

        $this->board->addPoint(array(0,1));
        $this->board->addPoint(array(1,0));
        $this->board->addPoint(array(1,1));
        $this->assertEquals($this->board->cellNextGen(array(0,0)), 1);
        $this->assertEquals($this->board->cellNextGen(array(2,2)), 0);
        $this->assertEquals($this->board->cellNextGen(array(1,1)), 1);
        $this->assertEquals($this->board->cellNextGen(array(0,2)), 0);
        $this->board->addPoint(array(0,2));
        $this->assertEquals($this->board->cellNextGen(array(0,2)), 1);
    }

    public function testNewGeneration()
    {
        $this->size = 5;
        $this->board->init($this->size);

        $this->board->addPoint(array(0,1));
        $this->board->addPoint(array(1,0));
        $this->board->addPoint(array(1,1));
        $this->board->addPoint(array(2,2));
        $this->board->debug();
        $this->board->newGeneration();
        $this->board->debug();
        $this->assertEquals($this->board->getPoint(array(0,0)), 1);
        $this->assertEquals($this->board->getPoint(array(1,0)), 1);
        $this->assertEquals($this->board->getPoint(array(1,1)), 1);
        $this->assertEquals($this->board->getPoint(array(0,1)), 1);
        $this->assertEquals($this->board->getPoint(array(0,2)), 0);
        $this->assertEquals($this->board->getPoint(array(2,0)), 0);
        $this->board->newGeneration();
        $this->board->debug();
    }

}
