<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\BookComponent\Events\BookPageRendered;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * BookControl
 *
 * @author Jakub Konečný
 * @property callable|BookPagesStorage $pages
 * @property string $indexTemplate
 * @property string $pageTemplate
 * @property \Nette\Bridges\ApplicationLatte\DefaultTemplate $template
 * @method void onRender(BookControl $book, string $page)
 */
class BookControl extends \Nette\Application\UI\Control
{
    /** @var callable|BookPagesStorage */
    protected $pages;
    protected string $indexTemplate = __DIR__ . "/bookIndex.latte";
    protected string $pageTemplate = __DIR__ . "/bookPage.latte";
    /**
     * @var callable[]
     * @deprecated Use a PSR-14 event dispatcher
     */
    public array $onRender = [];

    public function __construct(
        private readonly string $presenterName,
        private readonly string $folder,
        private readonly ?EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->pages = new BookPagesStorage();
    }

    /**
     * @deprecated Access the property directly
     * @throws \InvalidArgumentException
     */
    public function getPages(): BookPagesStorage
    {
        if ($this->pages instanceof BookPagesStorage) {
            return $this->pages;
        }
        $pages = ($this->pages)();
        if (!$pages instanceof BookPagesStorage) {
            throw new \InvalidArgumentException(
                "Callback for pages for BookControl has to return " . BookPagesStorage::class . "."
            );
        }
        /** @var BookPagesStorage $pages */
        $pages = BookPagesStorage::fromArray($pages->getAllowedItems());
        return $pages;
    }

    /**
     * @deprecated Access the property directly
     */
    public function setPages(callable $pages): void
    {
        $this->pages = $pages;
    }

    /**
     * @deprecated
     * @throws \RuntimeException
     */
    protected function checkTemplatePath(string $path): void
    {
        if (!is_file($path)) {
            throw new \RuntimeException("File $path does not exist.");
        }
    }

    /**
     * @deprecated Access the property directly
     */
    public function getIndexTemplate(): string
    {
        return $this->indexTemplate;
    }

    /**
     * @deprecated Access the property directly
     */
    public function setIndexTemplate(string $indexTemplate): void
    {
        $this->checkTemplatePath($indexTemplate);
        $this->indexTemplate = $indexTemplate;
    }

    /**
     * @deprecated Access the property directly
     */
    public function getPageTemplate(): string
    {
        return $this->pageTemplate;
    }

    /**
     * @deprecated Access the property directly
     */
    public function setPageTemplate(string $pageTemplate): void
    {
        $this->checkTemplatePath($pageTemplate);
        $this->pageTemplate = $pageTemplate;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function render(string $page = "index"): void
    {
        $this->template->presenterName = $this->presenterName;
        $this->template->folder = $this->folder;
        $pages = $this->getPages(); // @phpstan-ignore method.deprecated
        if (!$pages->hasPage($page)) {
            $page = "index";
        }
        $this->template->setFile($this->indexTemplate);
        if ($page !== "index") {
            $this->template->setFile($this->pageTemplate);
            $this->template->index = $pages->getIndex(["slug" => $page]);
            $this->template->current = $pages[$this->template->index];
        }
        $this->template->pages = $pages;
        $this->eventDispatcher?->dispatch(new BookPageRendered($this, $page));
        $this->onRender($this, $page);
        $method = "render" . ucfirst($page);
        if (method_exists($this, $method)) {
            $this->$method();
        }
        $this->template->render();
    }
}
