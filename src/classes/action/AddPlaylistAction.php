<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use \iutnc\deefy\audio\lists\Playlist as Playlist;
use iutnc\deefy\action\DisplayPlaylistAction as DisplayPlaylistAction;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;
use iutnc\deefy\auth\AuthnProvider as AuthnProvider;

class AddPlaylistAction extends Action{
    public function __construct(){
        parent::__construct();
    }
    
    protected function executeGet(){
        return '<form method="post" action="?action=add-playlist">
        <label>Titre de la Playlist : <input type="text" name="nom"></label><br>
        <button type="submit" name="valider">valider</button>
        </form>';
    }

    protected function executePost(){
        $name = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        $playlist = new Playlist($name);
        $playlist = DeefyRepository::getInstance()->saveEmptyPlaylist($playlist);
        
        $_SESSION['playlist'] = $playlist;
        $user = AuthnProvider::getSignedInUser();
        DeefyRepository::getInstance()->setPlaylistOwner(DeefyRepository::getInstance()->getUserId($user['passwd']),$playlist->getID());

        $dpl = new DisplayPlaylistAction();
        return $dpl->execute() . '<button href="?action=add-track">Ajouter une piste</button>';
    }
}