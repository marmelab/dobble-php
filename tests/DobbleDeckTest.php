<?php

use Marmelab\Dobble\Card;
use Marmelab\Dobble\Deck;
use Marmelab\Dobble\DobbleException;

class DobbleDeckTest extends \PHPUnit_Framework_TestCase
{
    public function testDeckConstructorAcceptsEmpty()
    {
        $deck = new Deck();
        $this->assertTrue(empty($deck->getCards()));
    }

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
    public function testDeckConstructorAcceptsValidCards($cards)
    {
        $deck = new Deck($cards);
        $this->assertEquals($deck->getCards(), $cards);
    }

    /**
     * @expectedException TypeError
     */
    public function testDeckConstructorRefusesOtherThanCard()
    {
        $deck = new Deck(['not', 'cards']);
    }

    /**
     * @expectedException TypeError
     */
    public function testDeckConstructorRefusesOtherThanIterable()
    {
        $deck = new Deck('not an iterable');
    }

    /**
     * @dataProvider validCards
     */
    public function testDeckIsCountable($iterable)
    {
        $deck = new Deck($iterable);
        $this->assertTrue($deck instanceof \Countable);
        $this->assertEquals(count($deck), count($iterable));
    }

    /**
     * @dataProvider validCards
     */
    public function testDeckValidatesGoodCards($iterable)
    {
        $deck = new Deck($iterable);
        $this->assertTrue($deck->validate());
    }

    public function testDeckNotValidatesEmpty()
    {
        try {
            $deck = new Deck();
            $deck->validate();
            $this->fail('Validation must not validate empty deck.');
        } catch (DobbleException $e) {
            // Test pass
        }
    }

    public function testDeckNotValidatesMultipleSameCards()
    {
        try {
            $deck = new Deck([new Card([1, 2]), new Card([2, 1])]);
            $deck->validate();
            $this->fail('Validation must not validate multiple same cards.');
        } catch (DobbleException $e) {
            // Test pass
        }
    }

    public function testDeckNotValidatesCardWithDifferentNumberOfSymbol()
    {
        try {
            $deck = new Deck([new Card([1, 2]), new Card([1, 2, 3])]);
            $deck->validate();
            $this->fail('Validation must not validate cards with different number of symbol');
        } catch (DobbleException $e) {
            //Test pass
        }
    }
}
