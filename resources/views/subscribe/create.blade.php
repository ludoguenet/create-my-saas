<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Abonnements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">

                    <fieldset>
                        <legend class="sr-only">Plan</legend>
                        <div class="space-y-5">
                            @foreach($products as $product)
                                <div class="relative flex items-start">
                                    <div class="flex h-6 items-center">
                                        <input id="{{ $product->id }}" value="{{ $product->id }}" aria-describedby="small-description" name="plan" type="radio" @checked($loop->first) class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="{{ $product->id }}" class="font-medium text-gray-900">{{ $product->name }}</label>
                                        <p id="small-description" class="text-gray-500">{{ $product->price }} €</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </fieldset>

                    <x-input-label for="card-holder-name" value="Détenteur de la carte" />
                    <x-text-input id="card-holder-name" type="text" />

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element" class="p-5 shadow rounded"></div>

                    <x-primary-button id="card-button" data-secret="{{ $intent->client_secret }}">
                        S'abonner
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe('{{ config('stripe.stripe_key') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const plans = document.querySelectorAll('input[name="plan"]');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                let selectedPlan;

                plans.forEach(plan => {
                   if (plan.checked === true) {
                       selectedPlan = plan.id;
                   }
                });

                if (error) {
                    console.log(error);
                } else {
                    await axios.post('{{ route('subscribe.store') }}', {
                        paymentMethod: setupIntent.payment_method,
                        selectedProductId: selectedPlan,
                    })
                        .then(() => {
                            window.location.href = '/dashboard';
                        });
                }
            });
        </script>
    @endpush
</x-app-layout>
