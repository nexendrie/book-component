<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Tester\Assert,
    Nexendrie\Translation\Translator,
    Nexendrie\Translation\Loaders\MessagesCatalogue;

require __DIR__ . "/../../bootstrap.php";

/**
 * BookControlTest
 *
 * @author Jakub Konečný
 * @testCase
 */
class BookControlTest extends \Tester\TestCase {
  /** @var BookControl */
  private $control;
  
  use \Testbench\TComponent;
  
  protected function setUp() {
    $this->control = new BookControl2;
    $this->attachToPresenter($this->control);
  }
  
  public function testEmptyPages() {
    $control = new BookControl("Book", "book");
    Assert::type(BookPagesStorage::class, $control->pages);
    Assert::count(0, $control->pages);
  }
  
  /**
   * @throws \InvalidArgumentException
   */
  public function testInvalidPages() {
    $this->control->pages = function() {
      return [];
    };
    $this->control->render();
  }
  
  public function testLang() {
    $this->control->lang = "cs";
    Assert::same("cs", $this->control->lang);
  }
  
  public function testTranslator() {
    $loader = new MessagesCatalogue();
    $loader->folders = [__DIR__ . "/../../../src/lang"];
    $this->control->translator = new Translator($loader);
    Assert::same("en", $this->control->translator->lang);
    $result = $this->control->translator->translate("book.content");
    Assert::type("string", $result);
    Assert::same("Content", $result);
    $this->control->translator->lang = "cs";
    $result = $this->control->translator->translate("book.content");
    Assert::type("string", $result);
    Assert::same("Obsah", $result);
  }
  
  public function testRenderI() {
    Assert::type("null", $this->control->translator);
    $this->control->lang = "en";
    $filename = __DIR__ . "/bookIndexExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
    Assert::type(Translator::class, $this->control->translator);
  }
  
  public function testRenderP1() {
    $filename = __DIR__ . "/bookPageExpected1.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug1"]);
  }
  
  public function testRenderP2() {
    $filename = __DIR__ . "/bookPageExpected2.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug2"]);
  }
  
  public function testRenderP3() {
    $filename = __DIR__ . "/bookPageExpected3.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug3"]);
  }
}

$test = new BookControlTest;
$test->run();
?>