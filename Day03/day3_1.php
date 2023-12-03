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
function locate_symbols($grid){
    $symbol_locations = [];
    $y_axis = 0;
    foreach($grid as $lines){
        foreach($lines as $key => $character){
            if(!is_numeric($character) && $character !== "."){
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
    // Grid                 
    // [136] => Array       
    //     (
    //         [0] => .
    //         [1] => .
    //         [2] => .
    //         [3] => .
    //         [4] => 7
    //         [5] => 1
    // Symbol coord
    // [137] => Array
    //     (
    //         [0] => 46
    //         [1] => 64
    //         [2] => 132
    //     )
    $number_locations = [];
    foreach($symbol_coordinates as $y_axis => $array){
        foreach($array as $location){
            if(is_numeric($grid[$y_axis][$location])){
                $number_locations[$y_axis][] = $grid[$y_axis][$location];
            }
            if(is_numeric($grid[$y_axis + 1][$location])){
                $number_locations[$y_axis][] = $grid[$y_axis + 1][$location];
            }
            if(is_numeric($grid[$y_axis][$location + 1])){
                $number_locations[$y_axis][] = $grid[$y_axis][$location + 1];
            }
            if(is_numeric($grid[$y_axis + 1][$location + 1])){
                $number_locations[$y_axis][] = $grid[$y_axis + 1][$location + 1];
            }
            if(is_numeric($grid[$y_axis + 1][$location - 1])){
                $number_locations[$y_axis][] = $grid[$y_axis + 1][$location - 1];
            }
            if(is_numeric($grid[$y_axis - 1][$location])){
                $number_locations[$y_axis][] = $grid[$y_axis - 1][$location];
            }
            if(is_numeric($grid[$y_axis][$location - 1])){
                $number_locations[$y_axis][] = $grid[$y_axis][$location - 1];
            }
            if(is_numeric($grid[$y_axis - 1][$location - 1])){
                $number_locations[$y_axis][] = $grid[$y_axis - 1][$location - 1];
            }
            if(is_numeric($grid[$y_axis - 1][$location + 1])){
                $number_locations[$y_axis][] = $grid[$y_axis - 1][$location + 1];
            }
        }
    }
    return $number_locations;
}

$input = get_input("https://adventofcode.com/2023/day/3/input");
$grid = create_grid($input);
$symbols = locate_symbols($grid);
print_r(find_number_allies($grid, $symbols));
// print_r($grid);