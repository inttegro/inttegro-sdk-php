<?php

use Inttegro\Client;
use Inttegro\ChildrenPolicy\ChildrenPolicy;
use Inttegro\OperatingPolicy\OperatingPolicy;
use PHPUnit\Framework\TestCase;

final class PolicyTypesTest extends TestCase
{
    public function test_policy_resources_are_typed_and_use_documented_paths(): void
    {
        $requests = [];
        $timestamps = [
            'created_at' => '2026-11-05T10:00:00Z',
            'updated_at' => '2026-11-05T10:00:00Z',
            'version_created_at' => '2026-11-05T10:00:00Z',
        ];
        $capabilities = [
            'payments' => [
                'currencies' => ['ghs'],
                'limits' => ['amount' => ['min' => 1, 'max' => 9999999]],
            ],
            'payouts' => [
                'enabled' => false,
                'bt_aging_spec' => [
                    'id' => 'bt_aging_spec_immediate',
                    't_plus' => '0h',
                ],
            ],
            'payment_methods' => [
                'mobile_money' => ['enabled' => true, 'confirms_use' => true],
            ],
        ];
        $resolvedCapabilities = $capabilities;
        $resolvedCapabilities['payouts']['bt_aging_spec'] = [
            'public_id' => 'bt_aging_spec_immediate',
            't_plus' => '0h',
        ];
        $adapter = static function ($method, $url, $headers, $payload) use (&$requests, $timestamps, $resolvedCapabilities): array {
            $requests[] = compact('method', 'url', 'payload');
            $path = parse_url($url, PHP_URL_PATH);
            $requestBody = json_decode($payload ?: '{}', true);
            $version = $requestBody['version'] ?? 2;
            $childrenPolicy = [
                'id' => 'cp_1',
                'version' => $version,
                'active_version' => 2,
                'name' => 'Default',
                'capabilities' => [
                    'payments' => ['currencies' => ['ghs']],
                    'payouts' => [
                        'enabled' => [false],
                        'bt_aging_spec' => [[
                            'public_id' => 'bt_aging_spec_immediate',
                            't_plus' => '0h',
                        ]],
                    ],
                ],
                ...$timestamps,
            ];
            $operatingPolicy = [
                'id' => 'op_1',
                'version' => $version,
                'active_version' => 2,
                'name' => 'Retail',
                'capabilities' => $resolvedCapabilities,
                'children_policy_id' => 'cp_1',
                'children_policy_version' => 2,
                ...$timestamps,
            ];
            if ($path === '/children_policies/page' || $path === '/operating_policies/page') {
                $body = ['page' => [
                    'number' => 2,
                    'size' => 1,
                    'count' => 1,
                    'total' => 2,
                    'has_more' => true,
                    'versions' => [$path === '/children_policies/page' ? $childrenPolicy : $operatingPolicy],
                ]];
            } elseif ($path === '/children_policies/lookup') {
                $body = ['children_policy' => $childrenPolicy];
            } else {
                $body = ['operating_policy' => $operatingPolicy];
            }
            return ['status' => 200, 'body' => json_encode($body), 'headers' => ['content-type' => 'application/json']];
        };
        $client = new Client('sk_test', adapter: $adapter, telemetryEnabled: false);

        $childrenPolicy = $client->childrenPolicies->lookup();
        $historicalChildrenPolicy = $client->childrenPolicies->lookup(1);
        $childrenPage = $client->childrenPolicies->page(2, 1);
        $created = $client->operatingPolicies->create(['name' => 'Retail', 'capabilities' => $capabilities]);
        $lookedUp = $client->operatingPolicies->lookup('op_1');
        $historicalOperatingPolicy = $client->operatingPolicies->lookup('op_1', 1);
        $operatingPage = $client->operatingPolicies->page('op_1', 2, 1);
        $updated = $client->operatingPolicies->update(['operating_policy_id' => 'op_1', 'expected_version' => 1, 'name' => 'Retail v2']);

        self::assertInstanceOf(ChildrenPolicy::class, $childrenPolicy);
        self::assertSame(2, $childrenPolicy->version);
        self::assertSame(1, $historicalChildrenPolicy->version);
        self::assertSame('0h', $childrenPolicy->capabilities->payouts->btAgingSpec[0]->tPlus);
        self::assertTrue($childrenPage->hasMore);
        self::assertSame('cp_1', $childrenPage->versions[0]->id);
        self::assertInstanceOf(OperatingPolicy::class, $created);
        self::assertSame('bt_aging_spec_immediate', $created->capabilities->payouts->btAgingSpec->publicId);
        self::assertSame('op_1', $lookedUp->id);
        self::assertSame(1, $historicalOperatingPolicy->version);
        self::assertSame(2, $operatingPage->total);
        self::assertSame('op_1', $operatingPage->versions[0]->id);
        self::assertSame('op_1', $updated->id);
        self::assertSame([
            '/children_policies/lookup',
            '/children_policies/lookup',
            '/children_policies/page',
            '/operating_policies/create',
            '/operating_policies/lookup',
            '/operating_policies/lookup',
            '/operating_policies/page',
            '/operating_policies/update',
        ], array_map(static fn(array $request): string => parse_url($request['url'], PHP_URL_PATH), $requests));
        self::assertSame([], json_decode($requests[0]['payload'], true));
        self::assertSame(['version' => 1], json_decode($requests[1]['payload'], true));
        self::assertSame(['number' => 2, 'size' => 1], json_decode($requests[2]['payload'], true));
        self::assertSame(
            ['operating_policy_id' => 'op_1', 'version' => 1],
            json_decode($requests[5]['payload'], true),
        );
        self::assertSame(
            ['operating_policy_id' => 'op_1', 'number' => 2, 'size' => 1],
            json_decode($requests[6]['payload'], true),
        );
    }

    public function test_lookup_version_must_be_positive(): void
    {
        $client = new Client('sk_test', adapter: static fn(): array => throw new \RuntimeException('request sent'), telemetryEnabled: false);

        $this->expectException(\InvalidArgumentException::class);
        $client->childrenPolicies->lookup(0);
    }

    public function test_app_projects_operating_policy_snapshot(): void
    {
        $app = \Inttegro\App\App::fromArray([
            'id' => 'app_1',
            'name' => 'Child',
            'created_at' => '2026-11-05T10:00:00Z',
            'capabilities' => [],
            'operating_policy' => [
                'capabilities' => ['payments' => ['currencies' => ['ghs']]],
                'source' => ['type' => 'inline'],
            ],
        ]);

        self::assertSame('inline', $app->operatingPolicy->source->type);
        self::assertSame(['ghs'], $app->operatingPolicy->capabilities->payments->currencies);
    }
}
