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
function get_points($line){
    preg_match('/Card (?P<game_id>.*): (?P<win_nums>.*) \| (?P<play_nums>.*)/', $line, $game);
    $win_nums = explode(" ", $game['win_nums']);
    $play_nums = explode(" ", $game['play_nums']);
    $count = 0;
    foreach($play_nums as $num){
        if(!is_numeric($game['game_id'])){
            continue;
        }
        if(in_array(intval($num), $win_nums)){
            $count++;
        }
    }
    if($count > 2){
        $result = pow(2, $count -1);
    }else{
        $result = $count;
    }
    echo "Card is {$game['game_id']} Count is {$count}, Result is {$result} \n";
    return $result;
}
$input = get_input("https://adventofcode.com/2023/day/4/input");
$games = explode("\n", $input);
$total = 0;
foreach($games as $game){
    $points = get_points($game);
    $total += $points;
}
echo $total;
?>