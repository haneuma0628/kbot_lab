<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone
session_start();

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
require_once('/var/www/html/kbot_lab/config.php');

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/*---------- define ----------*/
/*---------- /define ----------*/

// mentionリスト取得
$mentions = $oauth->get('statuses/mentions_timeline');

if (!$_SESSION['id']) {$_SESSION['id'] = 0;}

foreach ($mentions as $tweet) {
  //  var_dump ($tweet); echo "<br>"; echo "<br>";
  $tweet_id = $tweet->id;
  if ($_SESSION['id'] < $tweet_id) {
    $mention_to = "@" .$tweet->user->screen_name;
    $mention_name = $tweet->user->name;
    // 文字列検索
    $str = $tweet->text;
    $keyword = "励まして";
    $pos = strpos($str, $keyword);
    // /文字列検索
    if ($pos) {
      $message = " " .$mention_name ."先輩、卒研頑張ってください。";
    } else {
      $message = " 何ですか、" .$mention_name ."先輩。";
    }
    $post_tweet = array( "status" => $mention_to .$message);
    $result = $oauth->post('statuses/update', $post_tweet);
    var_dump($result);

    $_SESSION['id'] = $tweet_id;
  }
}
?>
