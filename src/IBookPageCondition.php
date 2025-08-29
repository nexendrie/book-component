<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

if (false) { // @phpstan-ignore if.alwaysFalse
    /** @deprecated Use BookPageCondition */
    interface IBookPageCondition extends BookPageCondition
    {
    }

} elseif (!interface_exists(IBookPageCondition::class)) {
    class_alias(BookPageCondition::class, IBookPageCondition::class);
}
