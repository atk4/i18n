<?php
/**
 * Create translatable message
 * that can be translate later.
 */

declare(strict_types=1);

namespace Atk4\I18n;

class T
{
    /** @var string */
    private $msgId;

    /** @var array */
    private $args;

    /** @var string */
    private $domain;

    private function __construct(string $msgId, array $args = [], string $domain = 'messages')
    {
        $this->msgId = $msgId;
        $this->args = $args;
        $this->domain = $domain;
    }

    public static function from(string $message, array $args = [], string $domain = 'messages'): self
    {
        return new static ($message, $args, $domain);
    }

    /**
     * Translate message in specified locale.
     */
    public function in(string $locale): string
    {
        return Service::getTranslator()->trans($this->msgId, $this->args, $this->domain, $locale);
    }

    /**
     * Translate message in Translator locale.
     */
    public function t(): string
    {
        return Service::getTranslator()->trans($this->msgId, $this->args, $this->domain);
    }
}
