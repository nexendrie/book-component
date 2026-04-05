<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\AfterTest;
use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\BeforeTestSuite;
use MyTester\Attributes\Group;
use MyTester\Attributes\TestSuite;
use TypeError;

#[TestSuite("ConditionUserLoggedIn")]
#[Group("conditions")]
#[Group("security")]
final class ConditionUserLoggedInTest extends \MyTester\TestCase
{
    use \MyTester\Bridges\NetteDI\TCompiledContainer;

    protected ConditionUserLoggedIn $condition;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->condition = $this->getService(ConditionUserLoggedIn::class);
    }

    #[AfterTest]
    #[BeforeTestSuite]
    public function rebuildContainer(): void
    {
        $this->refreshContainer();
    }

    public function testIsAllowed(): void
    {
        $this->assertTrue($this->condition->isAllowed());
        $this->assertThrowsException(function () {
            $this->condition->isAllowed("yes"); // @phpstan-ignore argument.type
        }, TypeError::class);
        $this->assertFalse($this->condition->isAllowed(true));
        $this->assertTrue($this->condition->isAllowed(false));
    }
}
