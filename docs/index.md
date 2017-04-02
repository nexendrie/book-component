Book Component
==============

This package will help you create a book in Nette Framework. It has a list of chapters/pages with links to the chapters/pages, from each chapter/page you can also jump to previous and next one.

Links
-----

Primary repository: https://gitlab.com/nexendrie/book-component
Github repository: https://github.com/nexendrie/book-component
Packagist: https://packagist.org/packages/nexendrie/book-component

Installation
------------
The best way to install it is via Composer. Just add **nexendrie/book-component** to your dependencies.

Usage
-----
After installation, you need to define a class which extends Nexendrie\BookComponent\BookControl. It has to define at least method **getPages**, in constructor you have to fill properties **presenterName** and **folder**. Property presenterName tells which presenter is responsible for rendering the component, folder determines where templates with your chapter/pages are stored.

Method getPages has to return object of Nexendrie\BookComponent\BookPagesStorage which represents a list of pages. Each page has a slug (which is used to form its url) and name (which is shown in the list of pages and the top of the page itself). The page also needs a template which must be named *slug*.latte.

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
  
  function getPages(): Book\BookPagesStorage {
    $storage = new Book\BookPagesStorage;
    $storage[] = new Book\BookPage("introduction", "Úvod");
    return $storage;
  }
}
```

Translations
------------
The (few) texts used by the component are in english but you can have them translated into another language if you prefer. If translation to your language of choice is shipped, you just need to set property $lang to abbreviation of the language, preferably in constructor. Example:
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

If you wish, you can also use your own translator. Just set property $translator in constructor. List of all texts used by the component can be seen in *src/lang/book.en.neon*.
