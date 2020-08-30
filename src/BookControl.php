<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * BookControl
 *
 * @author Jakub Konečný
 * @property callable|BookPagesStorage $pages
 * @property string $indexTemplate
 * @property string $pageTemplate
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 * @method void onRender(BookControl $book, string $page)
 */
class BookControl extends \Nette\Application\UI\Control {
  /** @var callable|BookPagesStorage */
  protected $pages;
  private string $indexTemplate = __DIR__ . "/bookIndex.latte";
  private string $pageTemplate = __DIR__ . "/bookPage.latte";
  /** @var callable[] */
  public array $onRender = [];
  
  public function __construct(private readonly string $presenterName, private readonly string $folder) {
    $this->pages = new BookPagesStorage();
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

  /**
   * @internal
   */
  protected function getIndexTemplate(): string {
    return $this->indexTemplate;
  }

  /**
   * @internal
   */
  protected function setIndexTemplate(string $indexTemplate): void {
    $this->checkTemplatePath($indexTemplate);
    $this->indexTemplate = $indexTemplate;
  }

  /**
   * @internal
   */
  protected function getPageTemplate(): string {
    return $this->pageTemplate;
  }

  /**
   * @internal
   */
  protected function setPageTemplate(string $pageTemplate): void {
    $this->checkTemplatePath($pageTemplate);
    $this->pageTemplate = $pageTemplate;
  }
  
  /**
   * @throws \InvalidArgumentException
   */
  public function render(string $page = "index"): void {
    $this->template->presenterName = $this->presenterName;
    $this->template->folder = $this->folder;
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
      $this->$method();
    }
    $this->template->render();
  }
}
?>