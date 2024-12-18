<?php

namespace FikriMastor\AuditLogin;

use FikriMastor\AuditLogin\Enums\EventTypeEnum;
use Illuminate\Http\Request;

class AuditLoginAttribute
{
    protected Request $request;

    public ?EventTypeEnum $eventType;

    public string $currentUrl;

    public string $ipAddress;

    public string $userAgent;

    public array $metadata = [];

    public function __construct(Request $request, ?EventTypeEnum $eventType = null)
    {
        $this->request = $request;
        $this->eventType = $eventType;
        $this->currentUrl = $request->fullUrl();
        $this->ipAddress = $request->ip();
        $this->userAgent = $request->userAgent();
    }

    public function toArray(): array
    {
        return [
            'event' => $this->eventType?->value,
            'url' => $this->currentUrl,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'metadata' => $this->metadata,
        ];
    }

    public function eventType(EventTypeEnum $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }
}
