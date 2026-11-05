<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/** Active children-policy operations available to private-beta callers. */
final class ChildrenPolicies
{
    /** Creates the children-policies resource client. */
    public function __construct(private HttpClient $http)
    {
    }

    /** Returns the authenticated application's latest active children policy. */
    public function lookup(): \Inttegro\ChildrenPolicy\ChildrenPolicy
    {
        return $this->http->postResource(
            '/children_policies/lookup',
            \Inttegro\ChildrenPolicy\ChildrenPolicy::class,
            'children_policy',
            [],
        );
    }
}
