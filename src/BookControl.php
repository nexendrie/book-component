<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Localization\ITranslator,
    Nexendrie\Translation\Translator,
    Nexendrie\Translation\Loaders\MessagesCatalogue;

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
  function __construct(string $presenterName, string $folder) {
    $this->presenterName = $presenterName;
    $this->folder = $folder;
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
  function render(string $page = "index") {
    $this->template->presenterName = $this->presenterName;
    $this->template->folder = $this->folder;
    if(is_null($this->translator)) {
      $loader = new MessagesCatalogue;
      $loader->folders = [__DIR__ . "/lang"];
      $this->translator = new Translator($loader);
    }
    if($this->lang) {
      $this->translator->lang = $this->lang;
    }
    $this->template->setTranslator($this->translator);
    $pages = $this->getPages();
    if(!$pages->hasPage($page)) {
      $page = "index";
    }
    if($page === "index") {
      $this->template->setFile(__DIR__ . "/bookIndex.latte");
    } else {
      $this->template->setFile(__DIR__ . "/bookPage.latte");
      $this->template->index = $pages->getIndex($page);
      $this->template->current = $pages[$this->template->index];
    }
    $this->template->pages = $pages;
    $method = "render" . ucfirst($page);
    if(method_exists($this, $method)) {
      call_user_func([$this, $method]);
    }
    $this->template->render();
  }
}
?>