<?php

namespace iutnc\deefy\audio\tracks;
require_once 'vendor/autoload.php';
use \iutnc\deefy\exception\InvalidPropertyNameException as InvalidPropertyNameException;
use \iutnc\deefy\exception\InvalidPropertyValueException as InvalidPropertyValueException;
use getID3;


class AudioTrack{
    protected string $titre;
    protected string $artiste;
    protected string $annee;
    protected string $genre;
    protected int $duree;
    protected string $nomFichier;

    public function __construct(string $t, string $nf){
        $this->titre = $t;
        $this->nomFichier = $nf;
        self::getAudioDuration("audio/" . $nf);
    }

    public function __get(string $name){
        switch($name){
            case "titre":
                return $this->titre;
            case "artiste":
                return $this->artiste;
            case "annee":
                return $this->annee;
            case "genre":
                return $this->genre;
            case "duree":
                return $this->duree;
            case "nomFichier":
                return $this->nomFichier;
            default:
                throw new InvalidPropertyNameException();
                break;
        }
    }

    public function __set(string $name, mixed $value){
        switch($name){
            case "titre":
                break;
            case "artiste":
                $this->artiste = $value;
                break;
            case "annee":
                $this->annee = $value;
                break;
            case "genre":
                $this->genre = $value;
                break;
            case "duree":
                if($value < 0){
                    throw new InvalidPropertyValueException();
                }
                $this->duree = $value;
                break;
            case "nomFichier":
                break;
            default:
                throw new InvalidPropertyNameException();
        }
    }

    public function getAudioDuration(string $filePath) {
        if (!file_exists($filePath)) {
            return null; 
        }
    
        $getID3 = new getID3;
    
        $fileInfo = $getID3->analyze($filePath);
    
        if (isset($fileInfo['playtime_seconds'])) {
            self::__set("duree", round($fileInfo['playtime_seconds']));
        }
    
        return 0; 
    }
}