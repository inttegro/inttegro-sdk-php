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
                    'public_id' => 'bt_aging_spec_immediate',
                    't_plus' => '0h',
                ],
            ],
            'payment_methods' => [
                'mobile_money' => ['enabled' => true, 'confirms_use' => true],
            ],
        ];
        $adapter = static function ($method, $url, $headers, $payload) use (&$requests, $timestamps, $capabilities): array {
            $requests[] = compact('method', 'url', 'payload');
            $path = parse_url($url, PHP_URL_PATH);
            $body = $path === '/children_policies/lookup'
                ? ['children_policy' => [
                    'id' => 'cp_1',
                    'owner_application_id' => 'app_1',
                    'version' => 1,
                    'active_version' => 1,
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
                ]]
                : ['operating_policy' => [
                    'id' => 'op_1',
                    'version' => 1,
                    'active_version' => 1,
                    'name' => 'Retail',
                    'capabilities' => $capabilities,
                    'children_policy_id' => 'cp_1',
                    'children_policy_version' => 1,
                    ...$timestamps,
                ]];
            return ['status' => 200, 'body' => json_encode($body), 'headers' => ['content-type' => 'application/json']];
        };
        $client = new Client('sk_test', adapter: $adapter, telemetryEnabled: false);

        $childrenPolicy = $client->childrenPolicies->lookup();
        $created = $client->operatingPolicies->create(['name' => 'Retail', 'capabilities' => $capabilities]);
        $lookedUp = $client->operatingPolicies->lookup('op_1');
        $updated = $client->operatingPolicies->update(['operating_policy_id' => 'op_1', 'expected_version' => 1, 'name' => 'Retail v2']);

        self::assertInstanceOf(ChildrenPolicy::class, $childrenPolicy);
        self::assertSame('0h', $childrenPolicy->capabilities->payouts->btAgingSpec[0]->tPlus);
        self::assertInstanceOf(OperatingPolicy::class, $created);
        self::assertSame('bt_aging_spec_immediate', $created->capabilities->payouts->btAgingSpec->publicId);
        self::assertSame('op_1', $lookedUp->id);
        self::assertSame('op_1', $updated->id);
        self::assertSame([
            '/children_policies/lookup',
            '/operating_policies/create',
            '/operating_policies/lookup',
            '/operating_policies/update',
        ], array_map(static fn(array $request): string => parse_url($request['url'], PHP_URL_PATH), $requests));
        self::assertSame('op_1', json_decode($requests[2]['payload'], true)['operating_policy_id']);
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
