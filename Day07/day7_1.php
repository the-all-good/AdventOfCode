<?php
include 'src/input.php'; 
// Sort hands into groups (4 of a kind, 3 of a kind etc)

// Sort groups based on card strength

// Calculate prize totals.


$input = new Input("https://adventofcode.com/2023/day/7/input");
$input = $input->split_by_newlines();
print_r($input);