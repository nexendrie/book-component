<?php
namespace Nexendrie\BookComponent;

use Nette\ComponentModel\IComponent,
    Tester\Assert,
    Nexendrie\Translation\Translator;

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
  
  /**
   * @param IComponent $control
   * @param $expected
   * @param string $page
   * @return void
   */
  protected function checkRenderOutput(IComponent $control, $expected, $page = "index") {
    /** @var BookControl $control */
    if(!$control->getParent()) {
      $this->attachToPresenter($control);
    }
    ob_start();
    $control->render($page);
    if(is_file($expected)) {
      Assert::matchFile($expected, ob_get_clean());
    } else {
      Assert::match($expected, ob_get_clean());
    }
  }
  
  function setUp() {
    $this->control = new BookControl2;
    $this->attachToPresenter($this->control);
  }
  
  function testTranslator() {
    $this->control->translator = new Translator;
    $this->control->translator->folders = [__DIR__ . "/../../../src/lang"];
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
    $this->checkRenderOutput($this->control, $filename, "slug1");
  }
  
  function testRenderP2() {
    $filename = __DIR__ . "/bookPageExpected2.latte";
    $this->checkRenderOutput($this->control, $filename, "slug2");
  }
  
  function testRenderP3() {
    $filename = __DIR__ . "/bookPageExpected3.latte";
    $this->checkRenderOutput($this->control, $filename, "slug3");
  }
}

$test = new BookControlTest;
$test->run();
?>