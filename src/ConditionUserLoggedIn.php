<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Nette\Security\User;

/**
 * ConditionUserLoggedIn
 *
 * @author Jakub Konečný
 */
final class ConditionUserLoggedIn implements IBookPageCondition {
  /** @var User */
  protected $user;
  
  public function __construct(User $user) {
    $this->user = $user;
  }
  
  /**
   * @param bool|null $parameter
   * @throws \InvalidArgumentException
   */
  public function isAllowed($parameter = null): bool {
    if($parameter === null) {
      return true;
    } elseif(!is_bool($parameter)) {
      throw new \InvalidArgumentException("Method " . __METHOD__ . " expects boolean as parameter.");
    }
    return ($parameter === $this->user->isLoggedIn());
  }
}
?>