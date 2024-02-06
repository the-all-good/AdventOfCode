<?php

class Input{
    public $url;
    public $output;
    function __construct($url){
        $this->url = $url;
        $cookie = "session=" . parse_ini_file('.env')['SESSION'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $this->output = $output;
    }
    public function get_input(){
        return $this->output;
    }
    public function split_by_newlines(){
        $split = explode("\n", $this->get_input());
        foreach($split as $key => $line){
            if($line === ""){
                unset($split[$key]);
            }
        }
        return $split;
    }
}