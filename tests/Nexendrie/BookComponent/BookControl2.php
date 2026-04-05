<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent;

use Konecnyjakub\EventDispatcher\AutoListenerProvider;
use Konecnyjakub\EventDispatcher\EventDispatcher;
use Nexendrie\BookComponent\Events\BookPageRendered;

final class BookControl2 extends BookControl
{
    public function __construct()
    {
        $listenerProvider = new AutoListenerProvider();
        $listenerProvider->addListener(static function (BookPageRendered $event): void {
            if ($event->page === "slug1") {
                $event->book->template->var2 = "Dota.";
            }
        });
        $eventDispatcher = new EventDispatcher($listenerProvider);
        parent::__construct("Test", __DIR__, $eventDispatcher);
        $this->pages = function (): BookPagesStorage {
            $storage = new BookPagesStorage();
            $storage[] = new BookPage("slug1", "title1");
            $storage[] = new BookPage("slug2", "title2");
            $storage[] = new BookPage("slug3", "title3");
            $conditionalPage = new BookPage("slug4", "title4");
            $conditionalPage->addCondition(new class () implements BookPageCondition {
                /**
                 * @param mixed $parameter
                 */
                public function isAllowed($parameter = null): bool
                {
                    return false;
                }
            }, null);
            $storage[] = $conditionalPage;
            return $storage;
        };
    }

    public function renderSlug1(): void
    {
        $this->template->var1 = "Lorem Ipsum.";
    }
}
