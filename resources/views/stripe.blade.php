<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 45px;
            padding: 12px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            border-width: 1px;
            border-color: lightgrey;
            border-style: solid;
            margin-bottom: 10px;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
</head>

<body>
    @if (Session::has('error'))
        <p class="alert alert-danger">{{ Session::get('error') }}</p>
    @endif
    @if (session('message'))
        <div class="success-alert alert alert-info">{{ session('message') }}</div>
    @endif

    @if ($data->status == 0)
        <div class="container">

            <img src="{{ asset($data->client->brand->image) }}">

            <header>
                Customer info <span>{{ $data->currency != null ? $data->currency->sign : '$' }}{{ $data->price }}</span><br>
            </header>
            @if (Session::has('stripe_error'))
                <p>{{ Session::get('stripe_error') }}</p>
            @endif
            <div id="error-message"></div>
            <form id="card-form" action="{{ route('pay.now') }}" method="post">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="amount" value="{{ $data->price }}">
                @csrf
                <div class="field-row">

                    <div>
                        <input type="text" placeholder="Enter First Name" name="ssl_first_name" class="demoInputBox" required>
                        <span class="invalid-feedback alert alert-danger"><strong></strong></span>

                    </div>
                    <div>
                        <input type="text" placeholder="Enter Last Name" name="ssl_last_name" class="demoInputBox"
                            required>
                        <span class="invalid-feedback alert alert-danger"><strong></strong></span>
                    </div>
                    <div>
                        <input type="text" name="ssl_avs_address" placeholder="Street Address" required><br>
                        <span class="invalid-feedback alert alert-danger"><strong></strong></span>
                    </div>
                    <div>
                        <input type="text" name="ssl_avs_zip" placeholder="Zip Code" required>
                        <span class="invalid-feedback alert alert-danger"><strong></strong></span>
                    </div>

                    <br>


                </div>
                <header>Credit Card Details</header>
                <br>

                <input type="hidden" name="id" value="{{ $data->id }}">
                <div id="card"></div>

                <div id="card-errors" role="alert"></div>

                <div>
                    <button class="btnAction" type="button" id="stripe-submit">Submit</button>
                    <div id="loader" style="display: none;">
                        <img src="{{ asset('images/loader.gif') }}" alt="">
                    </div>
                    <!-- <div id="loader">
                        <img alt="loader" src="LoaderIcon.gif">
                        </div> -->
                </div>
            </form>
        </div>
    @else
        @if ($data->status == 2)
            <div class="success-alert alert alert-info">PAID!</div>
        @elseif($data->status == 1)
            <div class="success-alert alert alert-info">{{ $data->return_response }}</div>
        @endif
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
        integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        @if($data->merchants == null)
        let stripe = Stripe('{{ env('STRIPE_KEY') }}')
        @else
        let stripe = Stripe('{{ $data->merchants->public_key }}')
        @endif
        const elements = stripe.elements()
        const card = elements.create('card', {
            style: {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });

        card.mount('#card');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                $(displayError).show();
                displayError.textContent = event.error.message;
            } else {
                $(displayError).hide();
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('card-form');

        $('#stripe-submit').click(function() {
            $('#stripe-submit').hide();
            $('#loader').show();

            const clientSecret = '{{ $data->client_secret }}';

            var errorCount = checkEmptyFileds();
            if (errorCount == 1) {
                $('#loader').hide();
                $('#stripe-submit').show();
                var displayError = document.getElementById('card-errors');
                $(displayError).show();
                displayError.textContent = 'Please fill the required fields before proceeding to pay';
                return;
            }

            var firstName = $('input[name="ssl_first_name"]').val();
            var lastName = $('input[name="ssl_last_name"]').val();
            var cardholderName = firstName + ' ' + lastName;

            stripe.confirmCardSetup(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardholderName
                    }
                }
            }).then(function (result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    $(errorElement).show();
                    errorElement.textContent = result.error.message;
                    $('#loader').hide();
                    $('#stripe-submit').show();
                } else {
                    // Success: send payment_method ID to server
                    stripeTokenHandler(result.setupIntent.payment_method);
                }
            });
        });

        function checkEmptyFileds() {
            var errorCount = 0;
            $('form#card-form').find('input').each(function() {
                if ($(this).prop('required')) {
                    if (!$(this).val()) {
                        $(this).parent().find('.invalid-feedback').addClass('d-block');
                        $(this).parent().find('.invalid-feedback strong').html('This field is Required');
                        errorCount = 1;
                    }
                }
            });
            return errorCount;
        }


        function stripeTokenHandler(paymentMethodId) {
            var form = document.getElementById('card-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', paymentMethodId);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</body>

</html>
