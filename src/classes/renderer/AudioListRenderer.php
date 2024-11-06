<?php

namespace iutnc\deefy\renderer;

require_once 'vendor/autoload.php';

use \iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;
use \iutnc\deefy\audio\lists\AudioList as AudioList;
use \iutnc\deefy\audio\tracks\AlbumTrack as AlbumTrack;
use \iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;
use \iutnc\deefy\renderer\Renderer as Renderer;
use \iutnc\deefy\renderer\AudioTrackRenderer as AudioTrackRenderer;
use \iutnc\deefy\renderer\AlbumTrackRenderer as AlbumTrackRenderer;
use \iutnc\deefy\renderer\PodcastTrackRenderer as PodcastTrackRenderer;


class AudioListRenderer implements Renderer{

    private AudioList $al;

    public const COMPACT = 1;
    public const LONG = 2;

    public function __construct(AudioList $al){
        $this->al = $al;
    }

    public function render(int $selector){
        $res = "<h2> " . $this->al->__get("nom") . "</h2><br>";
        
        foreach($this->al->__get("audios") as $i => $value){
            if($value instanceof AlbumTrack){
                $atr = new AlbumTrackRenderer($value);
                $res .= $atr->render($selector);
            } elseif($value instanceof PodcastTrack){
                $atr = new PodcastTrackRenderer($value);
                $res .= $atr->render($selector);
            }
        }
        $res .= "<br><p>Numero des pistes : " . $this->al->__get("nbPistes") . ", duree totale : " . $this->al->__get("dureeTotal") . " secondes</p>";
        return $res;
    }
}