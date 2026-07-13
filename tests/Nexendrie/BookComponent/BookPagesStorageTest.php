<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\TestSuite;

#[TestSuite("BookPagesStorage")]
final class BookPagesStorageTest extends \MyTester\TestCase
{
    private BookPagesStorage $storage;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->storage = new BookPagesStorage();
        $this->storage[] = new BookPage("slug1", "title1");
        $this->storage[] = new BookPage("slug2", "title2");
    }

    public function testInvalidArgument(): void
    {
        $this->assertThrowsException(function () {
            $this->storage[] = new \stdClass(); // @phpstan-ignore offsetAssign.valueType
        }, \InvalidArgumentException::class);
    }

    public function testDuplicateSlug(): void
    {
        $this->assertThrowsException(function () {
            $this->storage[] = new BookPage("slug2", "title2");
        }, \RuntimeException::class);
    }

    public function testHasPage(): void
    {
        $this->assertTrue($this->storage->hasPage("slug1"));
        $this->assertTrue($this->storage->hasPage("slug2"));
        $this->assertFalse($this->storage->hasPage("slug3"));
    }
}
