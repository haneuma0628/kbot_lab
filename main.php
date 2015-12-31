<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
require_once('/var/www/html/hassakutea/kbot_lab/config.php');

$oauth = new TwitterOAuth(
	CONSUMER_KEY, CONSUMER_SECRET,
	ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/*---------- define ----------*/
$messageArray = yaml_parse_file("/var/www/html/hassakutea/kbot_lab/message_main.yml");
$randMo = rand(0, count($messageArray["morning"])-1);
$randNo = rand(0, count($messageArray["normal"])-1);
$randNi = rand(0, count($messageArray["night"])-1);
/*---------- /define ----------*/

echo date("--- Y.m.d h:i:s ---")."\n";

/*---------- メッセージを配列に格納 ----------*/
if (date("H")==8) {
  $message = $messageArray["morning"][$randMo];
} else if (date("H")==0){
  $message = $messageArray["night"][$randNi];
} else {
  $message = $messageArray["normal"][$randNo];
}

// messageをテンプレートにつっこんでtwitterでpost
$tweet = array( "status" => $message );
$result = $oauth->post('statuses/update', $tweet);

var_dump($result);

?>