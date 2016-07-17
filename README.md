Book Component
==============

[![Total Downloads](https://poser.pugx.org/konecnyjakub/book-component/downloads)](https://packagist.org/packages/konecnyjakub/book-component) [![Latest Stable Version](https://poser.pugx.org/konecnyjakub/book-component/v/stable)](https://packagist.org/packages/konecnyjakub/book-component) [![Latest Unstable Version](https://poser.pugx.org/konecnyjakub/book-component/v/unstable)](https://packagist.org/packages/konecnyjakub/book-component) [![License](https://poser.pugx.org/konecnyjakub/book-component/license)](https://github.com/konecnyjakub/book-component/blob/master/LICENSE)

This package will help you create a book in Nette Framework. It has a list of chapters/pages with links to the chapters/pages, from each chapter/page you can also jump to previous and next one.

Installation
------------
The best way to install it is via Composer. Just add **konecnyjakub/book-component** to your dependencies.

Usage
-----
After installation, you need to define a class that extends JK\BookComponent\BookControl. It has to define at least method **getPages**, in constructor you have to fill properties **presenterName** and **folder**. Property presenterName tells which presenter is responsible for rendering the component, folder determine where templates with your chapter/pages are stored.

Method getPages has to return object of JK\BookComponent\BookPagesStorage which represents a list of pages. Each page has a slug (which is used to form its url) and name (which is shown in the list of pages and the top of the page itself). The page also needs a template which name must be *slug*.latte.

If you need to pass any variables to your page, you can do that in method renderSlug. Just use

```php
$this->template->variable = whatever();
```

Example
-------

```php
class HelpControl extends \JK\BookComponent\BookControl {
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