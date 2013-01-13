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
//var_dump($mentions); echo "<br>"; echo "<br>";
//echo "----------------------------------------------------------------";
//echo "<br>";

$m_rand[0] = "中間発表から進展あったんですか？";
$m_rand[1] = "先輩、パソコンに向かってるだけで研究進めた気になってちゃだめですよ？";
$m_rand[2] = "先輩、エナジードリンク飲めば卒研進むとでも思ってるんですか？";
$m_rand[3] = "先輩、そのソースコードって30分前と何が違うんですか？何も変わっていないように見えるのは僕の気のせいですか？";
$m_rand[4] = "あれ？昨日もそのバグ潰してませんでしたっけ？";
$m_rand[5] = "先輩、集中できないときは無理せず寝た方がいいですよ？だって起きてても進まないじゃないですか！";
$m_rand[6] = "卒論、間に合うんですか？";
$m_rand[7] = "その研究、去年の卒研室の先輩の研究と何が違うんですか？";
$m_rand[8] = "先輩、今まで一体何をしていたんですか？";
$m_rand[9] = "先輩、今日も遅くまで研究室に残ってるんですね。研究熱心なんですか？それとも研究が進まなくて残るしかないんですか？";
$m_rand[10] = "先輩、たまにはゆっくり休んでくださいね。";

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
  } else {
    echo "checked";
  }
/*
  echo "<br>"; echo "<br>";
  echo ($tweet->user->screen_name);
  echo ($tweet->text);
  echo "<br>"; echo "<br>";
*/
}

?>
