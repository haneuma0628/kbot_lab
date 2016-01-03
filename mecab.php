<?php
function markov($messages) {
// テーブル作成
	$table = array();
	foreach ($messages as $message) {
		/* echo $message."\n"; */
		$words = mecab_split($message);
		$i = 0;
		while ($i < count($words)) {
			if (empty($table[current($words)])) {
				$table[current($words)] = array(next($words));
			} else {
				array_push($table[current($words)], next($words));
			}
			$i++;
		}
	}

	$keys = array_keys($table);
	$current_w = $keys[array_rand($keys)];
	$period = array("。", "！", "？");
	$punc = array("・", "、", "「", "」");
	while (array_search($current_w, $period) && array_search($current_w, $punc)) {
		$current_w = array_rand($keys);
	}
	$result = array($current_w);

	while (!array_search($current_w, $period)) {
		if (count($table[$current_w]) > 1) {
			$next_w = $table[$current_w][array_rand($table[$current_w])];
		} else {
			if (empty($table[$current_w])) {
				break;
			} else {
				$next_w = $table[$current_w][0];
			}
		}
		if ($next_w == false) break;
		array_push($result, $next_w);
		$current_w = $next_w;
	}

	$sentence = implode($result)."\n";
	return $sentence;
}

$message_file = yaml_parse_file("/var/www/html/hassakutea/kbot_lab/message_main.yml");
$messages = array();
foreach ($message_file as $ary) {
	$messages = array_merge($messages, $ary);
}
echo markov($messages);
?>