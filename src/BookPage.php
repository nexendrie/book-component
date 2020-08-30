<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * @author Jakub Konečný
 * @property-read bool $allowed
 */
class BookPage {
  use \Nette\SmartObject;
  public string $slug;
  public string $title;
  /** @var array of [IBookPageCondition, string] */
  protected array $conditions = [];
  
  public function __construct(string $slug, string $title) {
    $this->slug = $slug;
    $this->title = $title;
  }

  /**
   * @param mixed $parameter
   */
  public function addCondition(IBookPageCondition $condition, $parameter): void {
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