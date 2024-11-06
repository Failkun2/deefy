<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;

class DefaultAction extends Action{
    public function __construct(){
        parent::__construct();
    }

    protected function executeGet(){
        return '<p><h1>Welcome to Deefy</h1><p>choose a button to login, create a new playlist or add a track to your current one</p></p>';
    }

    protected function executePost() {
        return $this->executeGet();
    }
}