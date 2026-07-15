<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\TestSuite;

#[TestSuite("BookPage")]
final class BookPageTest extends \MyTester\TestCase
{
    private BookPage $page;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->page = new BookPage("slug", "title");
    }

    public function testConditions(): void
    {
        $this->assertTrue($this->page->allowed);
        $this->page->addCondition(new class () implements BookPageCondition {
            public function isAllowed(mixed $parameter = null): bool
            {
                return (bool) ($parameter);
            }
        }, false);
        $this->assertFalse($this->page->allowed);
    }
}
