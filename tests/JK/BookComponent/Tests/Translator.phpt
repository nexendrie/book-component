<?php
namespace JK\BookComponent\Tests;

use Tester\Assert;

require __DIR__ . "/../../../bootstrap.php";

/**
 * TranslatorTest
 *
 * @author Jakub Konečný
 * @testCase
 */
class TranslatorTest extends \Tester\TestCase {
  private $translator;
  
  function setUp() {
    $this->translator = new \JK\BookComponent\Translator;
  }
  
  function testTranslateEn() {
    Assert::same("en", $this->translator->lang);
    // invalid pattern
    Assert::type("string", $this->translator->translate("abc"));
    Assert::same("", $this->translator->translate("abc"));
    // non-existing string
    Assert::type("string", $this->translator->translate("book.abc"));
    Assert::same("", $this->translator->translate("book.abc"));
    // existing string
    Assert::type("string", $this->translator->translate("book.content"));
    Assert::same("Content", $this->translator->translate("book.content"));
    // string existing only in default translation
    Assert::type("string", $this->translator->translate("book.test"));
    Assert::same("Test", $this->translator->translate("book.test"));
  }
  
  function testTranslateCs() {
    $this->translator->lang = "cs";
    Assert::same("cs", $this->translator->lang);
    // invalid pattern
    Assert::type("string", $this->translator->translate("abc"));
    Assert::same("", $this->translator->translate("abc"));
    // non-existing string
    Assert::type("string", $this->translator->translate("book.abc"));
    Assert::same("", $this->translator->translate("book.abc"));
    // existing string
    Assert::type("string", $this->translator->translate("book.content"));
    Assert::same("Obsah", $this->translator->translate("book.content"));
    // string existing only in default translation
    Assert::type("string", $this->translator->translate("book.test"));
    Assert::same("Test", $this->translator->translate("book.test"));
  }
  
  /**
   * Test non-existing language
   */
  function testTranslateX() {
    $this->translator->lang = "x";
    Assert::same("x", $this->translator->lang);
    // invalid pattern
    Assert::type("string", $this->translator->translate("abc"));
    Assert::same("", $this->translator->translate("abc"));
    // non-existing string
    Assert::type("string", $this->translator->translate("book.abc"));
    Assert::same("", $this->translator->translate("book.abc"));
    // existing string
    Assert::type("string", $this->translator->translate("book.content"));
    Assert::same("Content", $this->translator->translate("book.content"));
    // string existing only in default translation
    Assert::type("string", $this->translator->translate("book.test"));
    Assert::same("Test", $this->translator->translate("book.test"));
  }
}

$test = new TranslatorTest;
$test->run();
?>