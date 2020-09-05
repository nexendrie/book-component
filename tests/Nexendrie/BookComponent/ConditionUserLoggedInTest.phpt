<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * @author Jakub Konečný
 * @testCase
 */
final class ConditionUserLoggedInTest extends \Tester\TestCase {
  use \Testbench\TCompiledContainer;

  protected ConditionUserLoggedIn $condition;
  
  public function setUp() {
    $this->condition = $this->getService(ConditionUserLoggedIn::class);
  }
  
  public function testIsAllowed() {
    Assert::true($this->condition->isAllowed());
    Assert::exception(function() {
      $this->condition->isAllowed("yes");
    }, \InvalidArgumentException::class);
    Assert::false($this->condition->isAllowed(true));
    Assert::true($this->condition->isAllowed(false));
  }
}

$test = new ConditionUserLoggedInTest();
$test->run();
?>