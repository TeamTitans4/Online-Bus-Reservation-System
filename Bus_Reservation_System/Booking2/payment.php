<?php

$Name=$_POST['Name'];
$Email=$_POST['Email'];
$Amount=$_POST['Amount'];
$Phone=$_POST['phone'];
$purpose='Ticket Reservation';


include 'instamojo/Instamojo.php';
$api = new Instamojo\Instamojo('test_46a8f635f7803f17d2e4d0cf617', 'test_40eb8931471a24db6f1c3e2002c', 'https://test.instamojo.com/api/1.1/');

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => $purpose,
        "amount" => $Amount,
        "send_email" => true,
        "email" => $Email,
        "buyer_name" =>$Name,
        "phone"=>$Phone,
        "send_sms" => true,
        "allow_repeated_payments" =>false,
        "redirect_url" => "https://4-the-children.000webhostapp.com//redirect.php"
        ));
    //print_r($response);
    $pay_url=$response['longurl'];
    header("location: $pay_url");
	}
	catch (Exception $e) {
	    print('Error: ' . $e->getMessage());
	}



?>