<?php

namespace iutnc\deefy\repository;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\lists\Playlist as Playlist;
use iutnc\deefy\audio\tracks\PodcastTrack as PodcastTrack;

class DeefyRepository {
    private \PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [ ];
    
    private function __construct(array $conf) {
        $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }
 
    public static function getInstance(){
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }
 
    public static function setConfig(string $file) {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }
        self::$config = [ 'dsn'=> "mysql:dbname=" . $conf['dbname'] . ";host=" . $conf['host'],'user'=> $conf['username'],'pass'=> $conf['password'] ];
    }
        
    public function findPlaylistById(int $id): Playlist {
        $stmt = $this->pdo->prepare("SELECT * FROM playlist WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt2 = $this->pdo->prepare("SELECT * FROM track INNER JOIN playlist2track ON track.id = playlist2track.id_track WHERE playlist2track.id_pl =  :id_pl");
        $stmt2->execute(['id_pl' => $id]);
        $results2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
        $tracks = [];
        foreach($results2 as $row){
            $track = new PodcastTrack($row['titre'], $row['filename']);
            $track->__set('duree', $row['duree']);
            if($row['annee_album'] != null){
                $track->__set('annee', $row['annee_album']);
            } else {
                $track->__set('annee', 2000);
            }
            $track->setID($row['id']);
            $track->__set('genre', $row['genre']);
            $tracks[] = $track;
        }
        $playlist = new Playlist($result['nom'], $tracks);
        $playlist->setID($id);

        return $playlist;
    }

    public function saveEmptyPlaylist(Playlist $pl): Playlist { 
        $stmt = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $pl->nom]);
        $pl->setID($this->pdo->lastInsertId());
        return $pl;           
    }

    public function getAllPlaylists(): array {
        $stmt = $this->pdo->query("SELECT * FROM playlist");

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $playlists = [];
        $tracks = [];

        foreach ($results as $row) {
            $stmt2 = $this->pdo->query("SELECT track.* FROM track INNER JOIN playlist2track ON track.id = playlist2track.id_track WHERE playlist2track.id_pl = " . $row['id']);
            $results2 = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
            foreach($results2 as $row2){
                $track = new PodcastTrack($row2['titre'], $row2['filename']);
                $track->__set('duree', $row2['duree']);
                if($row2['annee_album'] != null){
                    $track->__set('annee', $row2['annee_album']);
                } else {
                    $track->__set('annee', 2000);
                }
                $track->setID($row2['id']);
                $track->__set('genre', $row2['genre']);
                $tracks[] = $track;
            }
            print_r($tracks);
            $playlist = new Playlist($row['nom'], $tracks);
            $playlist->setID($row['id']);
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public function saveTrack(PodcastTrack $pk): PodcastTrack{
        $stmt = $this->pdo->prepare("INSERT INTO track (titre, genre, duree, filename, annee_album) VALUES (:titre, :genre, :duree, :filename, :annee_album)");
        $stmt->execute(['titre' => $pk->__get("titre"), 'genre' => $pk->__get("genre"), 'duree' => $pk->__get("duree"), 'filename' => $pk->__get("nomFichier"), 'annee_album' => $pk->__get("annee")]);
        $pk->setID($this->pdo->lastInsertId());
        return $pk;
    }

    public function addTrackToPlaylist(int $playlistId, int $trackId): void {
        $stmt = $this->pdo->prepare("INSERT INTO playlist2track (id_pl, id_track) VALUES (:id_pl, :id_track)");
        $stmt->execute(['id_pl' => $playlistId, 'id_track' => $trackId]);
    }
    
    public function getPasswd(string $email){
        $stmt = $this->pdo->prepare($query = "SELECT passwd FROM User WHERE email = :email");
    
        $stmt->execute(['email' => $email]);
    
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addUser(string $email, string $hash){
        $stmt = $this->pdo->prepare("INSERT INTO user (email, passwd, role) VALUES(:email, :passwd, 1)");
        $stmt->execute(['email' => $email, 'passwd' => $hash]);
    }

    public function getUserId(string $pwd){
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE passwd = :passwd");
        $stmt->execute(['passwd' => $pwd]);
        return $stmt->fetchColumn();
    }

    public function getUserRole(string $pwd){
        $stmt = $this->pdo->prepare("SELECT role FROM user WHERE passwd = :passwd");
        $stmt->execute(['passwd' => $pwd]);
        return $stmt->fetchColumn();
    }

    public function getPlaylistOwner(int $id){
        $stmt = $this->pdo->prepare("SELECT user.id FROM user INNER JOIN user2playlist ON user.id = user2playlist.id_user WHERE id_pl = :id_pl");
        $stmt->execute(['id_pl' => $id]);
        return $stmt->fetchColumn();
    }

    public function setPlaylistOwner(int $idUser, $idPlaylist){
        $stmt = $this->pdo->prepare("INSERT INTO user2playlist VALUES (:id_user, :id_pl)");
        $stmt->execute(['id_user' => $idUser, 'id_pl' => $idPlaylist]);
    }
}