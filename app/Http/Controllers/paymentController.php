<?php

namespace App\Http\Controllers;

require __DIR__ . '/vendor/autoload.php';

class paymentController extends Controller
{

    private $publica = 'AbE4JvVdwKszjoXjPQkHrWiuF3co5_6_HTYYJVHgnjqkQhkS5IUR1vUr4XGA2x8x644QG1HXuCuQZWCv';
    private $private = 'EKhSqhnJ7DVw45hmGRVhJUOTEIKAipQUc-wUaCHDvMx5Unrdlxy4_8MzLy8lScbWozzFr_BZvFaV8Jag';

    public function execute()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->publica, // ClientID
                $this->private// ClientSecret
            )
        );

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal('1.99');
        $amount->setCurrency('EUR');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("http://iminlist.staging.grupo04.ddaw.site/pricing")
            ->setCancelUrl("http://iminlist.staging.grupo04.ddaw.site/pricing");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            echo $payment;

            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }

    }

}
