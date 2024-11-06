<?php

namespace iutnc\deefy\renderer;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\AlbumTrack as AlbumTrack;
use \iutnc\deefy\renderer\Renderer as Renderer;
use \iutnc\deefy\renderer\AudioTrackRenderer as AudioTrackRenderer;

class AlbumTrackRenderer extends AudioTrackRenderer implements Renderer{

    public function __construct(AlbumTrack $at){
        parent::__construct($at);
    }

    public function renderCompact(){
        return "<p>" . $this->at->__get("titre") . " - by " . $this->at->__get("artiste") . " (From " . $this->at->__get("nomAlbum") . ")</p><br><audio controls src='audio/" . $this->at->__get("nomFichier") . "'></audio>";
    }

    public function renderLong(){
        return "<p>" . $this->at->__get("numPiste") . ". " . $this->at->__get("titre") . " - by " . $this->at->__get("artiste") . " (From " . $this->at->__get("nomAlbum") . ", " . $this->at->__get("annee") . ") - " . $this->at->__get("duree") . "s, " . $this->at->__get("genre") . "</p><br><audio controls src='audio/" . $this->at->__get("nomFichier") . "'></audio>";
    }
}