<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Security\User;

/**
 * ConditionPermission
 *
 * @author Jakub Konečný
 */
final class ConditionPermission implements BookPageCondition
{
    public function __construct(private readonly User $user)
    {
    }

    /**
     * @param string $parameter
     * @throws \InvalidArgumentException
     * @throws \OutOfBoundsException
     */
    public function isAllowed($parameter = null): bool
    {
        if (!is_string($parameter)) {
            throw new \InvalidArgumentException("Method " . __METHOD__ . " expects string as parameter.");
        } elseif (!str_contains($parameter, ":")) {
            throw new \OutOfBoundsException(
                "Method " . __METHOD__ . " expects parameter in format resource:privilege."
            );
        }
        return $this->user->isAllowed(...explode(":", $parameter, 2));
    }
}
