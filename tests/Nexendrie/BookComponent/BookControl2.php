<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

class BookControl2 extends BookControl {
  public function __construct() {
    parent::__construct("Test", __DIR__);
    $this->pages = function() {
      $storage = new BookPagesStorage;
      $storage[] = new BookPage("slug1", "title1");
      $storage[] = new BookPage("slug2", "title2");
      $storage[] = new BookPage("slug3", "title3");
      return $storage;
    };
    $this->onRender[] = function(BookControl $book, string $page) {
      if($page === "slug1") {
        $book->template->var2 = "Dota.";
      }
    };
  }
  
  public function renderSlug1(): void {
    $this->template->var1 = "Lorem Ipsum.";
  }
}
?>