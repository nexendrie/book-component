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
  
  /**
   * @param string $slug
   * @return bool
   */
  function hasPage(string $slug): bool {
    foreach($this as $page) {
      if($page->slug === $slug) {
        return true;
      }
    }
    return false;
  }
  
  /**
   * @param string $slug
   * @return int|NULL
   */
  function getIndex(string $slug): ?int {
    foreach($this as $index => $page) {
      if($page->slug === $slug) {
        return $index;
      }
    }
    return NULL;
  }
}
?>