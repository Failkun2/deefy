<?php

namespace iutnc\deefy\renderer;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;
use \iutnc\deefy\renderer\Renderer as Renderer;
use \iutnc\deefy\renderer\AudioTrackRenderer as AudioTrackRenderer;

class PodcastTrackRenderer extends AudioTrackRenderer implements Renderer{

    public function __construct(PodcastTrack $pt){
        parent::__construct($pt);
    }

    public function renderCompact(){
        return "<p>" . $this->at->__get("titre") . " - by " . " (" . $this->at->__get("annee") . ")</p><br><audio controls src='audio/" . $this->at->__get("nomFichier") . "'></audio>";
    }

    public function renderLong(){
        return "<p>" . $this->at->__get("titre") . " (" . $this->at->__get("annee") . ") - " . $this->at->__get("duree") . "s, " . $this->at->__get("genre") . "</p><br><audio controls src='audio/" . $this->at->__get("nomFichier") . "'></audio>";
    }

    //" - by " . $this->at->__get("artiste") . 
}