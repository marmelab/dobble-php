<?php

use Marmelab\Dobble\Card;
use Marmelab\Dobble\Deck;
use Marmelab\Dobble\DeckValidator;
use Marmelab\Dobble\DobbleException;

class DobbleDeckValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function validCards()
    {
        return [
            [[new Card([1, 2]), new Card([2, 3]), new Card([3, 1])]],
            [[new Card(['A', 'B']), new Card(['B', 'C']), new Card(['C', 'A'])]],
            [[new Card(['a', 'lot', 'of', 'items', 'like', 'that'])]],
        ];
    }

    /**
     * @dataProvider validCards
     */
    public function testDeckValidatesGoodCards($iterable)
    {
        $deck = new Deck($iterable);
        $this->assertTrue(DeckValidator::validate($deck));
    }

    /**
     * @expectedException \Marmelab\Dobble\DobbleException
     */
    public function testDeckNotValidatesEmpty()
    {
        $deck = new Deck();
        DeckValidator::validate($deck);
    }

    /**
     * @expectedException \Marmelab\Dobble\DobbleException
     */
    public function testDeckNotValidatesMultipleSameCards()
    {
        $deck = new Deck([new Card([1, 2]), new Card([2, 1])]);
        DeckValidator::validate($deck);
    }

    /**
     * @expectedException \Marmelab\Dobble\DobbleException
     */
    public function testDeckNotValidatesCardWithDifferentNumberOfSymbol()
    {
        $deck = new Deck([new Card([1, 2]), new Card([1, 2, 3])]);
        DeckValidator::validate($deck);
    }
}
