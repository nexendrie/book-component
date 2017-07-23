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
class BookPageTest extends \Tester\TestCase {
  /** @var BookPage */
  private $page;
  
  protected function setUp() {
    $this->page = new BookPage("slug", "title");
  }
  
  public function testSlug() {
    Assert::type("string", $this->page->slug);
    Assert::same("slug", $this->page->slug);
  }
  
  public function testTitle() {
    Assert::type("string", $this->page->title);
    Assert::same("title", $this->page->title);
  }
}

$test = new BookPageTest;
$test->run();
?>