<?php
namespace Nexendrie\BookComponent;

use Nette\Localization\ITranslator;

/**
 * BookControl
 *
 * @author Jakub Konečný
 * @property ITranslator $translator
 * @property string $lang
 */
abstract class BookControl extends \Nette\Application\UI\Control {
  /** @var string */
  private $presenterName;
  /** @var string */
  private $folder;
  /** @var ITranslator */
  protected $translator;
  /** @var string */
  protected $lang;
  
  /**
   * @param string $presenterName
   * @param string $folder
   */
  function __construct($presenterName, $folder) {
    $this->presenterName = (string) $presenterName;
    $this->folder = (string) $folder;
  }
  
  /**
   * @return ITranslator
   */
  function getTranslator() {
    return $this->translator;
  }
  
  /**
   * @param ITranslator $translator
   */
  function setTranslator(ITranslator $translator) {
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
    if($this->lang) $this->translator->lang = $this->lang;
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