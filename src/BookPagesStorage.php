<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\Utils\Collection;

/**
 * @author Jakub Konečný
 */
class BookPagesStorage extends Collection {
  /** @var string */
  protected $class = BookPage::class;
  /** @var string */
  protected $uniqueProperty = "slug";
  
  public function hasPage(string $slug): bool {
    return $this->hasItems(["slug" => $slug]);
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
    return $this->getItems(["allowed" => true]);
  }
}
?>