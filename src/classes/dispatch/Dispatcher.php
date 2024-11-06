<?php

namespace iutnc\deefy\dispatch;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use iutnc\deefy\action\AddUserAction as AddUserAction;
use iutnc\deefy\action\DisplayPlaylistAction as DisplayPlaylistAction;
use iutnc\deefy\action\DisplayPlaylistByIdAction as DisplayPlaylistByIdAction;
use iutnc\deefy\action\AddPlaylistAction as AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction as AddPodcastTrackAction;
use iutnc\deefy\action\SigninAction as SigninAction;
use iutnc\deefy\action\DefaultAction as DefaultAction;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;

class Dispatcher{
    protected string $action;

    public function __construct(){
        $this->action = $_GET['action'];
    }

    public function run(){
        switch($this->action){
            case "add-user":
                $Action = new AddUserAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
            case "playlist":
                $Action = new DisplayPlaylistAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
            case "display-playlist":
                $Action = new DisplayPlaylistByIdAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
            case "add-playlist":
                $Action = new AddPlaylistAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
            case "add-track":
                $Action = new AddPodcastTrackAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
            case "signin":
                $Action = new SigninAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
            case 'add-user':
                $addUser = new AddUserAction();
                echo $addUser->execute();
                break;
            case "default":
            default:
                $Action = new DefaultAction();
                $html = $Action->execute();
                self::renderPage($html);
                break;
        }
    }

    private function renderPage(string $html){
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
          <meta charset="utf-8">
          <title>Application Deefy</title>
          <link rel="stylesheet" href="styles.css">
        </head>
        <header>
          <button><a href="?action=default">starting page</a></button>
          <button><a href="?action=playlist">current playlist</a></button>
          <button><a href="?action=display-playlist">search playlist</a></button>
          <button><a href="?action=add-playlist">add a playlist</a></button>
          <button><a href="?action=add-track">add a track</a></button>
          <button><a href="?action=signin">login to account</a></button>
          <button><a href="?action=add-user">create account</a></button>
        </header>
        <body>' . $html . '</body></html>';
    }
}