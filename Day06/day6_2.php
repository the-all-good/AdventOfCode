<?php
include 'src/input.php';
function format_inputs(string $input){
    echo $input;
    if(preg_match("/(Time:)(?<timeNums>(\d*\s*)*)\n(Distance:)(?<distanceNums>(\d*\s*)*)/", $input, $output) === false){
        return "no Matches";
    }
    $result['time'][] = str_replace(" ", "",$output['timeNums']);
    $result['distance'][] = str_replace(" ", "",$output['distanceNums']);
    return $result;
}

function findDistance(array $input){
    foreach($input['time'] as $key => $time){
        $total[$key] = 0;
        for($count = 1; $count < $time; $count++){
            if($count * ($time - $count) > $input['distance'][$key]){
                $total[$key]++;
            }
        }
    }
    return $total;
}

$input = new Input;
$input = $input->get_input("https://adventofcode.com/2023/day/6/input");
$input = format_inputs($input);
$total = array_product(findDistance($input));
print_r($total);