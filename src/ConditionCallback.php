<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use TypeError;

/**
 * ConditionCallback
 *
 * @author Jakub Konečný
 */
final readonly class ConditionCallback implements BookPageCondition
{
    /**
     * @param callable $parameter
     * @throws TypeError
     */
    public function isAllowed(mixed $parameter = null): bool
    {
        if (!is_callable($parameter)) {
            throw new TypeError("Method " . __METHOD__ . " expects callback as parameter.");
        }
        $result = $parameter();
        if (!is_bool($result)) {
            throw new \TypeError(
                "The callback for method " . __METHOD__ . " has to return boolean, " . gettype($result) . " returned."
            );
        }
        return $result;
    }
}
