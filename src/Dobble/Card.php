<?php

namespace Marmelab\Dobble;

class Card implements \Countable
{
    /**
     * @todo DobbleSymbol class
     */
    private $symbols = [];

    public function __construct(array $symbols)
    {
        $this->symbols = $symbols;

        // The deck validation uses the fonction "array_unique" to check
        // if some cards have same values, so we need to sort symbols
        // for avoid that same values seems differents.
        asort($this->symbols);
    }

    public function __toString()
    {
        return sprintf('<DobbleCard: %s>', implode(', ', $this->symbols));
    }

    public function count()
    {
        return count($this->symbols);
    }

    public function getSymbols()
    {
        return $this->symbols;
    }
}
