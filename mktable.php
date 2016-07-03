<?php
$message_file = yaml_parse_file(__DIR__ . "/message_main.yml");
$messages = array();
foreach ($message_file as $ary) {
	$messages = array_merge($messages, $ary);
}

// テーブル作成
$table = array();
foreach ($messages as $message) {
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

yaml_emit_file(__DIR__ . "/table.yml", $table, YAML_UTF8_ENCODING);

?>