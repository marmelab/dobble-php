<?php

namespace Marmelab\Dobble;

use Countable;

class Card implements Countable
{
    /**
     * @todo DobbleSymbol class
     */
    private $symbols = [];

    public function __construct(array $symbols)
    {
        $this->symbols = $symbols;
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
