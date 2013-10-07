<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
require_once('/var/www/html/kbot_lab/config.php');

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/*---------- define ----------*/
$messageArray = yaml_parse_file("/var/www/html/kbot_lab/message.yml");
$randNo = rand(0,count($messageArray["normal"])-1);
$randNi = rand(0,count($messageArray["night"])-1);
/*---------- /define ----------*/

/*---------- メッセージを配列に格納 ----------*/
if (date("H")==8) {
  $message = $messageArray["mornign"][0];
} else if (date("H")==0){
  $message = $messageArray["night"][$randNi];
} else {
  $message = $messageArray["normal"][$randNo];
}

// messageをテンプレートにつっこんでtwitterでpost
$tweet = array( "status" => $message );
$result = $oauth->post('statuses/update', $tweet);
// debug
//var_dump($result);
var_dump($messageArray);
var_dump($message);

?>