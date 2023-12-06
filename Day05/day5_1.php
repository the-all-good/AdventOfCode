<?php
function get_input($url){
    $cookie = "session=" . parse_ini_file('.env')['SESSION'];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function create_map($input){
    $lines = explode("\n", $input);
    $count = 0;
    foreach($lines as $line){
        if(preg_match("/\s*(?P<destination>.+)\s(?P<source>\d*)\s(?P<range>.+)/", $line, $output) === false){
            continue;
        };
        if(!isset($output['range'])){
            continue;
        }
        $range[$count]['min'] = $output['source'];
        $range[$count]['max'] = intval($output['source']) + intval($output['range']);
        $range[$count]['start'] = $output['destination'] - $output['source'];
        $count++;
    }
    return $range;
}
function find_step($array, $ints){
    $answers = [];
    foreach($ints as $int){
        unset($answer);
        foreach($array as $map){
            if((intval($int) > intval($map['min'])) && (intval($int) < intval($map['max']))){
                $answer = $int + intval($map['start']);
            }
        }
        if(!isset($answer)){
            $answer = $int;
        }
        $answers[] = $answer;
    }
    return $answers;
}
$input = get_input("https://adventofcode.com/2023/day/5/input");
$inputs = explode("\n\n",$input);
$seed_soil =  create_map($inputs[1]);
$soil_fert = create_map($inputs[2]);
$fert_water = create_map($inputs[3]);
$water_light = create_map($inputs[4]);
$light_temp = create_map($inputs[5]);
$temp_humid = create_map($inputs[6]);
$humid_location = create_map($inputs[7]);

$seeds = explode(" ", $inputs[0]);
    $step1 = find_step($seed_soil, $seeds);
    $step2 = find_step($soil_fert, $step1);
    $step3 = find_step($fert_water, $step2);
    $step4 = find_step($water_light, $step3);
    $step5 = find_step($light_temp, $step4);
    $step6 = find_step($temp_humid, $step5);
    $step7 = find_step($humid_location, $step6);
    print_r($step7);
    echo min($step7);
?>