<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent\Events;

use Nexendrie\BookComponent\BookControl;

final readonly class BookPageRendered
{
    public function __construct(public BookControl $book, public string $page)
    {
    }
}
