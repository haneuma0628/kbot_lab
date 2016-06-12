<?php
function markov() {
	$table = yaml_parse_file("/var/www/html/hassakutea/kbot_lab/table.yml");

	$keys = array_keys($table);
	$current_w = $keys[array_rand($keys)];
	$period = array("。", "！", "？");
	$punc = array("・", "、", "「", "」");
	while (array_search($current_w, $period) && array_search($current_w, $punc)) {
		$current_w = array_rand($keys);  // 最初の語が終端や区切りなら選びなおす
	}
	$result = array($current_w);

	while (!array_search($current_w, $period)) {
		if (!empty($table[$current_w])) {
			$next_w = $table[$current_w][array_rand($table[$current_w])];
		} else {
			break;
		}
		if ($next_w == false) break;
		array_push($result, $next_w);
		$current_w = $next_w;
	}

	$sentence = implode($result)."\n";  // 配列要素の連結
	return $sentence;
}

echo markov();
?>