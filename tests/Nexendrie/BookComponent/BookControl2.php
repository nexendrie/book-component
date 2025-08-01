<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

final class BookControl2 extends BookControl {
  public function __construct() {
    parent::__construct("Test", __DIR__);
    $this->pages = function(): BookPagesStorage {
      $storage = new BookPagesStorage();
      $storage[] = new BookPage("slug1", "title1");
      $storage[] = new BookPage("slug2", "title2");
      $storage[] = new BookPage("slug3", "title3");
      $conditionalPage = new BookPage("slug4", "title4");
      $conditionalPage->addCondition(new class() implements BookPageCondition {
        /**
         * @param mixed $parameter
         */
        public function isAllowed($parameter = null): bool {
          return false;
        }
      }, null);
      $storage[] = $conditionalPage;
      return $storage;
    };
    $this->onRender[] = function(BookControl $book, string $page): void {
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