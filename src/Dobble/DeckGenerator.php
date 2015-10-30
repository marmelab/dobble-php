<?php

namespace Marmelab\Dobble;

class DeckGenerator
{
    const ALGO_MINI = 0;
    const ALGO_DEFAULT = 1;

    private $elementsPerCard = 0;

    private $mode = self::ALGO_DEFAULT;

    public function __construct(int $elementsPerCard, int $mode = self::ALGO_DEFAULT)
    {
        if ($elementsPerCard <= 1) {
            throw new \InvalidArgumentException('Invalid amount of elements per card');
        }

        if (!in_array($mode, [self::ALGO_MINI, self::ALGO_DEFAULT])) {
            throw new \InvalidArgumentException('Invalid generation mode');
        }

        $this->elementsPerCard = $elementsPerCard;
        $this->mode = $mode;
    }

    private function getSymbol($index = 0)
    {
        return Card::getUniqueSymbols($index);
    }

    private function getSymbolRange($n, $index = 0)
    {
        $symbols = [];

        for ($i = 0, $c = $index + $n; $i < $c; ++$i) {
            array_push($symbols, $this->getSymbol($i));
        }

        return $symbols;
    }

    private function buildDeck($cards)
    {
        $cleanedCards = [];
        foreach ($cards as $card) {
            array_push($cleanedCards, new Card($card));
        }

        return new Deck($cleanedCards);
    }

    private function generateMini()
    {
        $cards = [];

        // The first card is simple
        // It's the first range of symbols
        $cards[0] = $this->getSymbolRange($this->elementsPerCard);
        $currentIndex = $this->elementsPerCard;

        // For generating all other cards, we need to iterate over first card
        $i = 0;
        foreach ($cards[0] as $symbol) {
            $new_card = []; // Until challenged

            // We link all cards with the new with unique symbol
            foreach ($cards as $card) {
                array_push($new_card, $card[$i]);
            }

            // If and while the card has not enough symbol
            // We add it new unique symb
            while (count($new_card) < $this->elementsPerCard) {
                array_push($new_card, $this->getSymbol($currentIndex));
                ++$currentIndex;
            }

            // The card is ready to push in the deck
            $cards[$i + 1] = $new_card;
            ++$i;
        }

        return $this->buildDeck($cards);
    }

    /**
     * @param $modulo Integer modulo
     * @return array(matrix, infinity) A matrix of unique values
     *                                 for integer modulo and its
     *                                 array of points at infinity
     */
    private function generateProjectivePlan($modulo)
    {
        $matrix = [];
        $infinity = [];
        $currentIndex = 0;

        // Matrix generation
        for($i = 0; $i < $modulo; ++$i) {
            $matrix[$i] = [];
            for($j = 0; $j < $modulo; ++$j) {
                $matrix[$i][$j] = $this->getSymbol($currentIndex);
                ++$currentIndex;
            }
        }

        // List of points at infinity generation
        for($i = 0; $i < $modulo + 1; ++$i) {
            $infinity[$i] = $this->getSymbol($currentIndex);
            ++$currentIndex;
        }

        return [$matrix, $infinity];
    }

    /**
     * @param $modulo Integer modulo
     * @param $matrix Matrix of unique values for given integer modulo
     * @param $infinity List of points at infinity for given integer modulo
     * @param $a Draw a line for f(x) = ax + b
     * @param $b Draw a line for f(x) = ax + b
     * @param $f For $f = 5, draw a line for f(5). If given, $a and $b will be ignored
     * @return array All points through which pass the line
     */
    private function fetchLine($modulo, $matrix, $infinity, $a, $b, $f = null)
    {
        $coords = []; // Coordinates of all points
        $points = [];

        for($i = 0; $i < $modulo; ++$i) {
            if ($f === null) {
                // f(x) = ax + b
                // We apply the modulo operation to results because
                // There is not integers but modulo integers
                $x = $i % $modulo;
                $y = ($a * $i + $b) % $modulo;
            } else {
                $x = $f;
                $y = $i % $modulo;
            }

            // Add the calculated coordinates to the list
            array_push($coords, [$x, $y]);
        }

        // Fetching the value for all points
        foreach($coords as $coord) {
            $x = $coord[0];
            $y = $coord[1];
            array_push($points, $matrix[$y][$x]);
        }

        // Add the last point at infinity
        if ($f === null) {
            array_push($points, $infinity[$a + 1]);
        } else {
            array_push($points, $infinity[0]);
        }

        return $points;
    }

    /**
     * @param $modulo Integer modulo
     * @param $matrix
     * @param $infinity
     * @return array All lines of the projective plan
     */
    private function fetchAllLines($modulo, $matrix, $infinity)
    {
        $lines = [[]];

        // The first line is the line which pass to all points at infinity
        foreach($infinity as $point) {
            array_push($lines[0], $point);
        }

        // Fetch all verticals lines
        for($i = 0; $i < $modulo; ++$i) {
            $line = $this->fetchLine($modulo, $matrix, $infinity, 0, 0, $i);
            array_push($lines, $line);
        }

        // Finally, fetch all lines for f(x) = ax + b
        for($a = 0; $a < $modulo; ++$a) {
            for($b = 0; $b < $modulo; ++$b) {
                $line = $this->fetchLine($modulo, $matrix, $infinity, $a, $b);
                array_push($lines, $line);
            }
        }

        return $lines;
    }

    /**
     * @description Apply a quadric equation to resolve the formula : modulo = x*x + x + 1
     * @param $nbSymbols Amount of symbols in all projective plan
     * @return int Integer modulo
     */
    private function calculateModulo($nbSymbols)
    {
        $delta = -3 + 4 * $nbSymbols;

        if ($delta < 0) {
            return false;
        } elseif ($delta == 0) {
            $r = sqrt($delta) / 2;
            return (int)$r;
        } else {
            $r1 = (1 + sqrt($delta)) / 2;
            $r2 = (1 - sqrt($delta)) / 2;

            if ($r1 > 0) {
                return (int)$r1;
            } elseif ($r2 > 0) {
                return (int)$r2;
            } else {
                return false;
            }
        }
    }

    private function generateDefault()
    {
        $modulo = $this->elementsPerCard - 1;

        if (!$modulo)
            throw new DobbleException('Unable to generate');

        $projectivePlan = $this->generateProjectivePlan($modulo);
        $matrix = $projectivePlan[0];
        $infinity = $projectivePlan[1];

        $cards = $this->fetchAllLines($modulo, $matrix, $infinity);

        $deck = $this->buildDeck($cards);

        // This method can generate unvalid deck
        // So we try it before to return it
        $deck->validate();
        return $deck;
    }

    public function generate()
    {
        if ($this->mode == self::ALGO_DEFAULT) {
            return $this->generateDefault();
        } else {
            return $this->generateMini();
        }
    }
}
