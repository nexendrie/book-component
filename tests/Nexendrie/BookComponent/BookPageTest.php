<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Tester\Assert;

require __DIR__ . "/../../bootstrap.php";

/**
 * BookPageTest
 *
 * @author Jakub Konečný
 * @testCase
 */
final class BookPageTest extends \Tester\TestCase
{
    private BookPage $page;

    protected function setUp(): void
    {
        $this->page = new BookPage("slug", "title");
    }

    public function testConditions(): void
    {
        Assert::true($this->page->allowed);
        $this->page->addCondition(new class () implements BookPageCondition {
            public function isAllowed($parameter = null): bool
            {
                return (bool) ($parameter);
            }
        }, false);
        Assert::false($this->page->allowed);
    }
}

$test = new BookPageTest();
$test->run();
