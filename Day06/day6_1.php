<?php
include 'src/input.php';
function format_inputs(string $input){
    echo $input;
    if(preg_match("/(Time:)(?<timeNums>(\d*\s*)*)\n(Distance:)(?<distanceNums>(\d*\s*)*)/", $input, $output) === false){
        return "no Matches";
    }
    foreach(explode(" ", $output['timeNums']) as $nums){
        if(!$nums){
            continue;
        }
        $result['time'][] = $nums;
    }
    foreach(explode(" ", $output['distanceNums']) as $nums){
        if(!$nums){
            continue;
        }
        $result['distance'][] = $nums;
    }
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

$input = new Input("https://adventofcode.com/2023/day/6/input");
$input = $input->get_input();
$input = format_inputs($input);
$total = array_product(findDistance($input));
echo $total;