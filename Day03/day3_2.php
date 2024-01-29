<?php
include 'src/input.php';
function locate_symbols($grid){
    $symbol_locations = [];
    $y_axis = 0;
    foreach($grid as $lines){
        foreach($lines as $key => $character){
            if($character == "*"){
                $symbol_locations[$y_axis][] = $key;
            }
        }
        $y_axis += 1;
    }
    return $symbol_locations;
}
function create_grid($input){
    $grid = [];
    $y_axis = 0;
    $lines = explode("\n", $input);
    foreach($lines as $line){
        $x_axis = 0;
        $characters = str_split($line);
        foreach($characters as $character){
            $grid[$y_axis][$x_axis] = $character;
            $x_axis += 1;
        }
        $y_axis += 1;
    }
    return $grid;
}
function find_number_allies($grid, $symbol_coordinates){
    $total = 0;
    foreach($symbol_coordinates as $y_axis => $array){
        foreach($array as $spot => $location){
            $matches = 0;
            $nums = [];
            echo "* is located at {$grid[$y_axis][$spot]} \n";
            for($i = -1; $i <= 1; $i++){
                if(is_numeric($grid[$y_axis -1][$location + 1]) && is_numeric($grid[$y_axis -1][$location]) && is_numeric($grid[$y_axis -1][$location -1])){
                    $nums[$y_axis -1][$location -1] = "start";
                    $matches += 1;
                }else{
                    if(is_numeric($grid[$y_axis -1][$location + $i]) && !is_numeric($grid[$y_axis -1][$location + $i - 1])){
                        $nums[$y_axis -1][$location + $i] = "start";
                        $matches += 1;
                    }
                    if(is_numeric($grid[$y_axis -1][$location + $i]) && !is_numeric($grid[$y_axis -1][$location + $i + 1]) && is_null($nums[$y_axis -1][$location + $i -1])){
                        $nums[$y_axis -1][$location + $i] = "end";
                        $matches += 1;
                    }   
                }
                if(is_numeric($grid[$y_axis +1][$location + 1]) && is_numeric($grid[$y_axis +1][$location]) && is_numeric($grid[$y_axis +1][$location -1])){
                    $nums[$y_axis +1][$location -1] = "start";
                    $matches += 1;
                }else{
                    if(is_numeric($grid[$y_axis +1][$location + $i]) && !is_numeric($grid[$y_axis +1][$location + $i - 1])){
                        $nums[$y_axis +1][$location + $i] = "start";
                        $matches += 1;
                    }
                    if(is_numeric($grid[$y_axis +1][$location + $i]) && !is_numeric($grid[$y_axis +1][$location + $i + 1]) && is_null($nums[$y_axis +1][$location + $i -1])){
                        $nums[$y_axis +1][$location + $i] = "end";
                        $matches += 1;
                    }
                }
                if(is_numeric($grid[$y_axis][$location + $i]) && !is_numeric($grid[$y_axis][$location + $i - 1])){
                    $nums[$y_axis][$location + $i] = "start";
                    $matches += 1;
                }
                if(is_numeric($grid[$y_axis][$location + $i]) && !is_numeric($grid[$y_axis][$location + $i + 1])){
                    $nums[$y_axis][$location + $i] = "end";
                    $matches += 1;
                }
            }
            if($matches >= 2){
                $result = [];
                $count = 0;
                foreach($nums as $y_align => $array){
                    foreach($array as $x_align => $directions){
                        $len = 0;
                        $number = '';
                        if($directions === "end"){
                            while(is_numeric($grid[$y_align][$x_align - $len])){
                                $number = $number . $grid[$y_align][$x_align - $len];
                                $len++;
                            }
                            $result[$count] = strrev($number);
                            $count++;
                        }
                        if($directions === "start"){
                            while(is_numeric($grid[$y_align][$x_align + $len])){
                                $number = $number . $grid[$y_align][$x_align + $len];
                                $len++;
                            }
                            $result[$count] = $number;
                            $count++;
                        }
                    }
                }
                $sum = intval($result[0]) * intval($result[1]);
                $total = $total + $sum;
                print_r($result);
            }
        }
    }
    return $total;
}

// function complete_num($grid, $coordinate){
//     foreach($coordinate)
// }

$input = new Input("https://adventofcode.com/2023/day/3/input");
$input = $input->get_input();
$grid = create_grid($input);
$symbols = locate_symbols($grid);
print_r(find_number_allies($grid, $symbols));
// print_r($symbols);
// echo $input;