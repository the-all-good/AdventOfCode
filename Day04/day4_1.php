<?php
include 'src/input.php';
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
$input = new Input("https://adventofcode.com/2023/day/4/input");
$input = $input->get_input();
$games = explode("\n", $input);
$total = 0;
foreach($games as $game){
    $points = get_points($game);
    $total += $points;
}
echo $total;
?>