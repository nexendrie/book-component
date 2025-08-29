<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nexendrie\Utils\Collection;

/**
 * @author Jakub Konečný
 */
final class BookPagesStorage extends Collection
{
    protected string $class = BookPage::class;
    protected ?string $uniqueProperty = "slug";

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
