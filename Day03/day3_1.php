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
function locate_numbers($grid){
    $symbol_locations = [];
    $y_axis = 0;
    foreach($grid as $lines){
        foreach($lines as $key => $character){
            if(is_numeric($character) && !is_numeric($grid[$y_axis][$key -1])){
                $len = 0;
                while(is_numeric($grid[$y_axis][$key + $len])){
                    $len += 1;
                }
                $symbol_locations[$y_axis][$key] = $len;
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
    $number_locations = [];
    foreach($symbol_coordinates as $y_axis => $array){
        foreach($array as $location => $len){
            for($i = -1; $i <= $len; $i++){
                $num = '';
                for($x = 0; $x < $len; $x++){
                    $num = $num . $grid[$y_axis][$location + $x];
                }
                $above = $grid[$y_axis -1][$location + $i];
                $mid = $grid[$y_axis][$location + $i];
                $below = $grid[$y_axis +1][$location + $i];

               if(!is_numeric($above) && $above !== "." && !is_null($above)){
                    $number_locations[] = intval($num);
                    break;
                }
                if(!is_numeric($mid) && $mid !== "." && !empty($mid) && !is_null($mid)){
                    $number_locations[] = intval($num);
                    break;
                }
                if(!is_numeric($below) && $below !== "." && !empty($below) && !is_null($below)){
                    $number_locations[] = intval($num);
                    break;
                }
            }
        }
    }
    $total = 0;
    foreach($number_locations as $num){
        $total += $num;
    }
    return $total;
}


$input = get_input("https://adventofcode.com/2023/day/3/input");
$grid = create_grid($input);
$numbers = locate_numbers($grid);
print_r(find_number_allies($grid, $numbers));