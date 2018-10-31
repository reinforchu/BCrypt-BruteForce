<?php
set_time_limit(30000);
include_once(dirname(__FILE__) .'/../include/permutations.php');

$hash = '$2y$10$opO4l.2s5Eh9AEuObS.SYu8weSMYEnr9OGm89QTYZGHq9tqs7mTU6';
$char_set = 'abcdefghijklmnopqrstuvwxyz';
$shuffled = str_shuffle($char_set);
// $shuffled = $char_set;
$char_array = str_split($shuffled);
$start_time = microtime(true);

for ($i = 1; $i <= strlen($shuffled); $i++) {
  $generator = genCombinations($char_array, $i);
  foreach ($generator as $value) {
    if (password_verify(join($value), $hash)) {
      $end_time = microtime(true);
      echo "Password is " . join($value) . "\n";
      echo "\n".'Processing is ' . round($end_time-$start_time). " seconds\n";
			exit();
    }
    echo "NG: " . implode($value) . "\n";
  }
}