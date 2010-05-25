<!DOCTYPE html>
<html lang="en">
<head>
<title>PIFT</title>
<meta charset="utf-8">
</head>
<body>
<h1>Probably inaccurate feature comparison table</h1>
<?php

require_once 'spyc.php';

$data = array();
if($files = glob('*.yaml')) {
	foreach($files as $filename) {
		$data[basename($filename, '.yaml')] = Spyc::YAMLLoad($filename);
	}
}
else die("no sources");
#echo '<pre>'; highlight_string(sprintf("<?php\n\n\$data = %s;\n", var_export($data,1))); exit;

$x = array_keys($data);
#function int2xep($n){return sprintf('xep-%04d', $n);}
#$y = array_map('int2xep', range(1,280));
$y = array();

foreach($data as $cols) {
	$y = array_merge($y, array_keys($cols));
}
$y = array_unique($y);
sort($y);

echo "<table>\n<thead>\n<tr>\n<th>feature\server</th>\n";
foreach($x as $row) {
	echo "<th>$row</th>\n";
}
echo "</tr>\n</thead>\n<tbody>\n";
$colors = array('yes' => '#cfc', 'no' => '#fcc', 'N/A' => '#ffa');
foreach($y as $col) {
	echo "<tr>\n<th>$col</th>\n";
	foreach($x as $row) {
		$cell = false;
		if(isset($data[$row][$col]))
			$cell = $data[$row][$col];
		$comment = "";
		if(is_array($cell)) {
			list($ver, $comment) = $cell;
			$cell = $ver;
		}
		$color = $colors[is_bool($cell)?($cell?'yes':'no'):(is_null($cell)?'N/A':'yes')];
		$cell = is_bool($cell)?($cell?'yes':'no'):(is_null($cell)?'N/A':$cell);
		echo "<td bgcolor=\"$color\"><strong>$cell</strong> $comment</td>";
	}
	echo "</tr>\n";
}
echo "</tbody>\n</table>\n";
?>
</body>
</html>

