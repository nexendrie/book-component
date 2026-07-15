<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Security\User;
use TypeError;

/**
 * ConditionUserLoggedIn
 *
 * @author Jakub Konečný
 */
final readonly class ConditionUserLoggedIn implements BookPageCondition
{
    public function __construct(private User $user)
    {
    }

    /**
     * @param bool|null $parameter
     * @throws TypeError
     */
    public function isAllowed(mixed $parameter = null): bool
    {
        if ($parameter === null) {
            return true;
        } elseif (!is_bool($parameter)) {
            throw new TypeError("Method " . __METHOD__ . " expects boolean as parameter.");
        }
        return ($parameter === $this->user->isLoggedIn());
    }
}
