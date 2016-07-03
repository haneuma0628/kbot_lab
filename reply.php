<?php
date_default_timezone_set("Asia/Tokyo"); // time_zone

require_once(realpath(__DIR__ . "/../twitteroauth/twitteroauth.php"));
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/markov.php");

$oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$handle = fopen(__DIR__ . "/last_replied_id", "r");
if ($handle) {
	$last_replied_id = (int)fgets($handle);
	fclose($handle);
}
$mentions = $oauth->get("statuses/mentions_timeline");
$unreplied_mentions = array();
foreach ($mentions as $mention) {
	if ($mention->id > $last_replied_id) {
		array_push($unreplied_mentions, $mention);
	}
}

if (count($unreplied_mentions) > 0) {
	foreach ($unreplied_mentions as $mention) {
		$pair = $mention->user;
		$keyword = "励まし";
		$pos = strpos($mention->text, $keyword);
		if ($pos) {
			$msg = yaml_parse_file(__DIR__ . "/message_reply.yml");
			$reply_body = $msg["hagemashi"];
		} else {
			$reply_body = markov();
		}

		$reply = array(
			"status" => "@".$pair->screen_name." ".$reply_body,
			"in_reply_to_status_id" => $mention->id,
		);
		echo date("--- Y.m.d h:i:s ---")."\n";  // ログ用
		$oauth->post('statuses/update', $reply);
		var_dump($reply);
		echo "\n";
	}

	$last_mention = $unreplied_mentions[0];
	$handle = fopen(__DIR__ . "/last_replied_id", "w");
	if ($handle) {
		fwrite($handle, $last_mention->id);
		fclose($handle);
	}
}

?>