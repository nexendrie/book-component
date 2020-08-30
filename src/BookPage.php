<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * @author Jakub Konečný
 * @property-read bool $allowed
 */
class BookPage {
  use \Nette\SmartObject;

  /** @var array of [IBookPageCondition, string] */
  protected array $conditions = [];
  
  public function __construct(public string $slug, public string $title) {
  }

  /**
   * @param mixed $parameter
   */
  public function addCondition(BookPageCondition $condition, $parameter): void {
    $this->conditions[] = [$condition, $parameter];
  }

  /**
   * @deprecated Access the property directly
   */
  public function isAllowed(): bool {
    foreach($this->conditions as $condition) {
      if(!$condition[0]->isAllowed($condition[1])) {
        return false;
      }
    }
    return true;
  }
}
?>