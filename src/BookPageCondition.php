<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * BookPageCondition
 *
 * @author Jakub Konečný
 */
interface BookPageCondition
{
    public function isAllowed(mixed $parameter = null): bool;
}
