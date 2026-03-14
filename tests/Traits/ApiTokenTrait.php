<?php

namespace Tests\Traits;

trait ApiTokenTrait
{
    protected function getApiToken(): string
    {
        return '2|VoU41upsBddLLFYQJqLS4B0tbPbO7oRcbK288t842b86818e';
    }

    protected function withApiTokenHeaders(array $additionalHeaders = []): array
    {
        return array_merge($additionalHeaders, [
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ]);
    }
}
//tests/Traits/ApiTokenTrait.php