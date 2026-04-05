<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * @author Jakub Konečný
 * @property-read bool $allowed
 */
class BookPage
{
    use \Nette\SmartObject;

    /** @var array<int, array{0: BookPageCondition, 1: mixed}> */
    protected array $conditions = [];

    public function __construct(public string $slug, public string $title)
    {
    }

    public function addCondition(BookPageCondition $condition, mixed $parameter): void
    {
        $this->conditions[] = [$condition, $parameter];
    }

    /**
     * @internal
     */
    protected function isAllowed(): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition[0]->isAllowed($condition[1])) {
                return false;
            }
        }
        return true;
    }
}
