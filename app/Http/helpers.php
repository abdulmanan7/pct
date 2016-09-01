<?php
function call_api($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 400);
	curl_setopt($ch, CURLOPT_TIMEOUT, 400);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
function aws_query($extraparams) {
	$private_key = "R/Kztk/a9ksQys7dggzYv/cbsMZI6M4Ka61mL1IS";
	$method = "GET";
	$host = "webservices.amazon.com";
	$uri = "/onca/xml";

	$params = array(
		"AssociateTag" => "wr0d3-20",
		"Service" => "AWSECommerceService",
		"AWSAccessKeyId" => "AKIAJBSTULBU5RYVA4DA",
		"Operation" => "ItemSearch",
		'TotalPages' => 20,
		"Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
		"SignatureMethod" => "HmacSHA256",
		"SignatureVersion" => "2",
		"Version" => "2013-08-01",
	);

	foreach ($extraparams as $param => $value) {
		$params[$param] = $value;
	}

	ksort($params);

	// sort the parameters
	// create the canonicalized query
	$canonicalized_query = array();
	foreach ($params as $param => $value) {
		$param = str_replace("%7E", "~", rawurlencode($param));
		$value = str_replace("%7E", "~", rawurlencode($value));
		$canonicalized_query[] = $param . "=" . $value;
	}
	$canonicalized_query = implode("&", $canonicalized_query);

	// create the string to sign
	$string_to_sign =
	$method . "\n" .
	$host . "\n" .
	$uri . "\n" .
	$canonicalized_query;

	// calculate HMAC with SHA256 and base64-encoding
	$signature = base64_encode(
		hash_hmac("sha256", $string_to_sign, $private_key, True));

	// encode the signature for the equest
	$signature = str_replace("%7E", "~", rawurlencode($signature));

	// Put the signature into the parameters
	$params["Signature"] = $signature;
	uksort($params, "strnatcasecmp");

	// TODO: the timestamp colons get urlencoded by http_build_query
	//       and then need to be urldecoded to keep AWS happy. Spaces
	//       get reencoded as %20, as the + encoding doesn't work with
	//       AWS
	$query = urldecode(http_build_query($params));
	$query = str_replace(' ', '%20', $query);

	$string_to_send = "https://" . $host . $uri . "?" . $query;

	return call_api($string_to_send);
}
function parse($fileContents) {
	$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
	$fileContents = trim(str_replace('"', "'", $fileContents));
	$simpleXml = simplexml_load_string($fileContents);
	$json = json_encode($simpleXml);

	return $json;
}