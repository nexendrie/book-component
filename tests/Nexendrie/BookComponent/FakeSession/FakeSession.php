<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent\FakeSession;

use Nette\Http\SameSite;
use Nette\Http\Session;
use Nette\Http\SessionSection;

/**
 * @internal
 */
final class FakeSession extends Session
{
    /**
     * @var SessionSection[]
     */
    private array $sections = [];

    public bool $fakeMode = true;

    // @phpstan-ignore constructor.missingParentCall
    public function __construct(private readonly Session $originalSession)
    {
    }

    public function start(): void
    {
        if (!$this->fakeMode) {
            $this->originalSession->start();
        }
    }

    public function isStarted(): bool
    {
        return !$this->fakeMode && $this->originalSession->isStarted();
    }

    public function close(): void
    {
        if (!$this->fakeMode) {
            $this->originalSession->close();
        }
    }

    public function destroy(): void
    {
        if (!$this->fakeMode) {
            $this->originalSession->destroy();
        }
    }

    public function exists(): bool
    {
        return !$this->fakeMode && $this->originalSession->exists();
    }

    public function regenerateId(): void
    {
        if (!$this->fakeMode) {
            $this->originalSession->regenerateId();
        }
    }

    public function getId(): string
    {
        return $this->fakeMode ? '' : $this->originalSession->getId();
    }

    public function getSection(string $section, string $class = SessionSection::class): SessionSection
    {
        if (!$this->fakeMode) {
            return $this->originalSession->getSection($section, $class);
        }

        if (isset($this->sections[$section])) {
            return $this->sections[$section]; // @phpstan-ignore return.type
        }

        $this->sections[$section] = parent::getSection(
            $section,
            $class === SessionSection::class ? FakeSessionSection::class : $class
        );
        return $this->sections[$section];
    }

    public function hasSection(string $section): bool
    {
        if (!$this->fakeMode) {
            return $this->originalSession->hasSection($section);
        }
        return isset($this->sections[$section]);
    }

    public function setExpiration(?string $expire): static
    {
        $this->setExpiration($expire);
        return $this;
    }

    public function setCookieParameters(
        string $path,
        ?string $domain = null,
        ?bool $secure = null,
        string|null|SameSite $sameSite = null
    ): static {
        $this->originalSession->setCookieParameters($path, $domain, $secure, $sameSite);
        return $this;
    }

    public function setSavePath(string $path): static
    {
        $this->originalSession->setSavePath($path);
        return $this;
    }

    public function setHandler(\SessionHandlerInterface $handler): static
    {
        $this->originalSession->setHandler($handler);
        return $this;
    }
}
