<?php

namespace Inttegro\Payout;


/**
 * Payout settings fields returned after a mutation.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class SettingsMutation extends \Inttegro\DomainValue
{
    /**
     * Currency-to-financial-account destination assignments.
     *
     * Optional response field. PHP type: `\Inttegro\Payout\Destinations|null`; wire field:
     * `destinations` (`object`).
     *
     * @var \Inttegro\Payout\Destinations|null
     */
    public readonly ?\Inttegro\Payout\Destinations $destinations;

    /**
     * Updated foreign-exchange setting returned by FX mutations.
     *
     * Optional response field. PHP type: `bool|null`; wire field: `fx_enabled` (`boolean`).
     *
     * @var bool|null
     */
    public readonly ?bool $fxEnabled;

    /**
     * Payout settings identifier.
     *
     * Optional response field. PHP type: `string|null`; wire field: `id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $id;

    /**
     * Updated payout schedule.
     *
     * Optional response field. PHP type: `\Inttegro\Payout\SettingsMutationSchedule|null`; wire
     * field: `schedule` (`object`).
     *
     * @var \Inttegro\Payout\SettingsMutationSchedule|null
     */
    public readonly ?\Inttegro\Payout\SettingsMutationSchedule $schedule;

    /**
     * Hydrates a SettingsMutation from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->destinations = \Inttegro\ValueHydrator::object($data['destinations'] ?? null, [\Inttegro\Payout\Destinations::class], true);
        $this->fxEnabled = \Inttegro\ValueHydrator::bool($data['fx_enabled'] ?? null, true);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->schedule = \Inttegro\ValueHydrator::object($data['schedule'] ?? null, [\Inttegro\Payout\SettingsMutationSchedule::class], true);
    }

    /**
     * Creates a SettingsMutation from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable SettingsMutation value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
