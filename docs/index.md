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

Create new instance of Nexendrie\BookComponent\BookControl. The constructor requires 2 parameters: **presenterName** and **folder**. Property presenterName tells which presenter is responsible for rendering the component, folder determines where templates with your chapter/pages are stored. You can also pass a translator as third parameter.

After that, you have to tell the component about pages. Just add them as elements of array to property $pages. Each page has a slug (which is used to form its url) and name (which is shown in the list of pages and the top of the page itself). The page also needs a template which must be named *slug*.latte.

Example:

```php
<?php
use Nexendrie\BookComponent as Book;

$control = new Book\BookControl(":Front:Help", __DIR__ . "/help");
$control->pages[] = new Book\BookPage("introduction", "Úvod");
?>
```

It is possible to assign a callback to property $pages which returns Nexendrie\BookComponent\BookPagesStorage. It is a collection of pages.

```php
<?php
use Nexendrie\BookComponent as Book;

$control = new Book\BookControl(":Front:Help", __DIR__ . "/help");
$control->pages = function() {
  $storage = new Book\BookPagesStorage;
  $storage[] = new Book\BookPage("introduction", "Úvod");
  return $storage;
};
?>
```

If you need to pass any variables to your page, you have to extend the BookControl class and define method renderSlug() which is called when page slug is shown.

Example:

```php
<?php
use Nexendrie\BookComponent as Book;

class HelpControl extends Book\BookControl {
  function __construct() {
    parent::__construct(":Front:Help", __DIR__ . "/help");
    $this->pages[] = new Book\BookPage("introduction", "Úvod");
  }
  
  function renderIntroduction() {
    $this->template->myVariable = 13;
  }
}
?>
```

Alternatively, you can set the variables in onRender event:

```php
<?php
use Nexendrie\BookComponent as Book;

$control = new Book\BookControl(":Front:Help", __DIR__ . "/help");
$control->pages[] = new Book\BookPage("introduction", "Úvod");
$control->onRender[] = function(Book\BookControl $book, string $page) {
  if($page === "introduction") {
    $book->template->myVariable = 13;
  }
};
?>
```

.

Translations
------------
The (few) texts used by the component are in english but you can have them translated into another language if you prefer. If translation to your language of choice is shipped, you just need to set property $lang to abbreviation of the language, preferably in constructor. Example:
```php
<?php
use Nexendrie\BookComponent as Book;

class HelpControl extends Book\BookControl {
  function __construct() {
    $this->lang = "cs";
    parent::__construct(":Front:Help", __DIR__ . "/help");
  }
}
?>
```

If that translation (or some text of it) is not available, english variant is used.

If you wish, you can also use your own translator. Just set property $translator in constructor. List of all texts used by the component can be seen in *src/lang/book.en.neon*.

Custom templates
----------------

It is possible to use own templates for book index and pages. Just set the following properties of BookControl.

```php
<?php
use Nexendrie\BookComponent as Book;

$control = new Book\BookControl(":Front:Help", __DIR__ . "/help");
$control->indexTemplate = __DIR__ . "/customIndex.latte";
$control->pageTemplate = __DIR__ . "/customPage.latte";
?>
```
