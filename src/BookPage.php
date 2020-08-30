<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * @author Jakub Konečný
 * @property-read string $slug
 * @property-read string $title
 * @property-read bool $allowed
 */
class BookPage {
  use \Nette\SmartObject;
  /** @var string */
  protected $slug;
  /** @var string */
  protected $title;
  /** @var array of [IBookPageCondition, string] */
  protected $conditions = [];
  
  public function __construct(string $slug, string $title) {
    $this->slug = $slug;
    $this->title = $title;
  }

  /**
   * @deprecated Access the property directly
   */
  public function getSlug(): string {
    return $this->slug;
  }

  /**
   * @deprecated Access the property directly
   */
  public function getTitle(): string {
    return $this->title;
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