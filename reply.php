<?php
date_default_timezone_set("Asia/Tokyo"); // time_zone

// include
require_once("/var/www/html/twitteroauth/twitteroauth.php");
require_once("/var/www/html/hassakutea/kbot_lab/config.php");

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// mentionリスト取得
$mentions = $oauth->get("statuses/mentions_timeline");

// メッセージ取得
$messages = yaml_parse_file("/var/www/html/hassakutea/kbot_lab/message_reply.yml");

// last_tweet_idから最後に返信したツイートのIDを取得
$handle = fopen("/var/www/html/hassakutea/kbot_lab/last_tweet_id", "r");
if ($handle) {
  $lastTweetId = (int)fgets($handle);
  fclose($handle);
}

// 最後のツイートIDを記録する用の変数
$mentionId = 0;

// ログ用
echo date("--- Y.m.d h:i:s ---")."\n";

foreach ($mentions as $mention) {
  //if ($mention->user->screen_name == "hnmx4" && $mention->id > $lastTweetId) {
  if ($mention->id > $lastTweetId) {
    echo $mention->user->screen_name.":".$mention->text.":".$mention->id."\n";

    $reply_to = $mention->user->screen_name;
    $reply_name = $mention->user->name;

    $keyword = "励まし";
    $pos = strpos($mention->text, $keyword);

    if ($pos) {
      $num = rand(0, count($messages["hagemashi"])-1);
      $reply_text = $reply_name."先輩、".$messages["hagemashi"][$num];

    } else {
      $num = rand(0, count($messages["none"])-1);
      $reply_text = $reply_name."先輩、".$messages["none"][$num];
    }

    $reply = array(
		   "status" => "@".$reply_to." ".$reply_text,
		   "in_reply_to_status_id" => $mention->id,
		   );
    $post = $oauth->post('statuses/update', $reply);

    var_dump($reply)."\n";
    var_dump($post)."\n";
    if ($mentionId < $mention->id) $mentionId = $mention->id;
  }
}

if ($lastTweetId < $mentionId) {
  $handle = fopen("/var/www/html/hassakutea/kbot_lab/last_tweet_id", "w");
  if ($handle) {
    echo "write:".$mentionId."\n";
    fwrite($handle, $mentionId);
    fclose($handle);
  }
}

?>