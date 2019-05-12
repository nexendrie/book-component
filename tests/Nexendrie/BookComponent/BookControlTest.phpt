<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Tester\Assert;
use Nexendrie\Translation\Translator;

require __DIR__ . "/../../bootstrap.php";

/**
 * BookControlTest
 *
 * @author Jakub Konečný
 * @testCase
 */
final class BookControlTest extends \Tester\TestCase {
  /** @var BookControl */
  private $control;
  
  use \Testbench\TComponent;
  use \Testbench\TCompiledContainer;
  
  protected function setUp() {
    $this->control = new BookControl2();
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
  
  public function testTranslator() {
    /** @var Translator $translator */
    $translator = $this->getService(Translator::class);
    Assert::same("Content", $translator->translate("book.content"));
    $translator->lang = "cs";
    Assert::same("Obsah", $translator->translate("book.content"));
  }

  public function testInvalidCustomTemplates() {
    Assert::exception(function() {
      $this->control->indexTemplate = "abc.latte";
    }, \RuntimeException::class);
    Assert::exception(function() {
      $this->control->pageTemplate = "abc.latte";
    }, \RuntimeException::class);
  }
  
  public function testCustomIndexTemplate() {
    $templateFile = __DIR__ . "/bookIndexCustom.latte";
    $this->control->indexTemplate = $templateFile;
    Assert::same($templateFile, $this->control->indexTemplate);
    $filename = __DIR__ . "/bookIndexCustomExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
  }
  
  public function testCustomPageTemplate() {
    $templateFile = __DIR__ . "/bookPageCustom.latte";
    $this->control->pageTemplate = $templateFile;
    Assert::same($templateFile, $this->control->pageTemplate);
    $filename = __DIR__ . "/bookPageCustomExpected.latte";
    $this->checkRenderOutput($this->control, $filename, ["slug1"]);
  }
  
  public function testRenderI() {
    $filename = __DIR__ . "/bookIndexExpected.latte";
    $this->checkRenderOutput($this->control, $filename);
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

$test = new BookControlTest();
$test->run();
?>