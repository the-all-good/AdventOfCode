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
function check_cubes($line){
    $max_cubes = [
        "red" => 12,
        "blue" => 14,
        "green" => 13
    ];
    $split = explode(":", $line);
    $id = explode(' ', $split[0])[1];
    $shown_hands = explode(';', $split[1]);
    foreach($shown_hands as $game){
        $rounds = explode(', ', $game);
        foreach($rounds as $round){
            $colours = explode(', ', $round);
            foreach($colours as $colour){
                $colour = trim($colour);
                $shade = trim(explode(" ", $colour)[1]);
                $count = trim(explode(" ", $colour)[0]);
                if($count > $max_cubes[$shade]){
                    return 0;
                }
            }
        }
    }
    return $id;
}

$total = 0;
foreach(explode("\n", get_input("https://adventofcode.com/2023/day/2/input")) as $line){
    $total += check_cubes($line);
}
echo $total . "\n";
?>