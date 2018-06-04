<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

/**
 * IBookPageCondition
 *
 * @author Jakub Konečný
 */
interface IBookPageCondition {
  public function isAllowed($parameter = NULL): bool;
}
?>