<?php
namespace Nexendrie\BookComponent;

/**
 * @author Jakub Konečný
 */
class BookPagesStorage extends \Nette\Utils\ArrayList {
  /**
   * @param mixed $index
   * @param BookPage $page
   * @throws \InvalidArgumentException
   * @throws \RuntimeException
   */
  function offsetSet($index, $page) {
    if(!$page instanceof BookPage) {
      throw new \InvalidArgumentException("Argument must be of type HelpPage.");
    } elseif($this->hasPage($page->slug)) {
      throw new \RuntimeException("Duplicate slug $page->slug.");
    }
    parent::offsetSet($index, $page);
  }
  
  /**
   * @param string $slug
   * @return bool
   */
  function hasPage($slug) {
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
  function getIndex($slug) {
    foreach($this as $index => $page) {
      if($page->slug === $slug) {
        return $index;
      }
    }
    return NULL;
  }
}
?>