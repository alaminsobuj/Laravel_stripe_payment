<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use session;
use Stripe;
class StripepaymentController extends Controller
{
 public function gotoStripe() {
            // $customer_id = $this->session->userdata('log_id');
            // $amount = $this->session->userdata('total_amount');
            // $order_id = $this->session->userdata('invoice_id');
            // $data['gateway'] = $this->stripe_model->get_configdata();
             return view('website.stripe');
    }
    
    //====stripe payment method main method===
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
            
            Stripe\Stripe::setApiKey('sk_test_Le1Tg72goPIHPaHPzBAQTgRn');
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
            $transactionID = $chargeJson['balance_transaction'];
            $paidAmount = $chargeJson['amount'];
            $paidCurrency = $chargeJson['currency'];
            $payment_status = $chargeJson['status'];

            // Include database connection file  
            //                include_once 'dbConnect.php';
            // Insert tansaction data into the database 
            // $cardInfo_data = array(
            //     // 'invoice_id' => $orderid,
            //     // 'customer_id' => $customer_id,
            //     'card_number' => $card_number,
            //     'ex_month' => $card_exp_month,
            //     'ex_year' => $card_exp_year,
            //     'order_amount' => '10',
            //     'order_currency' => $currency,
            //     'paid_amount' => $paidAmount,
            //     'paid_currency' => $paidCurrency,
            //     'balance_trxID' => $transactionID,
            //     'payment_status' => $payment_status,
            // );

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
    //====end stripe payment method main method===
   }    