<?php
namespace JK\BookComponent\Tests;

use JK\BookComponent as Book,
    Nette\ComponentModel\IComponent,
    JK\BookComponent\Translator,
    Tester\Assert;

require __DIR__ . "/../../../bootstrap.php";

class BookControl extends Book\BookControl {
  function __construct() {
    parent::__construct("Test", __DIR__);
  }
  
  function getPages() {
    $storage = new Book\BookPagesStorage;
    $storage[] = new Book\BookPage("slug1", "title1");
    $storage[] = new Book\BookPage("slug2", "title2");
    $storage[] = new Book\BookPage("slug3", "title3");
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
  private $control;
  
  use \Testbench\TComponent;
  
  protected function checkRenderOutput(IComponent $control, $expected, $page = "index") {
    if(!$control->getParent()) {
      $this->attachToPresenter($control);
    }
    ob_start();
    $control->render($page);
    if(is_file($expected)) {
      \Tester\Assert::matchFile($expected, ob_get_clean());
    } else {
      \Tester\Assert::match($expected, ob_get_clean());
    }
  }
  
  function setUp() {
    $this->control = new BookControl;
    $this->attachToPresenter($this->control);
  }
  
  function testTranslator() {
    $this->control->translator = new Translator;
    Assert::same("en", $this->control->translator->lang);
    Assert::type("string", $this->control->translator->translate("book.content"));
    Assert::same("Content", $this->control->translator->translate("book.content"));
    $this->control->translator->lang = "cs";
    Assert::type("string", $this->control->translator->translate("book.content"));
    Assert::same("Obsah", $this->control->translator->translate("book.content"));
  }
  
  function testRenderI() {
    Assert::type("null", $this->control->translator);
    $this->checkRenderOutput($this->control, __DIR__ . "/bookIndexExpected.latte");
    Assert::type(Translator::class, $this->control->translator);
  }
  
  function testRenderP1() {
    $this->checkRenderOutput($this->control, __DIR__ . "/bookPageExpected1.latte", "slug1");
  }
  
  function testRenderP2() {
    $this->checkRenderOutput($this->control, __DIR__ . "/bookPageExpected2.latte", "slug2");
  }
  
  function testRenderP3() {
    $this->checkRenderOutput($this->control, __DIR__ . "/bookPageExpected3.latte", "slug3");
  }
}

$test = new BookControlTest;
$test->run();
?>