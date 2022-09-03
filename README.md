# Laravel_stripe_payment
This is Laravel Stripe payment getaway
# 1. Install composer command 
<strong>composer require stripe/stripe-php</strong>

# Create account from stripe.com
#2. Go stripe developer page and  click  API keys menu  see this two 
STRIPE_KEY=pk_test_reFxwbsm9cdCKASdTfxAR
STRIPE_SECRET=sk_test_oQMFWteJiPd4wj4AtgApY
#3. create view page method 
    
    public function gotoStripe() {
             return view('website.stripe');
    }
    
#4. view page submit button click than create this method 
 public function stripepayment(Request $request) {

            $input=$request->all();
        
            // Set API key 
            $token = $request->stripeToken;
            $name = $request->cardName;
            $email ='alaminsobuj8@gmail.com';
            $card_number = $request->cardNumber;
            $card_exp_month = $request->card_exp_month;
            $card_exp_year = $request->card_exp_year;
            $card_cvc = $request->card_cvc;
            
            Stripe\Stripe::setApiKey('Secret key');
            $stripe_customer = \Stripe\Customer::create(array(
                            'email' => $email,
                            'source' => $request->stripeToken
                ));
            $charge=Stripe\Charge::create ([
                    'customer' => $stripe_customer->id,
                    "amount" => 100 * 100,
                    "currency" => "usd",
                    // "source" => $request->stripeToken,
                    "description" => "Test payment from itsolutionstuff.com." 
            ]);
    
            $chargeJson = $charge->jsonSerialize();
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
            $payment_status = $chargeJson['status'];
            if ($payment_status == 'succeeded') {
                $ordStatus = 'success';
                echo "success";
                $request->session()->flash('success', 'Payment completed.');
                  //                    $statusMsg = 'Your Payment has been Successful!';
                // redirect('stripe/stripe/payment_success/');
            } else {
                // $statusMsg = "Your Payment has Failed!";
                echo "fail";
                $request->session()->flash('danger', 'Payment failed.');
            }

        }else{
            $statusMsg = "Transaction has been failed!";
        }
        return response()->redirectTo('/');
 
    }
    
demo card 
1. visa card no: 4242424242424242
2. 123
4. Future month and year


