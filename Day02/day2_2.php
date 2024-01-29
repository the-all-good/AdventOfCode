<?php
include 'src/input.php';
function check_cubes($line){
    $max_cubes = [
        "red" => 12,
        "blue" => 14,
        "green" => 13
    ];
    $Lowest_cubes = [
        "red" => 0,
        "blue" => 0,
        "green" => 0
    ];
    $split = explode(":", $line);
    $id = explode(' ', $split[0])[1];
    $shown_hands = explode(';', $split[1]);
    foreach($shown_hands as $game){
        $rounds = explode(', ', $game);
        // var_dump($rounds);
        foreach($rounds as $round){
            $colours = explode(', ', $round);
            foreach($colours as $colour){
                $colour = trim($colour);
                $shade = trim(explode(" ", $colour)[1]);
                $count = trim(explode(" ", $colour)[0]);
                // echo "Colour: {$shade} Count:{$count} \n";
                // if($count > $max_cubes[$shade]){
                //     return 0;
                // }
                if($count > $Lowest_cubes[$shade]){
                    $Lowest_cubes[$shade] = $count;
                }
            }
        }
    }
    $total = intval($Lowest_cubes["red"]) * intval($Lowest_cubes["blue"]) * intval($Lowest_cubes["green"]);
    echo "ID:{$id} Total:{$total} \n";
    return $total;
}

$total = 0;
// check_cubes("Game 95: 13 blue, 4 green, 3 red; 15 green, 3 red, 2 blue; 16 green, 8 blue, 2 red");
$input = new Input("https://adventofcode.com/2023/day/2/input");
foreach(explode("\n", $input->get_input()) as $line){
    $total += check_cubes($line);
}
echo $total . "\n";
?>