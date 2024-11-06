<?php

namespace iutnc\deefy\audio\lists;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\lists\AudioList as AudioList;

class Album extends AudioList{
    private string $artiste;
    private string $annee;

    public function __construct(string $n, array $a){
        parent::__construct($n, $a);
    }

    public function __set(string $name, mixed $value){
        switch($name){
            case "artiste":
                $this->artiste = $value;
                break;
            case "annee":
                $this->annee = $value;
                break;
            default:
                throw new InvalidPropertyNameException();
        }
    }
}