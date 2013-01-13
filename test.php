<?php
date_default_timezone_set('Asia/Tokyo'); // time_zone

// include
require_once('/var/www/html/twitteroauth/twitteroauth.php');
require_once('/var/www/html/kbot_lab/config.php');

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET); //twitterOAuthのオブジェクトを生成

/*---------- define ----------*/
// 卒研発表会までの残り日数
$today = (int) date("d");
$limit = (date("m")==01)? 27-$today: NULL;
// 定型文
//$head = "先輩、";
$rand_bool = rand(0,1);
$rand_randmesse = rand(0,10);
/*---------- /define const ----------*/

// データベースごにょごにょ //テストなう
//$pdo = new PDO("mysql:dbname=kbot_lab;port=10013", "dbuser", "sider5821");　// pdoオブジェクトを生成
//var_dump($pdo);
/*$st = $pdo->query("SELECT * FROM message"); // SQL文の発行
$i = 0;
while ($row = $st->fetch()) {
  $messe_from_db[$i] = $row['text']l
    echo $messe_from_db[$i];
}

/*---------- メッセージを配列に格納 ----------*/
/**
 ** データベースからメッセージ持ってきたいね
 **/
// ランダムなメッセージ
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

// 深夜のメッセージ
$m_midnight[0] ="こんな時間まで起きて作業してるんですか？進まない卒研に電気代かけるのは勿体ないじゃないですか…日のあるうちに作業してください…";
$m_midnight[1] ="徹夜でコード書くって言ってますけど、時間を区切ってちゃんと睡眠とった方が集中できますよ？";

// 朝のメッセージ
$m_morning[0] = "先輩、おはようございます。まだ寝てるんですか？早く起きてください。起きて研究室に行ってください。研究室で現実と向き合ってください。";
/*---------- メッセージを配列に格納 ----------*/

// debug
//$message = $m_rand[$rand_randmesse];
//var_dump($message);
// debug

if (date("H")==10 && $limit!=NULL) {
// 卒研発表会まで残り日数をpost
  $limit = strtoupper((string) gmp_strval($limit, 16));
  $message = "卒研発表会まで残り". $limit. "(16)日ですね。";
} else if (date("H")==8) {
// 午前8時におはようメッセージをpost
   $message = $m_morning[0];
} else if (date("H")==0){
// 午前0時に毒舌orデレをpost
   $message = $m_midnight[$rand_bool];
} else {
// それ以外はランダムなメッセージをpost
  $message = $m_rand[$rand_randmesse];
}

var_dump($limit);

// messageをテンプレートにつっこんでtwitterでpost
$tweet = array( "status" => $message );
$result = $oauth->post('statuses/update', $tweet);
// debug
var_dump($result);

// mention取得テスト
$mentions = $oauth->get('statuses/mentions_timeline');
var_dump($mentions);

?>
