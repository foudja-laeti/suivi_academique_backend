<?php

namespace Tests\Traits;

use App\Models\Personnel;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait ApiTokenTrait
{
    protected function getApiToken(): string
    {
        $personnel = Personnel::factory()->create();
        $token = $personnel->createToken('test-token')->plainTextToken;
        return $token;
    }

    protected function withApiTokenHeaders(array $additionalHeaders = []): array
    {
        return array_merge($additionalHeaders, [
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ]);
    }
}
