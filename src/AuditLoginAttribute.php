<?php

namespace FikriMastor\AuditLogin;

use Illuminate\Http\Request;

class AuditLoginAttribute
{
    protected Request $request;
    public string $currentUrl;
    public string $ipAddress;
    public string $userAgent;
    public array $metadata = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->currentUrl = $this->request->fullUrl();
        $this->ipAddress = $this->request->ip();
        $this->userAgent = $this->request->userAgent();
    }

    public function toArray(): array
    {
        return [
            'url' => $this->currentUrl,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'metadata' => $this->metadata
        ];
    }
}