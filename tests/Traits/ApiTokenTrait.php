<?php

namespace Tests\Traits;

use App\Models\Personnel;

trait ApiTokenTrait
{
    protected ?Personnel $authPersonnel = null;

    protected function getApiToken(): string
    {
        if (!$this->authPersonnel) {
            $this->authPersonnel = Personnel::factory()->create();
        }
        return $this->authPersonnel->createToken('test-token')->plainTextToken;
    }

    protected function withApiTokenHeaders(array $additionalHeaders = []): array
    {
        return array_merge($additionalHeaders, [
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ]);
    }
}
