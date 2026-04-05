<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\AfterTest;
use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\BeforeTestSuite;
use MyTester\Attributes\Group;
use MyTester\Attributes\TestSuite;
use TypeError;

#[TestSuite("ConditionPermission")]
#[Group("conditions")]
#[Group("security")]
final class ConditionPermissionTest extends \MyTester\TestCase
{
    use \MyTester\Bridges\NetteDI\TCompiledContainer;

    protected ConditionPermission $condition;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->condition = $this->getService(ConditionPermission::class);
    }

    #[AfterTest]
    #[BeforeTestSuite]
    public function rebuildContainer(): void
    {
        $this->refreshContainer();
    }

    public function testIsAllowed(): void
    {
        $this->assertThrowsException(function () {
            $this->condition->isAllowed();
        }, TypeError::class);
        $this->assertThrowsException(function () {
            $this->condition->isAllowed("test");
        }, \OutOfBoundsException::class);
        $this->assertTrue($this->condition->isAllowed("resource:privilege"));
        $this->assertFalse($this->condition->isAllowed("resource:privilege2"));
    }
}
