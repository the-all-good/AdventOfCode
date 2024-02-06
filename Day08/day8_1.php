<?php
include "src/input.php";

function sort_input(array $input){
    $sorted = [];
    foreach($input as $line){
        preg_match("/(?<key>.*)\s=\s\((?<left>.*),\s(?<right>.*)\)/", $line, $output);
        $sorted[$output['key']] = [
            'left' => $output['left'],
            'right' => $output['right']
        ];
    }
    return $sorted;
}

function follow_mapping(array $directions, array $map){
    $count = 0;
    $current_location = "";
    while($current_location !== "ZZZ"){
        foreach($directions as $l_or_r){
            if(!isset($current_location)){
                if($l_or_r === 'L'){
                    $current_location = $map["AAA"]['left'];
                }else{
                    $current_location = $map["AAA"]['right'];
                }
            }
            if($l_or_r === 'L'){
                $current_location = $map[$current_location]['left'];
            }else{
                $current_location = $map[$current_location]['right'];
            }
            $count++;
            
        }
    }
    return $count;
}

$input = new Input("https://adventofcode.com/2023/day/8/input");
$input = $input->split_by_newlines();
$directions = str_split($input[0]);
unset($input[0]);
$sorted_input = sort_input($input);
echo follow_mapping($directions,$sorted_input);