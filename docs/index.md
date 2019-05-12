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
declare(strict_types=1);

use Nexendrie\BookComponent as Book;

$control = new Book\BookControl(":Front:Help", __DIR__ . "/help");
$control->pages[] = new Book\BookPage("introduction", "Úvod");
?>
```

It is possible to assign a callback to property $pages which returns Nexendrie\BookComponent\BookPagesStorage. It is a collection of pages.

```php
<?php
declare(strict_types=1);

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
declare(strict_types=1);

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
declare(strict_types=1);

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

This component contains a few texts that need to be translated. This package (or any of its direct dependencies) does not contain a translator, you need to register one into Latte. We recommend package **nexendrie/translation**. 

This package though contains English and Czech translation in neon and PHP messages catalogue format. They can be found in folder *src/lang*. Default templates of this component do not use messages in default language but message ids in form book.*string*.

Custom templates
----------------

It is possible to use own templates for book index and pages. Just set the following properties of BookControl.

```php
<?php
declare(strict_types=1);

use Nexendrie\BookComponent as Book;

$control = new Book\BookControl(":Front:Help", __DIR__ . "/help");
$control->indexTemplate = __DIR__ . "/customIndex.latte";
$control->pageTemplate = __DIR__ . "/customPage.latte";
?>
```

Conditional pages
-----------------

Sometimes, you want to show certain pages only if a conditions is met. Defining conditions is easy, just use method addCondition on a page. The method takes two arguments, first is object implementing interface Nexendrie\BookComponent\IBookPageCondition, the second is additional parameter. Each condition is evaluated during template rendering and only if all of them are met, the page is shown (either in list of pages or the page itself).

There are a few default condition types: callback (the callback is passed as additional parameter), current user's permission (in format resource:privilege), current user's role and login status (logged in = true/logged out = false).
