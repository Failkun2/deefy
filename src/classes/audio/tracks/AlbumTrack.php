<?php

namespace iutnc\deefy\audio\tracks;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;

class AlbumTrack extends AudioTrack{
    private string $nomAlbum;
    private int $numPiste;

    public function __construct(string $t, string $nF, string $nA, int $nP){
        parent::__construct($t, $nF);
        $this->nomAlbum = $nA;
        $this->numPiste = $nP;
    }

    public function __toString(){
        return json_encode($this);
    }

    public function __get(string $name){
        switch($name){
            case "nomAlbum":
                return $this->nomAlbum;
            case "numPiste":
                return $this->numPiste;
            default:
                return parent::__get($name);
                break;
        }
    }
}