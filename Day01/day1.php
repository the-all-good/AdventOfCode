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

function match_num($line){
    $matches = [
        'one'=> 1,
        'two'=> 2,
        'three'=> 3,
        'four'=> 4,
        'five'=> 5,
        'six'=> 6,
        'seven'=> 7,
        'eight'=> 8,
        'nine'=> 9,
        'zero'=> 0];
    preg_match("/([0-9]|(zero)|(one)|(two)|(three)|(four)|(five)|(six)|(seven)|(eight)|(nine)){1}/", $line, $first_num);
    preg_match("/([0-9]|(eroz)|(eno)|(owt)|(eerht)|(ruof)|(evif)|(xis)|(neves)|(thgie)|(enin)){1}/", strrev($line), $last_num);
    if(!is_int($last_num[0])){
        $last_num[0] = strrev($last_num[0]); 
    }
    if(array_key_exists($first_num[0], $matches)){
        $first_num = $matches[$first_num[0]];
    }else{
        $first_num = $first_num[0];
    }
    if(array_key_exists($last_num[0], $matches)){
        $last_num = $matches[$last_num[0]];
    }else{
        $last_num = $last_num[0];
    }
    $num = "{$first_num}{$last_num}";
    return intval($num);
}
function level_1(){
    $output = get_input("https://adventofcode.com/2023/day/1/input");
    $words = explode("\n", $output);
    $total = 0;
    foreach($words as $line){
        preg_match("/(?!^(a-Z))[\d]{1}/", $line, $first_num);
        preg_match("/(?!^(a-Z))[\d]{1}/", strrev($line), $last_num);
        $num = $first_num[0] . $last_num[0];
        $total += intval($num);
    }
    return $total;
}
function level_2(){
    $output = get_input("https://adventofcode.com/2023/day/1/input");
    $words = explode("\n", $output);
    $total = 0;
    foreach($words as $line){
        $num = match_num($line);
        $total += $num;
    }
    return $total;
}
echo level_1() . "\n" . level_2() . "\n";
?>