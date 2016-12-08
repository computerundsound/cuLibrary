<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.11.2016
 * Time: 05:34
 * 
 * Created by IntelliJ IDEA
 *
 */

require_once __DIR__ . '/../CuArray.php';

use computerundsound\culibrary\CuArray;

/**
 * Class CuArrayTest
 */
class CuArrayTest extends PHPUnit_Framework_TestCase {

    protected $cuArray;

    public function testSortArray() {

        $arrayToSort = [
            'cdrei' => 'a1',
            'aeins' => 'b2',
            'bzwei' => 'd4',
            'evier' => 'c3',
        ];

        $sortedArray = CuArray::sortArray($arrayToSort, 0, $parameter = SORT_ASC);

        $nthElement = array_slice($sortedArray, 3,1);

        $this->assertSame('bzwei', key($nthElement));

    }

    public function testIsInstanceOfCuArray() {

        $isInstance = is_a($this->cuArray, 'computerundsound\culibrary\CuArray');

        $this->assertTrue($isInstance);

    }

    protected function setUp() {

        $this->cuArray = new CuArray();

    }







}
