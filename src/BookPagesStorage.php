<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\Utils\Collection;

/**
 * @author Jakub Konečný
 */
class BookPagesStorage extends Collection {
  protected $class = BookPage::class;
  protected $uniqueProperty = "slug";
  
  public function hasPage(string $slug): bool {
    foreach($this->getAllowedItems() as $page) {
      if($page->slug === $slug) {
        return true;
      }
    }
    return false;
  }
  
  public function getIndex(string $slug): ?int {
    foreach($this as $index => $page) {
      if($page->slug === $slug) {
        return $index;
      }
    }
    return null;
  }
  
  /**
   * @return BookPage[]
   */
  public function getAllowedItems(): array {
    return array_values(array_filter($this->items, function(BookPage $item) {
      return $item->isAllowed();
    }));
  }
}
?>