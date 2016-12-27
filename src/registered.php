<?php
// 1. process 'address' text 
//(from GET data of HTTP request)

$address = filter_input(INPUT_GET, 'addressLine1');



// if nothing there, 
// set address to message saying it was empty
if (empty($address)){
	$address = '(address was empty)';
}
print $address;

// 2. process 'isExpress' checkbox 
// (from GET data of HTTP request)

// set default value 
// (i.e. if no checkbox for express delivery)


// 3. load in template, 
// to output form confirmations to user
require_once __DIR__ . '/../src/registered.php';
