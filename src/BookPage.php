<?php
namespace JK\BookComponent;

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
  
  /**
   * @param string $slug
   * @param string $title
   */
  function __construct($slug, $title) {
    $this->slug = $slug;
    $this->title = $title;
  }
  
  /**
   * @return string
   */
  function getSlug() {
    return $this->slug;
  }
  
  /**
   * @return string
   */
  function getTitle() {
    return $this->title;
  }
}
?>