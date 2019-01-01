<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Localization\ITranslator;
use Nexendrie\Translation\Translator;
use Nexendrie\Translation\Loaders\MessagesCatalogue;

/**
 * BookControl
 *
 * @author Jakub Konečný
 * @property ITranslator $translator
 * @property string $lang
 * @property callable|BookPagesStorage $pages
 * @property string $indexTemplate
 * @property string $pageTemplate
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 * @method void onRender(BookControl $book, string $page)
 */
class BookControl extends \Nette\Application\UI\Control {
  /** @var string */
  private $presenterName;
  /** @var string */
  private $folder;
  /** @var ITranslator|Translator|null */
  protected $translator;
  /** @var string */
  protected $lang = "";
  /** @var callable|BookPagesStorage */
  protected $pages;
  /** @var string */
  protected $indexTemplate = __DIR__ . "/bookIndex.latte";
  /** @var string */
  protected $pageTemplate = __DIR__ . "/bookPage.latte";
  /** @var callable[] */
  public $onRender = [];
  
  public function __construct(string $presenterName, string $folder, ITranslator $translator = null) {
    parent::__construct();
    $this->presenterName = $presenterName;
    $this->folder = $folder;
    $this->translator = $translator;
    $this->pages = new BookPagesStorage();
  }
  
  public function getTranslator(): ?ITranslator {
    return $this->translator;
  }
  
  public function setTranslator(ITranslator $translator): void {
    $this->translator = $translator;
  }
  
  public function getLang(): string {
    return $this->lang;
  }
  
  public function setLang(string $lang): void {
    $this->lang = $lang;
  }
  
  /**
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
    /** @var BookPagesStorage $pages */
    $pages = BookPagesStorage::fromArray($pages->getAllowedItems());
    return $pages;
  }
  
  public function setPages(callable $pages): void {
    $this->pages = $pages;
  }
  
  /**
   * @throws \RuntimeException
   */
  protected function checkTemplatePath(string $path): void {
    if(!is_file($path)) {
      throw new \RuntimeException("File $path does not exist.");
    }
  }
  
  public function getIndexTemplate(): string {
    return $this->indexTemplate;
  }
  
  public function setIndexTemplate(string $indexTemplate): void {
    $this->checkTemplatePath($indexTemplate);
    $this->indexTemplate = $indexTemplate;
  }
  
  public function getPageTemplate(): string {
    return $this->pageTemplate;
  }
  
  public function setPageTemplate(string $pageTemplate): void {
    $this->checkTemplatePath($pageTemplate);
    $this->pageTemplate = $pageTemplate;
  }
  
  protected function setupTranslator(): void {
    if(is_null($this->translator)) {
      $loader = new MessagesCatalogue();
      $loader->folders = [__DIR__ . "/lang"];
      $this->translator = new Translator($loader);
    }
    if($this->lang !== "") {
      $this->translator->lang = $this->lang;
    }
    $this->template->setTranslator($this->translator);
  }
  
  /**
   * @throws \InvalidArgumentException
   */
  public function render(string $page = "index"): void {
    $this->template->presenterName = $this->presenterName;
    $this->template->folder = $this->folder;
    $this->setupTranslator();
    $pages = $this->getPages();
    if(!$pages->hasPage($page)) {
      $page = "index";
    }
    $this->template->setFile($this->indexTemplate);
    if($page !== "index") {
      $this->template->setFile($this->pageTemplate);
      $this->template->index = $pages->getIndex(["slug" => $page]);
      $this->template->current = $pages[$this->template->index];
    }
    $this->template->pages = $pages;
    $this->onRender($this, $page);
    $method = "render" . ucfirst($page);
    if(method_exists($this, $method)) {
      call_user_func([$this, $method]);
    }
    $this->template->render();
  }
}
?>