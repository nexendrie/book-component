<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use MyTester\Attributes\AfterTest;
use MyTester\Attributes\BeforeTest;
use MyTester\Attributes\BeforeTestSuite;
use MyTester\Attributes\Group;
use MyTester\Attributes\TestSuite;
use Nette\Security\User;
use TypeError;

#[TestSuite("ConditionUserInRole")]
#[Group("conditions")]
#[Group("security")]
final class ConditionUserInRoleTest extends \MyTester\TestCase
{
    use \MyTester\Bridges\NetteDI\TCompiledContainer;

    protected ConditionUserInRole $condition;

    #[BeforeTest]
    public function setUp(): void
    {
        $this->condition = $this->getService(ConditionUserInRole::class);
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
        $this->assertFalse($this->condition->isAllowed("abc"));
        /** @var User $user */
        $user = $this->getService(User::class);
        $user->login("test", "test");
        $this->assertTrue($this->condition->isAllowed("abc"));
    }
}
