<?php

namespace Marmelab\Dobble;

abstract class DeckValidator
{
    public static function validate($deck)
    {
        self::validateDeckIsNotEmpty($deck);
        self::validateDeckHasNoIdenticalCards($deck);
        self::validateDeckCardsHaveSameSymbolNumber($deck);
        self::validateDeckCardsHaveUniqueSymbolsCouple($deck);

        return true;
    }

    public static function validateDeckIsNotEmpty($deck)
    {
        if (!count($deck)) {
            throw new DobbleException('The deck is empty');
        }
    }

    public static function validateDeckHasNoIdenticalCards($deck)
    {
        if (count(array_unique($deck->getCards())) < count($deck)) {
            throw new DobbleException('The deck has two or more identical cards');
        }
    }

    public static function validateDeckCardsHaveSameSymbolNumber($deck)
    {
        $countAllCards = array_map('count', $deck->getCards());
        if (count(array_unique($countAllCards)) > 1) {
            throw new DobbleException('Cards have different number of symbol');
        }
    }

    public static function validateDeckCardsHaveUniqueSymbolsCouple($deck)
    {
        $symbols = array();

        // Fetch all symbols
        foreach ($deck->getCards() as $card) {
            foreach ($card->getSymbols() as $symbol) {
                array_push($symbols, $symbol);
            }
        }

        // Count all symbol in array
        $symbolMap = array_count_values($symbols);

        // If one of them is counted more than twice, raise exception
        if (count(array_unique($symbolMap)) != 1 || end($symbolMap) > 2) {
            throw new DobbleException('More than two cards have same symbol');
        }
    }
}
