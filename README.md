[![Build Status](https://travis-ci.org/marmelab/dobble-php.svg)](https://travis-ci.org/marmelab/dobble-php)

# dobble-php
Command-line card generator for dobble-like game

# Installation

Run the following command

```bash
make install
```

# Use

Pending the final .phar file, you can use symfony command :

```bash
php src/application.php dobble:run -h
```

# Unit tests

```bash
make test
```

# Rules
Dobble rules implemented in this software :

- There is at least one card

- Each card is unique

- All cards have same amount of symbols

- A card has one and only one pair with all other cards
