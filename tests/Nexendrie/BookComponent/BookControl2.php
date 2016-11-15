<?php
namespace Nexendrie\BookComponent;

class BookControl2 extends BookControl {
  function __construct() {
    parent::__construct("Test", __DIR__);
  }
  
  /**
   * @return BookPagesStorage
   */
  function getPages() {
    $storage = new BookPagesStorage;
    $storage[] = new BookPage("slug1", "title1");
    $storage[] = new BookPage("slug2", "title2");
    $storage[] = new BookPage("slug3", "title3");
    return $storage;
  }
  
  /**
   * @return void
   */
  function renderSlug1() {
    $this->template->var = "Lorem Ipsum.";
  }
}
?>