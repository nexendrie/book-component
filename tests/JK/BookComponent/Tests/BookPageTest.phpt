<?php
namespace Nexendrie\BookComponent\Tests;

use Tester\Assert,
     Nexendrie\BookComponent\BookPage;

require __DIR__ . "/../../../bootstrap.php";

/**
 * BookPageTest
 *
 * @author Jakub Konečný
 * @testCase
 */
class BookPageTest extends \Tester\TestCase {
  /** @var  BookPage */
  private $page;
  
  function setUp() {
    $this->page = new BookPage("slug", "title");
  }
  
  function testSlug() {
    Assert::type("string", $this->page->slug);
    Assert::same("slug", $this->page->slug);
  }
  
  function testTitle() {
    Assert::type("string", $this->page->title);
    Assert::same("title", $this->page->title);
  }
}

$test = new BookPageTest;
$test->run();
?>