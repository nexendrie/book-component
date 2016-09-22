<?php
namespace JK\BookComponent\Tests;

use Tester\Assert,
    JK\BookComponent\BookPagesStorage,
    JK\BookComponent\BookPage;

require __DIR__ . "/../../../bootstrap.php";

/**
 * BookPagesStorageTest
 *
 * @author Jakub Konečný
 * @testCase
 */
class BookPagesStorageTest extends \Tester\TestCase {
  /** @var BookPagesStorage */
  private $storage;
  
  function setUp() {
    $this->storage = new BookPagesStorage;
    $this->storage[] = new BookPage("slug1", "title1");
    $this->storage[] = new BookPage("slug2", "title2");
  }
  
  /**
   * @throws \InvalidArgumentException
   */
  function testInvalidArgument() {
    $this->storage[] = new \stdClass;
  }
  
  /**
   * @throws \RuntimeException
   */
  function testDuplicateSlug() {
    $this->storage[] = new BookPage("slug2", "title2");
  }
  
  function testHasPage() {
    Assert::true($this->storage->hasPage("slug1"));
    Assert::true($this->storage->hasPage("slug2"));
    Assert::false($this->storage->hasPage("slug3"));
  }
  
  function testGetIndex() {
    Assert::same(0, $this->storage->getIndex("slug1"));
    Assert::same(1, $this->storage->getIndex("slug2"));
    Assert::same(NULL, $this->storage->getIndex("slug3"));
  }
}

$test = new BookPagesStorageTest;
$test->run();
?>