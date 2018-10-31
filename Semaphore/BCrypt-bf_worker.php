<?php
if (!isset($argv[1]) || !isset($argv[2])) {
  echo "[ERROR] Missing argument\n";
  exit();
}
if (password_verify($argv[2], $argv[1])) {
  $shmid = shmop_open(8686, 'c', 0755, 71);
  shmop_write($shmid, $argv[2], 0);
  echo "[FOUND] {$argv[2]}\n";
} else {
  echo "[MISSMATCH] {$argv[2]}\n";
}