<?php

require_once  'vendor/autoload.php';

\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '\db.config.ini');

$repo = \iutnc\deefy\repository\DeefyRepository::getInstance();

//$playlists = $repo->findAllPlaylists();
//foreach ($playlists as $pl) {
//    print "playlist  : " . $pl->nom . ":". $pl->id . "\n";
//}


//$pl = new \iutnc\deefy\audio\lists\PlayList('test');
//$pl = $repo->saveEmptyPlaylist($pl);
//print "playlist  : " . $pl->nom . ":". $pl->id . "\n";

//$track = new \iutnc\deefy\audio\tracks\PodcastTrack('test', 'test.mp3', 'auteur', '2021-01-01', 10, 'genre');
//$track = $repo->savePodcastTrack($track);
//print "track 2 : " . $track->titre . ":". get_class($track). "\n";
//$repo->addTrackToPlaylist($pl->id, $track->id);
