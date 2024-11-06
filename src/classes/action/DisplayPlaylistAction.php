<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use \iutnc\deefy\audio\lists\Playlist as Playlist;
use \iutnc\deefy\renderer\AudioListRenderer as AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;
use iutnc\deefy\auth\Authz as Authz;

class DisplayPlaylistAction extends Action{
    public function __construct(){
        parent::__construct();
    }

    protected function executeGet(){
        $playlist = $_SESSION['playlist'];
        if(Authz::checkPlaylistOwner($playlist->getId())){
            $renderer = new AudioListRenderer($playlist);
           return $renderer->render(AudioListRenderer::LONG);
        }

    }

    protected function executePost(){
        return $this->executeGet();
    }
}