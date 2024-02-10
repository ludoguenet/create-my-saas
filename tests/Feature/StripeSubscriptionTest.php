<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Stripe\StripeClient;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

it('can subscribe', function () {
    $stripe = new StripeClient(config('stripe.stripe_secret'));
    $user = User::factory()->create();

    $paymentIntent = $stripe->paymentIntents->create([
       'amount' => 100,
       'currency' => 'eur',
       'payment_method' => 'pm_card_visa',
       'setup_future_usage' => 'on_session',
    ]);

    $product = Product::factory()->create([
        'stripe_product_id' => 'price_1OhvkACmRtsFb4LyyoVGgRTQ',
    ]);

    actingAs($user)
        ->post(route('subscribe.store', [
            'paymentMethod' => $paymentIntent->payment_method,
            'selectedProductId' => $product->id,
        ]));

    assertDatabaseCount('subscriptions', 1);
})->only();
