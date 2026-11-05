<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/** Reusable operating-policy creation, lookup, and immutable versioning operations. */
final class OperatingPolicies
{
    /** Creates the operating-policies resource client. */
    public function __construct(private HttpClient $http)
    {
    }

    /** Creates the first version of an operating policy. */
    public function create(array $payload): \Inttegro\OperatingPolicy\OperatingPolicy
    {
        return $this->http->postResource(
            '/operating_policies/create',
            \Inttegro\OperatingPolicy\OperatingPolicy::class,
            'operating_policy',
            $payload,
        );
    }

    /** Returns the latest policy by default, or one exact immutable version. */
    public function lookup(string $operatingPolicyId, ?int $version = null): \Inttegro\OperatingPolicy\OperatingPolicy
    {
        return $this->http->postResource(
            '/operating_policies/lookup',
            \Inttegro\OperatingPolicy\OperatingPolicy::class,
            'operating_policy',
            $this->lookupPayload($operatingPolicyId, $version),
        );
    }

    /** Lists immutable versions of one operating policy. */
    public function page(
        string $operatingPolicyId,
        ?int $number = null,
        ?int $size = null,
    ): \Inttegro\OperatingPolicy\Page {
        $payload = ['operating_policy_id' => $operatingPolicyId];
        if ($number !== null) {
            $payload['number'] = $number;
        }
        if ($size !== null) {
            $payload['size'] = $size;
        }
        return $this->http->postResource(
            '/operating_policies/page',
            \Inttegro\OperatingPolicy\Page::class,
            'page',
            $payload,
        );
    }

    /** Creates and activates a new immutable operating-policy version. */
    public function update(array $payload): \Inttegro\OperatingPolicy\OperatingPolicy
    {
        return $this->http->postResource(
            '/operating_policies/update',
            \Inttegro\OperatingPolicy\OperatingPolicy::class,
            'operating_policy',
            $payload,
        );
    }

    /** @return array<string, int|string> */
    private function lookupPayload(string $operatingPolicyId, ?int $version): array
    {
        $payload = ['operating_policy_id' => $operatingPolicyId];
        if ($version === null) {
            return $payload;
        }
        if ($version < 1) {
            throw new \InvalidArgumentException('version must be greater than or equal to 1');
        }
        $payload['version'] = $version;
        return $payload;
    }
}
