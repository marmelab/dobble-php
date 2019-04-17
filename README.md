<table>
        <tr>
            <td><img width="120" src="https://cdnjs.cloudflare.com/ajax/libs/octicons/8.5.0/svg/rocket.svg" alt="onboarding" /></td>
            <td><strong>Archived Repository</strong><br />
            The code of this repository was written during a <a href="https://marmelab.com/blog/2018/09/05/agile-integration.html">Marmelab agile integration</a>. <a href="https://marmelab.com/blog/2015/11/05/de-python-a-php-7-l-algorithme-de-dobble.html">The associated blog post</a> illustrates the efforts of the new hiree, who had to implement a board game in several languages and platforms as part of his initial learning.<br />
        <strong>This code is not intended to be used in production, and is not maintained.</strong>
        </td>
        </tr>
</table>

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
