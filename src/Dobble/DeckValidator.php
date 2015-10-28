<?php
namespace Marmelab\Dobble;

class DeckValidator
{
    public static function validate($deck)
    {
        $errors = []; // Until challenged
        $validators = [
            'validateDeckIsNotEmpty',
            'validateDeckHasNoIdenticalCards',
            'validateDeckCardsHaveSameSymbolNumber',
            'validateDeckCardsHaveUniqueSymbolsCouple',
        ];

        // Try all specified validators
        foreach($validators as $validator) {
            try {
                self::$validator($deck);
            } catch (DobbleException $e) {
                array_push($errors, $e->getMessage());
            }
        }

        // If one of them raise an exception, store its message
        // and re-raise it with potential others
        if (!empty($errors)) {
            throw new DobbleException(implode(', ', $errors));
        }
        
        return true;
    }

    private static function validateDeckIsNotEmpty($deck)
    {
        if (!count($deck)) {
            throw new DobbleException('The deck is empty');
        }
    }

    private static function validateDeckHasNoIdenticalCards($deck)
    {
        if (count(array_unique($deck->getCards())) < count($deck)) {
            throw new DobbleException('The deck has two or more identical cards');
        }
    }

    private static function validateDeckCardsHaveSameSymbolNumber($deck)
    {
        $countAllCards = array_map('count', $deck->getCards());
        if (count(array_unique($countAllCards)) > 1) {
            throw new DobbleException('Cards have different number of symbol');
        }
    }

    private static function validateDeckCardsHaveUniqueSymbolsCouple($deck)
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
        if (count(array_unique($symbolMap)) !== 1 || end($symbolMap) > 2) {
            throw new DobbleException('More than two cards have same symbol');
        }
    }
}
