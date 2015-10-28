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

    public function testDeckNotValidatesEmpty()
    {
        try {
            $deck = new Deck();
            DeckValidator::validateDeckIsNotEmpty($deck);
            $this->fail('Validation must not validate empty deck.');
        } catch (DobbleException $e) {
            // Test pass
        }
    }

    public function testDeckNotValidatesMultipleSameCards()
    {
        try {
            $deck = new Deck([new Card([1, 2]), new Card([2, 1])]);
            DeckValidator::validateDeckHasNoIdenticalCards($deck);
            $this->fail('Validation must not validate multiple same cards.');
        } catch (DobbleException $e) {
            // Test pass
        }
    }

    public function testDeckNotValidatesCardWithDifferentNumberOfSymbol()
    {
        try {
            $deck = new Deck([new Card([1, 2]), new Card([1, 2, 3])]);
            DeckValidator::validateDeckCardsHaveSameSymbolNumber($deck);
            $this->fail('Validation must not validate cards with different number of symbol');
        } catch (DobbleException $e) {
            // Test pass
        }
    }

    public function testDeckNotValidatesMoreThanTwoSymbols()
    {
        try {
            $deck = new Deck([new Card([1]), new Card([1]), new Card([1])]);
            DeckValidator::validateDeckCardsHaveUniqueSymbolsCouple($deck);
            $this->fail('Validation must not validate more than two same symbols');
        } catch (DobbleException $e) {
            // Test pass
        }
    }
}
