<?php

use Marmelab\Dobble\Card;

class DobbleCardTest extends \PHPUnit_Framework_TestCase
{
    public function validIterables()
    {
        return [
            [[1, 2, 3]],
            [['A', 'B', 'C']],
            [['heart', 'square', 'diamond', 'club']],
        ];
    }

    /**
     * @dataProvider validIterables
     */
    public function testCardConstructorAcceptsIterable($iterable)
    {
        $card = new Card($iterable);
        $this->assertEquals($card->getSymbols(), $iterable);
    }

    public function invalidValues()
    {
        return [
            'string' => ['string'],
            'int' => [1],
            'float' => [0.3],
            'null' => [null],
        ];
    }

    /**
     * @dataProvider invalidValues
     * @expectedException TypeError
     */
    public function testCardConstructorRefusesNonIterable($value)
    {
        $card = new Card($value);
    }

    /**
     * @dataProvider validIterables
     */
    public function testCardIsCountable($iterable)
    {
        $card = new Card($iterable);
        $this->assertEquals(count($card), count($iterable));
    }
}
