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

    /**
     * @throws \InvalidArgumentException
     */
    public function testInvalidArgument(): void
    {
        $this->storage[] = new \stdClass();
    }

    /**
     * @throws \RuntimeException
     */
    public function testDuplicateSlug(): void
    {
        $this->storage[] = new BookPage("slug2", "title2");
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
