<?php
namespace JK\BookComponent;

/**
 * BookControl
 *
 * @author Jakub Konečný
 */
abstract class BookControl extends \Nette\Application\UI\Control {
  /** @var string */
  private $presenterName;
  /** @var string */
  private $folder;
  
  /**
   * @param string $presenterName
   * @param string $folder
   */
  function __construct($presenterName, $folder) {
    $this->presenterName = (string) $presenterName;
    $this->folder = (string) $folder;
  }
  
  /** @return BookPagesStorage */
  abstract function getPages();
  
  /**
   * @param string $page
   * @return void
   */
  function render($page) {
    $template = $this->template;
    $template->presenterName = $this->presenterName;
    $template->folder = $this->folder;
    $pages = $this->getPages();
    if(!$pages->hasPage($page)) $page = "index";
    if($page === "index") {
      $template->setFile(__DIR__ . "/bookIndex.latte");
    } else {
      $template->setFile(__DIR__ . "/bookPage.latte");
      $template->index = $pages->getIndex($page);
      $template->current = $pages[$template->index];
    }
    $template->pages = $pages;
    $method = "render" . ucfirst($page);
    if(method_exists($this, $method)) call_user_func([$this, $method]);
    $template->render();
  }
}
?>