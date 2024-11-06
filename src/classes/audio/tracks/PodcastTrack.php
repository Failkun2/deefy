<?php

namespace iutnc\deefy\audio\tracks;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;

class PodcastTrack extends AudioTrack{
    private int $id;

    public function __construct(string $t, string $nF){
        parent::__construct($t, $nF);
    }

    public function __toString(){
        return json_encode($this);
    }

    public function setID(int $id){
        $this->id = $id;
    }

    public function getID(){
        return $this->id;
    }
}