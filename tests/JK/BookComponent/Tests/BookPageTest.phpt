<?php
namespace JK\BookComponent\Tests;

use Tester\Assert;

require __DIR__ . "/../../../bootstrap.php";

/**
 * BookPageTest
 *
 * @author Jakub Konečný
 * @testCase
 */
class BookPageTest extends \Tester\TestCase {
  private $page;
  
  function setUp() {
    $this->page = new \JK\BookComponent\BookPage("slug", "title");
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