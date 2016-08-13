<?php
namespace JK\BookComponent;

/**
 * BookControl
 *
 * @author Jakub Konečný
 * @property \Nette\Localization\ITranslator $translator
 */
abstract class BookControl extends \Nette\Application\UI\Control {
  /** @var string */
  private $presenterName;
  /** @var string */
  private $folder;
  /** @var \Nette\Localization\ITranslator */
  protected $translator;
  
  /**
   * @param string $presenterName
   * @param string $folder
   */
  function __construct($presenterName, $folder) {
    $this->presenterName = (string) $presenterName;
    $this->folder = (string) $folder;
  }
  
  /**
   * @return \Nette\Localization\ITranslator
   */
  function getTranslator() {
    return $this->translator;
  }
  
  /**
   * @param \Nette\Localization\ITranslator $translator
   */
  function setTranslator(\Nette\Localization\ITranslator $translator) {
    $this->translator = $translator;
  }
  
  /** @return BookPagesStorage */
  abstract function getPages();
  
  /**
   * @param string $page
   * @return void
   */
  function render($page = "index") {
    $this->template->presenterName = $this->presenterName;
    $this->template->folder = $this->folder;
    if(is_null($this->translator)) $this->translator = new Translator;
    $this->template->setTranslator($this->translator);
    $pages = $this->getPages();
    if(!$pages->hasPage($page)) $page = "index";
    if($page === "index") {
      $this->template->setFile(__DIR__ . "/bookIndex.latte");
    } else {
      $this->template->setFile(__DIR__ . "/bookPage.latte");
      $this->template->index = $pages->getIndex($page);
      $this->template->current = $pages[$this->template->index];
    }
    $this->template->pages = $pages;
    $method = "render" . ucfirst($page);
    if(method_exists($this, $method)) call_user_func([$this, $method]);
    $this->template->render();
  }
}
?>
