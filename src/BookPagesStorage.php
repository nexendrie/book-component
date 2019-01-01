<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\Utils\Collection;

/**
 * @author Jakub Konečný
 */
final class BookPagesStorage extends Collection {
  /** @var string */
  protected $class = BookPage::class;
  /** @var string */
  protected $uniqueProperty = "slug";
  
  public function hasPage(string $slug): bool {
    return $this->hasItems(["slug" => $slug]);
  }
  
  /**
   * @return BookPage[]
   */
  public function getAllowedItems(): array {
    return $this->getItems(["allowed" => true]);
  }
}
?>