<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Client operations for Inttegro purchase intents.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class PurchaseIntents
{
    /**
     * Creates the purchase intents resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Creates a new purchase intent.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array{product?: array<string, mixed>, product_id?: string, price?: array<string, mixed>, price_id?: string, quantity: array{min: int, max?: int}, usage?: array<string, mixed>, expires_at?: string, presentation?: array{buy_page: array{text: array{checkout_section_title?: string, amount_field_label?: string, primary_action_label?: string}}}} $payload
     * @return \Inttegro\PurchaseIntent\PurchaseIntent The created purchase intent.
     */
    public function create(array $payload): \Inttegro\PurchaseIntent\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/create', \Inttegro\PurchaseIntent\PurchaseIntent::class, 'purchase_intent', $payload);
    }

    /**
     * Updates the supplied fields on the purchase intent.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array{id?: string, purchase_intent_id?: string, quantity?: array{min: int, max?: int}, expires_at?: string|null, reactivate?: bool, presentation?: array{buy_page: array{text: array{checkout_section_title?: string|null, amount_field_label?: string|null, primary_action_label?: string|null}}}} $payload
     * @return \Inttegro\PurchaseIntent\PurchaseIntent The updated purchase intent.
     */
    public function update(array $payload): \Inttegro\PurchaseIntent\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/update', \Inttegro\PurchaseIntent\PurchaseIntent::class, 'purchase_intent', $payload);
    }

    /**
     * Cancels the purchase intent.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $id ID value.
     * @return \Inttegro\PurchaseIntent\PurchaseIntent The canceled purchase intent.
     */
    public function cancel(string $id): \Inttegro\PurchaseIntent\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/cancel', \Inttegro\PurchaseIntent\PurchaseIntent::class, 'purchase_intent', ['id' => $id]);
    }

    /**
     * Retrieves the requested purchase intent.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $id ID value.
     * @return \Inttegro\PurchaseIntent\PurchaseIntent The requested purchase intent.
     */
    public function lookup(string $id): \Inttegro\PurchaseIntent\PurchaseIntent
    {
        return $this->http->postResource('/purchase_intents/lookup', \Inttegro\PurchaseIntent\PurchaseIntent::class, 'purchase_intent', ['id' => $id]);
    }

    /**
     * Retrieves a paginated collection of purchase intents.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\PurchaseIntent\Page A typed page of matching purchase intents.
     */
    public function page(array $payload = []): \Inttegro\PurchaseIntent\Page
    {
        return $this->http->postResource('/purchase_intents/page', \Inttegro\PurchaseIntent\Page::class, 'page', $payload);
    }
}
