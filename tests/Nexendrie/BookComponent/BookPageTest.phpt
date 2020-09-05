<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * BookPageTest
 *
 * @author Jakub Konečný
 * @testCase
 */
final class BookPageTest extends \Tester\TestCase {
  private BookPage $page;
  
  protected function setUp() {
    $this->page = new BookPage("slug", "title");
  }
  
  public function testConditions() {
    Assert::true($this->page->allowed);
    $this->page->addCondition(new class() implements IBookPageCondition {
      public function isAllowed($param = null): bool {
        return (bool) ($param);
      }
    }, false);
    Assert::false($this->page->allowed);
  }
}

$test = new BookPageTest();
$test->run();
?>