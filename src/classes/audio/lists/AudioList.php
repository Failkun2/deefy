<?php

namespace iutnc\deefy\audio\lists;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;

class AudioList{
    protected string $nom;
    protected int $nbPistes;
    protected int $dureeTotal;
    protected array $audios;

    public function __construct(string $n, array $a = []){
        $this->nom = $n;
        $this->nbPistes = count($a);
        $this->audios = $a;
        $this->dureeTotal = self::calculerDuree($a);
    }

    public function calculerDuree(array $a){
    if($a = []){
            return 0;
        } else {
            $res = 0;
            foreach ($this->audios as $i => $value){
                $res += $value->__get("duree");
            }
            return $res;
        }
    }

    public function __get(string $name){
        switch($name){
            case "nom":
                return $this->nom;
            case "nbPistes":
                return $this->nbPistes;
            case "dureeTotal":
                return $this->dureeTotal;
            case "audios":
                return $this->audios;
            default:
                //throw new InvalidPropertyNameException();
                break;
        }
    }
}