<?php

require_once 'spyc.php';

$data = array();
if($files = glob('*.yaml')) {
	foreach($files as $filename) {
		$data[basename($filename, '.yaml')] = Spyc::YAMLLoad($filename);
	}
}
else die("no sources");

$x = array_keys($data);
function int2xep($n){return sprintf('xep-%04d', $n);}
$y = array_map('int2xep', range(1,280));

foreach($data as $cols) {
	$y = array_merge($y, array_keys($cols));
}
$y = array_unique($y);
sort($y);

echo "<h1>Probably inaccurate feature comparison table</h1>";
echo "<table>\n";
echo "<thead>\n";
echo "<tr>\n";
echo "<th>feature\server</th>\n";
foreach($x as $row) {
	echo "<th>$row</th>\n";
}
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
foreach($y as $col) {
	echo "<tr>\n";
	echo "<th>$col</th>\n";
	foreach($x as $row) {
		if(isset($data[$row][$col])) {
			$cell = $data[$row][$col];
			$comment = "";
			if(is_array($cell)) {
				list($ver, $comment) = $cell;
				$cell = $ver;
			}
			printf("<td bgcolor='green'>%s $comment</td>\n", (is_bool($cell)?($cell?"yes":"no"):$cell));
		}
		else
			echo "<td bgcolor='red'>no</td>\n";
	}
	echo "</tr>\n";
}
echo "</tbody>\n";
echo "</table>\n";

