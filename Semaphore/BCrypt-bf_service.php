<?php
set_time_limit(30000);
include_once(dirname(__FILE__) .'/../include/permutations.php');

$shmid = shmop_open(8686, 'c', 0755, 71);
shmop_delete($shmid);
shmop_close($shmid);
$shmid = shmop_open(8686, 'c', 0755, 71);

$hash = '$2y$10$opO4l.2s5Eh9AEuObS.SYu8weSMYEnr9OGm89QTYZGHq9tqs7mTU6';
$char_set = 'abcdefghijklmnopqrstuvwxyz';
$shuffled = str_shuffle($char_set);
// $shuffled = $char_set;
$char_array = str_split($shuffled);
$start_time = microtime(true);

for ($i = 1; $i <= strlen($shuffled); $i++) {
  $generator = genCombinations($char_array, $i);
  foreach ($generator as $value) {
    $passwd = shmop_read($shmid, 0, 71);
    $passwd = str_replace("\0", "", $passwd);
    if ($passwd === "") {
      echo "[CHECK] " . implode($value) . "\n";
      exec('php ' . dirname(__FILE__) .'/BCrypt-bf_worker.php ' . "'{$hash}' '" . join($value) . "'"  . ' > /dev/null &');
    } else {
      $end_time = microtime(true);
      echo "[FOUND] " . shmop_read($shmid, 0, 71) . "\n";
      echo 'Processing is ' . round($end_time - $start_time). " seconds\n";
      shmop_delete($shmid);
      shmop_close($shmid);
      exit();
    }
  }
}