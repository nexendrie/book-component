<?php
namespace Nexendrie\BookComponent;

use Tester\Assert,
    Nexendrie\Translation\Translator,
    Nexendrie\Translation\Loaders\NeonLoader;

require __DIR__ . "/../../bootstrap.php";

class BookControl2 extends BookControl {
  function __construct() {
    parent::__construct("Test", __DIR__);
  }
  
  function getPages() {
    $storage = new BookPagesStorage;
    $storage[] = new BookPage("slug1", "title1");
    $storage[] = new BookPage("slug2", "title2");
    $storage[] = new BookPage("slug3", "title3");
    return $storage;
  }
  
  function renderSlug1() {
    $this->template->var = "Lorem Ipsum.";
  }
}

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
  
  function setUp() {
    $this->control = new BookControl2;
    $this->attachToPresenter($this->control);
  }
  
  function testTranslator() {
    $loader = new NeonLoader;
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
  
  function testRenderI() {
    Assert::type("null", $this->control->translator);
    $filename = __DIR__ . "/bookIndexExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
    Assert::type(Translator::class, $this->control->translator);
  }
  
  function testRenderP1() {
    $filename = __DIR__ . "/bookPageExpected1.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug1"]);
  }
  
  function testRenderP2() {
    $filename = __DIR__ . "/bookPageExpected2.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug2"]);
  }
  
  function testRenderP3() {
    $filename = __DIR__ . "/bookPageExpected3.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug3"]);
  }
}

$test = new BookControlTest;
$test->run();
?>