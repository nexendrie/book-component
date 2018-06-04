<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Security\User;

/**
 * ConditionUserInRole
 *
 * @author Jakub Konečný
 */
final class ConditionUserInRole implements IBookPageCondition {
  /** @var User */
  protected $user;
  
  public function __construct(User $user) {
    $this->user = $user;
  }
  
  /**
   * @param string $parameter Role
   * @throws \InvalidArgumentException
   */
  public function isAllowed($parameter = null): bool {
    if(!is_string($parameter)) {
      throw new \InvalidArgumentException("Method " . __METHOD__ . " expects string as parameter.");
    }
    return $this->user->isInRole($parameter);
  }
}
?>