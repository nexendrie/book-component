<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * @author Jakub Konečný
 * @property-read string $slug
 * @property-read string $title
 */
class BookPage {
  use \Nette\SmartObject;
  /** @var string */
  protected $slug;
  /** @var string */
  protected $title;
  
  public function __construct(string $slug, string $title) {
    $this->slug = $slug;
    $this->title = $title;
  }
  
  public function getSlug(): string {
    return $this->slug;
  }
  
  public function getTitle(): string {
    return $this->title;
  }
}
?>