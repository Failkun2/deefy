<?php

require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\AlbumTrack as AlbumTrack;
use \iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;
use \iutnc\deefy\renderer\AlbumTrackRenderer as AlbumTrackRenderer;
use \iutnc\deefy\renderer\PodcastTrackRenderer as PodcastTrackRenderer;
use \iutnc\deefy\audio\lists\Playlist as Playlist;
use \iutnc\deefy\renderer\AudioListRenderer as AudioListRenderer;

$a = new AlbumTrack("Im with you", "01-Im_with_you_BB-King-Lucille.mp3", "Lucille", 7);
try{
    $a->__set("artiste", "B. B. King");
    $a->__set("annee", "1968");
    $a->__set("genre", "Blues");
    $a->__set("duree", 151);
} catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$p = new PodcastTrack("Podcast1", "01-Im_with_you_BB-King-Lucille.mp3");
try{
    $p->__set("artiste", "B. B. King");
    $p->__set("annee", "1968");
    $p->__set("genre", "Blues");
    $p->__set("duree", 151);
} catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$liste = [$a, $p];

$pl = new Playlist("Playlist", $liste);
//print_r($pl);
//$pl->ajouterListeAudio($liste);

$alr = new AudioListRenderer($pl);

print $alr->render(2);