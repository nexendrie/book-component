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
    /**
     * @param mixed $parameter
     */
    public function isAllowed($parameter = null): bool;
}
