<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\BookComponent\Events\BookPageRendered;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * BookControl
 *
 * @author Jakub Konečný
 * @property \Nette\Bridges\ApplicationLatte\DefaultTemplate $template
 */
class BookControl extends \Nette\Application\UI\Control
{
    public \Closure|BookPagesStorage $pages;
    public string $indexTemplate = __DIR__ . "/bookIndex.latte";
    public string $pageTemplate = __DIR__ . "/bookPage.latte";

    public function __construct(
        private readonly string $presenterName,
        private readonly string $folder,
        private readonly ?EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->pages = new BookPagesStorage();
    }

    /**
     * @internal
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
        return BookPagesStorage::fromArray($pages->getAllowedItems());
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function render(string $page = "index"): void
    {
        $this->template->presenterName = $this->presenterName;
        $this->template->folder = $this->folder;
        $pages = $this->getPages();
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
        $method = "render" . ucfirst($page);
        if (method_exists($this, $method)) {
            $this->$method();
        }
        $this->template->render();
    }
}
