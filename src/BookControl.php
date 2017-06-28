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
 * @method void onRender(BookControl $book, string $page)
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
  /** @var callable|BookPagesStorage */
  protected $pages;
  /** @var callable[] */
  public $onRender = [];
  
  public function __construct(string $presenterName, string $folder, ITranslator $translator = NULL) {
    parent::__construct();
    $this->presenterName = $presenterName;
    $this->folder = $folder;
    $this->translator = $translator;
    $this->pages = new BookPagesStorage;
  }
  
  /**
   * @return ITranslator|NULL
   */
  public function getTranslator(): ?ITranslator {
    return $this->translator;
  }
  
  /**
   * @param ITranslator $translator
   */
  public function setTranslator(ITranslator $translator) {
    $this->translator = $translator;
  }
  
  /**
   * @return string
   */
  public function getLang(): string {
    return $this->lang;
  }
  
  /**
   * @param string $lang
   */
  public function setLang(string $lang) {
    $this->lang = $lang;
  }
  
  /**
   * @return BookPagesStorage
   * @throws \InvalidArgumentException
   */
  public function getPages(): BookPagesStorage {
    if($this->pages instanceof BookPagesStorage) {
      return $this->pages;
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
  public function setPages(callable $pages) {
    $this->pages = $pages;
  }
  
  /**
   * @param string $page
   * @return void
   * @throws \InvalidArgumentException
   */
  public function render(string $page = "index"): void {
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
    $this->template->setFile(__DIR__ . "/bookIndex.latte");
    if($page !== "index") {
      $this->template->setFile(__DIR__ . "/bookPage.latte");
      $this->template->index = $pages->getIndex($page);
      $this->template->current = $pages[$this->template->index];
    }
    $this->template->pages = $pages;
    $method = "render" . ucfirst($page);
    $this->onRender($this, $page);
    if(method_exists($this, $method)) {
      call_user_func([$this, $method]);
    }
    $this->template->render();
  }
}
?>