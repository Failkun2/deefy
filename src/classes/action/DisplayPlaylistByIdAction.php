<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use \iutnc\deefy\audio\lists\Playlist as Playlist;
use \iutnc\deefy\renderer\AudioListRenderer as AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;
use iutnc\deefy\auth\Authz as Authz;

class DisplayPlaylistByIdAction extends Action{
    public function __construct(){
        parent::__construct();
    }

    protected function executeGet(){
        return '<form method="post" action="?action=display-playlist">
          <label><input type="text" name="id" required></label><br>
          <button type="submit">chercher</button></form>';
    }

    protected function executePost(){
        $playlist = DeefyRepository::getInstance()->findPlaylistById($_POST['id']);
        if(Authz::checkPlaylistOwner($_POST['id'])){
            $renderer = new AudioListRenderer($playlist);
            return $renderer->render(AudioListRenderer::LONG);
        }
        return "not your playlist, search another one";
    }
}