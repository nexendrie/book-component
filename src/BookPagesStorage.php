<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\Utils\Collection;

/**
 * @author Jakub Konečný
 */
final class BookPagesStorage extends Collection
{
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
     * @return BookPage[]
     */
    public function getAllowedItems(): array
    {
        return $this->getItems(["allowed" => true]);
    }
}
