<?php

array_shift($argv);

$lines = [];
foreach ($argv as $path) {
  if (!$contents = file_get_contents($path)) {
    continue;
  }

  $lines = array_merge($lines, explode(PHP_EOL, trim($contents)));
}

$lines = array_fill_keys($lines, 0);
$handle = fopen ("php://stdin","r");
$last_key = '';
while (true) {
  system('clear');
  $keys = array_intersect($lines, [min($lines)]);
  $keys = array_diff_key($keys, [$last_key => '']);

  $key = array_rand($keys);

  list($deutch, $russian) = explode('::', $key);

  echo trim($russian);
  fgets($handle);

  echo trim($deutch);
  fgets($handle);

  $lines[$key]++;
  $last_key = $key;
}
