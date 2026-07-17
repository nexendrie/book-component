<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\Group;
use MyTester\Attributes\TestSuite;
use TypeError;

#[TestSuite("ConditionCallback")]
#[Group("conditions")]
final class ConditionCallbackTest extends \MyTester\TestCase
{
    use \MyTester\Bridges\NetteDI\TCompiledContainer;

    protected ConditionCallback $condition;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->condition = $this->getService(ConditionCallback::class);
    }

    public function testIsAllowed(): void
    {
        $this->assertThrowsException(function () {
            $this->condition->isAllowed(null);
        }, TypeError::class);
        $this->assertThrowsException(function () {
            $this->condition->isAllowed(function () {
                return null;
            });
        }, TypeError::class);
        $this->assertTrue($this->condition->isAllowed(function () {
            return true;
        }));
        $this->assertFalse($this->condition->isAllowed(function () {
            return false;
        }));
    }
}
