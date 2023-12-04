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
function get_games($input){
    $games = explode("\n", $input);
    foreach($games as $line){
        preg_match('/Card\s+(?P<game_id>.*): (?P<win_nums>.*) \| (?P<play_nums>.*)/', $line, $game);
        if(!is_numeric($game['game_id'])){
            continue;
        }
        $id = $game['game_id'];
        $game_nums = $game['play_nums'];
        $win_nums = $game['win_nums'];
        $game_info[$id] = ['win_nums' => $win_nums, 'game_nums' => $game_nums, 'game_count' => 1];
    }
    return $game_info;
}
function play_game($game_info){
    foreach($game_info as $id => $array){
        echo "Game id: {$id} count: {$game_info[$id]['game_count']} \n";
        $win_nums = explode(" ", $array['win_nums']);
        $play_nums = explode(" ", $array['game_nums']);
        $count = 0;
        foreach($play_nums as $num){
            $num = trim($num);
            if(in_array(intval($num), $win_nums)){
                $count++;
            }
        }
        for($i = 1; $i <= $count; $i++){
            if(array_key_exists(intval($id) + $i, $game_info)){
                $game_info[$id + $i]['game_count'] += $game_info[$id]['game_count'];
            }
        }
    }
    return $game_info;
}
$input = get_input("https://adventofcode.com/2023/day/4/input");
$total = 0;
foreach(play_game(get_games($input)) as $game){
    $total += intval($game['game_count']);
}
echo $total;
?>
