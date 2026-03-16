<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * BookPagesStorageTest
 *
 * @author Jakub Konečný
 * @testCase
 */
final class BookPagesStorageTest extends \Tester\TestCase
{
    private BookPagesStorage $storage;

    protected function setUp(): void
    {
        $this->storage = new BookPagesStorage();
        $this->storage[] = new BookPage("slug1", "title1");
        $this->storage[] = new BookPage("slug2", "title2");
    }

    public function testInvalidArgument(): void
    {
        Assert::exception(function () {
            $this->storage[] = new \stdClass();
        }, \InvalidArgumentException::class);
    }

    public function testDuplicateSlug(): void
    {
        Assert::exception(function () {
            $this->storage[] = new BookPage("slug2", "title2");
        }, \RuntimeException::class);
    }

    public function testHasPage(): void
    {
        Assert::true($this->storage->hasPage("slug1"));
        Assert::true($this->storage->hasPage("slug2"));
        Assert::false($this->storage->hasPage("slug3"));
    }
}

$test = new BookPagesStorageTest();
$test->run();
