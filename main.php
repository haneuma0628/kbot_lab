<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
require_once('/var/www/html/kbot_lab/config.php');

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/*---------- define ----------*/
$messageArray = yaml_parse_file("message.yml");

$today = (int) date("d");
// 卒研発表会までの残り日数(FNCT.H24)
//$limit = (date("m")==01)? 27-$today: NULL;
// 卒研中間発表までの残り日数(FNCT.H25)
$limit = (date("m")==10)? 31-$today: NULL;
$randNo = rand(0,count($messageArray["normal"])-1);
$randNi = rand(0,count($messageArray["night"])-1);
/*---------- /define ----------*/

/*---------- メッセージを配列に格納 ----------*/
if (date("H")==8) {
  $message = $messageArray["mornign"][0];
} else if (date("H")==0){
  $message = $messageArray["night"][$randNi];
} else if (date("H")==10 && $limit!=NULL) {
  $limit = strtoupper((string) gmp_strval($limit, 16));
  if($limit != "1"){
    $message = "@hnmx4 先輩、卒研発表会まで残り0x". $limit. "日ですね。";
  } else {
    $message = "@hnmx4 ". $messageArry["cheer"][0];
  }
} else {
  $message = $messageArray["normal"][$randNo];


// messageをテンプレートにつっこんでtwitterでpost
$tweet = array( "status" => $message );
$result = $oauth->post('statuses/update', $tweet);
// debug
//var_dump($result);
var_dump($messageArray);
var_dump($message);

?>