<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone

require_once(realpath(__DIR__ . '/../twitteroauth/twitteroauth.php'));
require_once(__DIR__ . '/config.php');

$oauth = new TwitterOAuth(
	CONSUMER_KEY, CONSUMER_SECRET,
	ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$messageArray = yaml_parse_file(__DIR__ . "/message_main.yml");
$randMo = rand(0, count($messageArray["morning"])-1);
$randNo = rand(0, count($messageArray["normal"])-1);
$randNi = rand(0, count($messageArray["night"])-1);

echo date("--- Y.m.d h:i:s ---")."\n";

if (date("H")==8) {
	$message = $messageArray["morning"][$randMo];
} else if (date("H")==0){
	$message = $messageArray["night"][$randNi];
} else {
	$message = $messageArray["normal"][$randNo];
}

$tweet = array("status" => $message);
$result = $oauth->post('statuses/update', $tweet);
?>