<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Security\User;
use TypeError;

/**
 * ConditionPermission
 *
 * @author Jakub Konečný
 */
final readonly class ConditionPermission implements BookPageCondition
{
    public function __construct(private User $user)
    {
    }

    /**
     * @param string $parameter
     * @throws TypeError
     * @throws \OutOfBoundsException
     */
    public function isAllowed(mixed $parameter = null): bool
    {
        if (!is_string($parameter)) {
            throw new TypeError("Method " . __METHOD__ . " expects string as parameter.");
        } elseif (!str_contains($parameter, ":")) {
            throw new \OutOfBoundsException(
                "Method " . __METHOD__ . " expects parameter in format resource:privilege."
            );
        }
        return $this->user->isAllowed(...explode(":", $parameter, 2));
    }
}
