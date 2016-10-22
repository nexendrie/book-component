Book Component
==============

[![Total Downloads](https://poser.pugx.org/nexendrie/book-component/downloads)](https://packagist.org/packages/nexendrie/book-component) [![Latest Stable Version](https://poser.pugx.org/nexendrie/book-component/v/stable)](https://packagist.org/packages/nexendrie/book-component) [![Latest Unstable Version](https://poser.pugx.org/nexendrie/book-component/v/unstable)](https://packagist.org/packages/nexendrie/book-component) [![Build Status](https://travis-ci.org/nexendrie/book-component.svg?branch=master)](https://travis-ci.org/nexendrie/book-component) [![Coverage Status](https://coveralls.io/repos/github/nexendrie/book-component/badge.svg?branch=master)](https://coveralls.io/github/nexendrie/book-component?branch=master) [![License](https://poser.pugx.org/nexendrie/book-component/license)](https://gitlab.com/nexendrie/book-component/blob/master/LICENSE)

This package will help you create a book in Nette Framework. It has a list of chapters/pages with links to the chapters/pages, from each chapter/page you can also jump to previous and next one.

Installation
------------
The best way to install it is via Composer. Just add **nexendrie/book-component** to your dependencies.

Usage
-----
After installation, you need to define a class that extends Nexendrie\BookComponent\BookControl. It has to define at least method **getPages**, in constructor you have to fill properties **presenterName** and **folder**. Property presenterName tells which presenter is responsible for rendering the component, folder determine where templates with your chapter/pages are stored.

Method getPages has to return object of Nexendrie\BookComponent\BookPagesStorage which represents a list of pages. Each page has a slug (which is used to form its url) and name (which is shown in the list of pages and the top of the page itself). The page also needs a template which name must be *slug*.latte.

If you need to pass any variables to your page, you can do that in method renderSlug. Just use

```php
$this->template->variable = whatever();
```

Example
-------

```php
use Nexendrie\BookComponent as Book;

class HelpControl extends Book\BookControl {
  function __construct() {
    parent::__construct(":Front:Help", __DIR__ . "/help");
  }
  
  function renderIntroduction() {
    $this->template->myVariable = 13;
  }
  
  function getPages() {
    $storage = new Book\BookPagesStorage;
    $storage[] = new Book\BookPage("introduction", "Úvod");
    return $storage;
  }
}
```

Translations
------------
The (few) texts used by the component are in english but you can have them translated into another language if you prefer. If translation to your language of choice is shipped, you just need to set property $lang to abbreviation of the language them, preferably in constructor. Example:
```php
use Nexendrie\BookComponent as Book;

class HelpControl extends Book\BookControl {
  function __construct() {
    $this->lang = "cs";
    parent::__construct(":Front:Help", __DIR__ . "/help");
  }
}
```
If that translation (or some text of it) is not available, english variant is used.

If you wish, you can also use your own translator. Just set property $translator in constructor. List of all texts used by the component can be seen in *src/lang/en.neon*.

