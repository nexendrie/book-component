<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\Utils\Collection;

/**
 * @author Jakub Konečný
 * @extends Collection<BookPage>
 * @property-read list<BookPage> $allowedItems
 */
final class BookPagesStorage extends Collection
{
    use \Nette\SmartObject;

    public function __construct()
    {
        parent::__construct();
        $this->class = BookPage::class;
        $this->uniqueProperty = "slug";
    }

    public function hasPage(string $slug): bool
    {
        return $this->hasItems(["slug" => $slug, "allowed" => true]);
    }

    /**
     * @return list<BookPage>
     */
    protected function getAllowedItems(): array
    {
        return $this->getItems(["allowed" => true]);
    }
}
