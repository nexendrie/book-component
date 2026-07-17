<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\AfterTest;
use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\BeforeTestSuite;
use MyTester\Attributes\TestSuite;
use Nexendrie\Translation\Translator;

#[TestSuite("BookControl")]
final class BookControlTest extends \MyTester\TestCase
{
    use \MyTester\Bridges\NetteApplication\TComponent;
    use \MyTester\Bridges\NetteDI\TCompiledContainer;

    private BookControl $control;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->control = new BookControl2();
        $this->attachToPresenter($this->control);
    }

    #[AfterTest]
    #[BeforeTestSuite]
    public function rebuildContainer(): void
    {
        $this->refreshContainer();
    }

    public function testEmptyPages(): void
    {
        $control = new BookControl("Book", "book");
        /** @var BookPagesStorage $pages */
        $pages = $control->pages;
        $this->assertType(BookPagesStorage::class, $pages);
        $this->assertCount(0, $pages);
    }

    public function testInvalidPages(): void
    {
        $this->assertThrowsException(function () {
            $this->control->pages = function () {
                return [];
            };
            $this->control->render();
        }, \TypeError::class);
    }

    public function testTranslator(): void
    {
        /** @var Translator $translator */
        $translator = $this->getService(Translator::class);
        $this->assertSame("Content", $translator->translate("book.content"));
        $translator->lang = "cs";
        $this->assertSame("Obsah", $translator->translate("book.content"));
    }

    public function testCustomIndexTemplate(): void
    {
        $templateFile = __DIR__ . "/bookIndexCustom.latte";
        $this->control->indexTemplate = $templateFile;
        $this->assertSame($templateFile, $this->control->indexTemplate);
        $filename = __DIR__ . "/bookIndexCustomExpected.latte";
        $this->assertRenderOutputFile($this->control, $filename);
    }

    public function testCustomPageTemplate(): void
    {
        $templateFile = __DIR__ . "/bookPageCustom.latte";
        $this->control->pageTemplate = $templateFile;
        $this->assertSame($templateFile, $this->control->pageTemplate);
        $filename = __DIR__ . "/bookPageCustomExpected.latte";
        $this->assertRenderOutputFile($this->control, $filename, ["slug1"]);
    }

    public function testRenderI(): void
    {
        $filename = __DIR__ . "/bookIndexExpected.latte";
        $this->assertRenderOutputFile($this->control, $filename);
    }

    public function testRenderP1(): void
    {
        $filename = __DIR__ . "/bookPageExpected1.latte";
        $this->assertRenderOutputFile($this->control, $filename, ["slug1"]);
    }

    public function testRenderP2(): void
    {
        $filename = __DIR__ . "/bookPageExpected2.latte";
        $this->assertRenderOutputFile($this->control, $filename, ["slug2"]);
    }

    public function testRenderP3(): void
    {
        $filename = __DIR__ . "/bookPageExpected3.latte";
        $this->assertRenderOutputFile($this->control, $filename, ["slug3"]);
    }
}
