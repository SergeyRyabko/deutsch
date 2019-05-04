<?php

class IO
{
  protected $handle;

  public function __construct()
  {
    $this->handle = fopen ("php://stdin","r");
  }

  function input()
  {
    $command = trim(fgets($this->handle));
    if ($command) {
      die;
    }
  }

  function output($input, $await_response = true)
  {
    $input = trim($input);
    echo $input . PHP_EOL;
    $await_response && $this->input($this->handle);
  }
}

array_shift($argv);

$lines = [];
foreach ($argv as $path) {

  if (!file_exists($path)) {
    continue;
  }

  if (!$contents = file_get_contents($path)) {
    continue;
  }

  $lines = array_merge($lines, explode(PHP_EOL, trim($contents)));
}

if (!$lines) {
  echo 'No lines to process' . PHP_EOL;
  die;
}

$lines = array_fill_keys($lines, 0);
$current_iteration = 0;

$IO = new IO();

$last_key = '';
while (true) {
  system('clear');

  $iteration = min($lines);
  if ($iteration !== $current_iteration) {
    $current_iteration = $iteration;
    $IO->output('Iteration: ' . ($iteration + 1), false);
    usleep(500000);

    continue;
  }

  $keys = array_intersect($lines, [$iteration]);
  $keys = array_diff_key($keys, [$last_key => '']);

  $key = array_rand($keys);

  list($deutsch, $russian) = explode('::', $key);

  $IO->output($russian);
  $IO->output($deutsch);

  $lines[$key]++;
  $last_key = $key;
}
