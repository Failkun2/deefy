<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use iutnc\deefy\audio\lists\Playlist as Playlist;
use iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;
use iutnc\deefy\action\DisplayPlaylistAction as DisplayPlaylistAction;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;

class AddPodcastTrackAction extends Action{
    public function __construct(){
        parent::__construct();
    }

    

    protected function executeGet(){
        return '<form method="post" action="?action=add-track" enctype="multipart/form-data">
        <label>Titre : <input type="text" name="track_title" required></label><br>
        <label>artiste : <input type="text" name="track_artist" required></label><br>
        <label>genre : <input type="text" name="track_genre" required></label><br>
        <label>annee : <input type="text" name="track_year" required></label><br>
        <label>Fichier audio (MP3) : <input type="file" name="audio_file" accept=".mp3" required></label><br>
        <button type="submit">valider</button>
        </form>';
    }

    protected function executePost(){
        $title = filter_var($_POST['track_title'], FILTER_SANITIZE_STRING);

        if (!$title) {
            return "<p>Informations de piste invalides. Réessayez.</p>";
        }



        if (array_key_exists('audio_file', $_FILES)) {
            $file = $_FILES['audio_file'];
            
            if (substr($file['name'], -4) === '.mp3' && $file['type'] === 'audio/mpeg') {
                $fileName = uniqid() . '.mp3';
                $destination =  'audio/' . $fileName;
                move_uploaded_file($file['tmp_name'], $destination);

                $track = new PodcastTrack($title, $fileName); 
                //$track->getAudioDuration($destination);
                $track->__set("artiste", $_POST['track_artist']);
                $track->__set("genre", $_POST['track_genre']);    
                $track->__set("annee", $_POST['track_year']);                
                $track = DeefyRepository::getInstance()->saveTrack($track); 

                if (isset($_SESSION['playlist'])) {
                    $playlist = DeefyRepository::getInstance()->findPlaylistById($_SESSION['playlist']->getID());
                    $playlist->ajouterAudio($track);
                    DeefyRepository::getInstance()->addTracktoPlaylist($playlist->getID(), $track->getID()); 
                    $_SESSION['playlist'] = $playlist;
                    $dpl = new DisplayPlaylistAction();
                    return $dpl->execute() . '<a href="?action=add-track">Ajouter encore une piste</a>';
                } else {
                    return "<p>Aucune playlist active. Veuillez d'abord en creer une.</p>";
                }
            } else {
                return "<p>Le fichier doit etre au format MP3.</p>";
            }
        } else {
            return "<p>Erreur : aucun fichier telecharge.</p>";
        }
    }
}