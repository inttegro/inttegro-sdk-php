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

    /** Returns the latest policy by default, or one exact immutable version. */
    public function lookup(?int $version = null): \Inttegro\ChildrenPolicy\ChildrenPolicy
    {
        return $this->http->postResource(
            '/children_policies/lookup',
            \Inttegro\ChildrenPolicy\ChildrenPolicy::class,
            'children_policy',
            $this->versionPayload($version),
        );
    }

    /** Lists immutable versions of the authenticated application's children policy. */
    public function page(?int $number = null, ?int $size = null): \Inttegro\ChildrenPolicy\Page
    {
        return $this->http->postResource(
            '/children_policies/page',
            \Inttegro\ChildrenPolicy\Page::class,
            'page',
            self::paginationPayload($number, $size),
        );
    }

    /** @return array<string, int> */
    private function versionPayload(?int $version): array
    {
        if ($version === null) {
            return [];
        }
        if ($version < 1) {
            throw new \InvalidArgumentException('version must be greater than or equal to 1');
        }
        return ['version' => $version];
    }

    /** @return array<string, int> */
    private static function paginationPayload(?int $number, ?int $size): array
    {
        return array_filter(
            ['number' => $number, 'size' => $size],
            static fn(?int $value): bool => $value !== null,
        );
    }
}
