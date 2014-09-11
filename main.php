<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
require_once('/var/www/html/kbot_lab/config.php');

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/*---------- define ----------*/
$messages = yaml_parse_file("/var/www/html/kbot_lab/message_main.yml");
$randNo = rand(0,count($messages["normal"])-1);
$randNi = rand(0,count($messages["night"])-1);
/*---------- /define ----------*/

/*---------- メッセージを配列に格納 ----------*/
if (date("H")==8) {
  $message = $messages["mornign"][0];
} else if (date("H")==0){
  $message = $messages["night"][$randNi];
} else {
  $message = $messages["normal"][$randNo];
}

// messageをテンプレートにつっこんでtwitterでpost
$tweet = array( "status" => $message );
$result = $oauth->post('statuses/update', $tweet);
// debug
//var_dump($result);
//var_dump($messages);
//var_dump($message);

?>