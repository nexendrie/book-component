<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Security\User;
use TypeError;

/**
 * ConditionUserInRole
 *
 * @author Jakub Konečný
 */
final readonly class ConditionUserInRole implements BookPageCondition
{
    public function __construct(private User $user)
    {
    }

    /**
     * @param string $parameter Role
     * @throws TypeError
     */
    public function isAllowed(mixed $parameter = null): bool
    {
        if (!is_string($parameter)) {
            throw new TypeError("Method " . __METHOD__ . " expects string as parameter.");
        }
        return $this->user->isInRole($parameter);
    }
}
