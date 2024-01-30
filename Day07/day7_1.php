<?php
include 'src/input.php'; 

// Sort hands into groups (4 of a kind, 3 of a kind etc)
function sort_input(Array $input){
    $results = [
        "5 of a kind" => [],
        "4 of a kind" => [],
        "Full house" => [],
        "3 of a kind" => [],
        "2 pair" => [],
        "1 pair" => [],
        "High card" => [],
        ];
    foreach($input as $game){
        $game = explode(" ", $game);
        $hand = $game[0];
        $bet = $game[1];
        if(is_string($hand)){
            $cards = array_count_values(str_split($hand));
        }
        if(array_search(5, $cards)){
            $results['5 of a kind'][] = ['hand' => $hand, 'bet' =>$bet];
        }elseif(array_search(4, $cards)){
            $results['4 of a kind'][] = ['hand' => $hand, 'bet' =>$bet];
        }elseif(array_search(3, $cards) && array_search(2, $cards)){
            $results['Full house'][] = ['hand' => $hand, 'bet' =>$bet];
        }elseif(array_search(3, $cards)){
            $results['3 of a kind'][] = ['hand' => $hand, 'bet' =>$bet];
        }elseif(array_search(2, $cards) && (count($cards) === 3)){
            $results['2 pair'][] = ['hand' => $hand, 'bet' =>$bet];
        }elseif(array_search(2, $cards)){
            $results['1 pair'][] = ['hand' => $hand, 'bet' =>$bet];
        }else{
            $results['High card'][] = ['hand' => $hand, 'bet' =>$bet];
        }
    }
    return $results;
}
// Sort groups based on card strength
function compare_hands($hand1, $hand2){
    $card_value = [
        'A' => 14,
        'K' => 13,
        'Q' => 12,
        'J' => 11,
        'T' => 10,
        '9' => 9,
        '8' => 8,
        '7' => 7,
        '6' => 6,
        '5' => 5,
        '4' => 4,
        '3' => 3,
        '2' => 2
    ];
    $hand1 = str_split($hand1);
    $hand2 = str_split($hand2);
    for($i = 0; $i < count($hand1); $i++){
        if($card_value[$hand1[$i]] > $card_value[$hand2[$i]]){
            return true;
        }
        if($card_value[$hand1[$i]] < $card_value[$hand2[$i]]){
            return false;
        }
    }
}
function sort_strength(array $input){
    $chunk = 0;
    foreach($input as $hands){
        foreach($hands as $hand){
            $count = $chunk;
            for($i = 0; $i < count($hands); $i++){
                if($hand['hand'] === $hands[$i]['hand']){
                    continue;
                }
                if(!compare_hands($hand['hand'], $hands[$i]['hand'])){
                    $count++;
                }
            }
            $result[$count] = $hand;
        }
        $chunk += count($hands);
    }
    return $result;
}
// Calculate prize totals.
function calculate_total(array $input, $max){
    $count = 0;
    for($i = 0; $i < $max; $i++){
        $multiplier = $max - $i;
        // echo "Bet: {$input[$i]['bet']} Max: {$multiplier}\n";
        $count += $input[$i]['bet'] * $multiplier;
    }    
    return $count;
}

$input = new Input("https://adventofcode.com/2023/day/7/input");
$input = $input->split_by_newlines();
$sorted_input = sort_input($input);
$sorted_list = sort_strength($sorted_input);
$total = calculate_total($sorted_list, max(array_keys($sorted_list)));

echo $total;