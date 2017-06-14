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
 * @property callable|BookPagesStorage $pages
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 */
class BookControl extends \Nette\Application\UI\Control {
  /** @var string */
  private $presenterName;
  /** @var string */
  private $folder;
  /** @var ITranslator|Translator|NULL */
  protected $translator;
  /** @var string */
  protected $lang;
  /** @var callable */
  protected $pages;
  
  function __construct(string $presenterName, string $folder, ITranslator $translator = NULL) {
    parent::__construct();
    $this->presenterName = $presenterName;
    $this->folder = $folder;
    $this->translator = $translator;
  }
  
  /**
   * @return ITranslator|NULL
   */
  function getTranslator(): ?ITranslator {
    return $this->translator;
  }
  
  /**
   * @param ITranslator $translator
   */
  function setTranslator(ITranslator $translator) {
    $this->translator = $translator;
  }
  
  /**
   * @return string
   */
  function getLang(): string {
    return $this->lang;
  }
  
  /**
   * @param string $lang
   */
  function setLang(string $lang) {
    $this->lang = $lang;
  }
  
  /**
   * @return BookPagesStorage
   * @throws \InvalidArgumentException
   */
  function getPages(): BookPagesStorage {
    if(is_null($this->pages)) {
      return new BookPagesStorage;
    }
    $pages = call_user_func($this->pages);
    if(!$pages instanceof BookPagesStorage) {
      throw new \InvalidArgumentException("Callback for pages for BookControl has to return " . BookPagesStorage::class . ".");
    }
    return $pages;
  }
  
  /**
   * @param callable $pages
   */
  function setPages(callable $pages) {
    $this->pages = $pages;
  }
  
  /**
   * @param string $page
   * @return void
   * @throws \InvalidArgumentException
   */
  function render(string $page = "index"): void {
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