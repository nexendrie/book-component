<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * IBookPageCondition
 *
 * @author Jakub Konečný
 */
interface IBookPageCondition {
  /**
   * @param mixed $parameter
   */
  public function isAllowed($parameter = null): bool;
}
?>