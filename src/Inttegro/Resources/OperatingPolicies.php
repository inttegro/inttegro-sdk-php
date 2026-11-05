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

    /** Returns the latest active version of an operating policy. */
    public function lookup(string $operatingPolicyId): \Inttegro\OperatingPolicy\OperatingPolicy
    {
        return $this->http->postResource(
            '/operating_policies/lookup',
            \Inttegro\OperatingPolicy\OperatingPolicy::class,
            'operating_policy',
            ['operating_policy_id' => $operatingPolicyId],
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
}
