<?php

namespace iutnc\deefy\audio\lists;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\lists\AudioList as AudioList;
use \iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;

class Playlist extends AudioList{

    private int $id;

    public function __construct(string $n, array $a = []){
        parent::__construct($n, $a);
    }
    
    public function ajouterAudio(AudioTrack $at){
        if ($at instanceof AudioTrack){
            $this->nbPistes++;
            $this->dureeTotal += $at->__get("duree");
            $this->audios[] = $at;
        } 
    }

    public function supprimerAudio(int $indice){
        $this->nbPistes--;
        $this->duree -= $this->audios[$indice]->__get("duree");
        unset($this->audios[$indice]);
    }

    public function ajouterListeAudio(array $liste){
        $liste = array_unique($liste);
        foreach($liste as $i => $value){
            self::ajouterAudio($value);
        }
        $this->nbPistes += count($liste);
        $this->duree += parent::calculerDuree($liste);
    }

    public function setID(int $id){
        $this->id = $id;
    }

    public function getID(){
        return $this->id;
    }
}