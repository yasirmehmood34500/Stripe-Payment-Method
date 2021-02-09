<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include "vendor/stripe/stripe-php/init.php";

$stripe = new \Stripe\StripeClient(
  'sk_test_51IISVaLGHNcDteW'
);
$val1=$stripe->paymentMethods->create([
  'type' => 'card',
  'card' => [
    'number' => $_POST['card_number'],
    'exp_month' => $_POST['exp_month'],
    'exp_year' => $_POST['exp_year'],
    'cvc' => $_POST['card_cvc'],
  ],
  'billing_details' =>[
  	'email' => $_POST['email'],
  	'name'  => $_POST['name'],
  	'phone' => $_POST['phone']
  ],

]);
$val2=$stripe->paymentIntents->create([
  'amount' => $_POST['amount'],
  'currency' => 'usd',
  'payment_method_types' => ['card'],
  'description' => $_POST['description'],
  'receipt_email' => $_POST['email'],
]);
$confirm= $val2->id;
$val3=$stripe->paymentIntents->confirm(
  $confirm,
  ['payment_method' => 'pm_card_visa']
);
echo json_encode($val3);
 ?>