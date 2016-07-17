<?php
namespace JK\BookComponent;

/**
 * @author Jakub Konečný
 * @property-read string $slug
 * @property-read string $title
 */
class BookPage extends \Nette\Object {
  /** @var string */
  protected $slug;
  /** @var string */
  protected $title;
  
  /**
   * @param string $slug
   * @param string $title
   */
  function __construct($slug, $title) {
    $this->slug = $slug;
    $this->title = $title;
  }
  
  function getSlug() {
    return $this->slug;
  }

  function getTitle() {
    return $this->title;
  }
}
?>