<?php
// https://stackoverflow.com/questions/36612560/efficient-php-algorithm-to-generate-all-combinations-permutations-of-inputs
// Thanks jimmyd_au! https://stackoverflow.com/users/6202154/jimmyd-au
function genCombinations($values,$count=0) {
  // Figure out how many combinations are possible:
  $permCount=pow(count($values),$count);

  // Iterate and yield:
  for($i = 0; $i < $permCount; $i++)
    yield getCombination($values, $count, $i);
}

// State-based way of generating combinations:
function getCombination($values, $count, $index) {
  $result=array();
  for($i = 0; $i < $count; $i++) {
    // Figure out where in the array to start from, given the external state and the internal loop state
    $pos = $index % count($values);

    // Append and continue
    $result[] = $values[$pos];
    $index = ($index-$pos)/count($values);;
  }
  return $result;
}