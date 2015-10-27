<?php

use Marmelab\Dobble\Card;
use Marmelab\Dobble\Deck;

class DobbleDeckTest extends \PHPUnit_Framework_TestCase
{
    public function testDeckAcceptEmpty()
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
    public function testDeckAcceptValidCards($cards)
    {
        $deck = new Deck($cards);
        $this->assertEquals($deck->getCards(), $cards);
    }

    /**
     * @expectedException TypeError
     */
    public function testDeckRefuseOtherThanCard()
    {
        $deck = new Deck(['not', 'cards']);
    }

    public function testDeckRefuseOtherThanIterable()
    {
        try {
            $deck = new Deck('not an iterable');
            $this->fail('Deck must refuse non iterable value.');
        } catch (\InvalidArgumentException $e) {
            // Test pass
        }
    }

    /**
     * @dataProvider validCards
     * @depends testDeckAcceptValidCards
     */
    public function testDeckIsCountable($iterable)
    {
        $deck = new Deck($iterable);
        $this->assertTrue($deck instanceof \Countable);
        $this->assertEquals(count($deck), count($iterable));
    }
}
