<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent\FakeSession;

use Nette\DI\CompilerExtension;
use Nette\Http\Session;

final class FakeSessionExtension extends CompilerExtension
{
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();
        $originalSessionName = $builder->getByType(Session::class);
        if (is_string($originalSessionName)) {
            $originalSession = $builder->getDefinition($originalSessionName);
            $builder->removeDefinition($originalSessionName);
            $builder->addDefinition($this->prefix("originalSession"), clone $originalSession)
                ->setAutowired(false);
            $builder->addDefinition($originalSessionName)
                ->setType(Session::class)
                ->setFactory(FakeSession::class, [$this->prefix("@originalSession"),]);
        }
    }
}
