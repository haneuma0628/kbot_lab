<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone
session_start();

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
//require_once('/var/www/html/tmhOAuth/tmhOAuth.php');
require_once('/var/www/html/kbot_lab/config.php');

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
//$oauth = new tmhOAuth (array(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET));

/*---------- define ----------*/
/*---------- /define ----------*/

// データベースごにょごにょ //テストなう
//$pdo = new PDO("mysql:dbname=kbot_lab;port=10013", "dbuser", "sider5821");　// pdoオブジェクトを生成
//var_dump($pdo);
/*$st = $pdo->query("SELECT * FROM message"); // SQL文の発行
$i = 0;
while ($row = $st->fetch()) {
  $messe_from_db[$i] = $row['text']l
    echo $messe_from_db[$i];
}*/

// mention取得テスト
$mentions = $oauth->get('statuses/mentions_timeline');
//var_dump($mentions);

if (!$_SESSION['id']) {$_SESSION['id'] = 0;}

foreach ($mentions as $tweet) {
  var_dump ($tweet); echo "<br>"; echo "<br>";
  $tweet_id = $tweet->id;
  if ($_SESSION['id'] <= $tweet_id) {
    $_SESSION['id'] = $tweet_id;
    $mention_to = "@". $tweet->user->screen_name;
    $message = " 何ですか、先輩。";
    $mention_id = $tweet_id;
    $post_tweet = array( "status" => $mention_to. $message. " at ". $mention_id);
    $result = $oauth->post('statuses/update', $post_tweet);
  }
  echo "<br>"; echo "<br>";
  echo ($tweet->user->screen_name);
  echo ($tweet->text);
  echo "<br>"; echo "<br>";
}

?>
