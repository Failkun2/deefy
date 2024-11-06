<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use iutnc\deefy\auth\AuthnProvider as AuthnProvider;
use iutnc\deefy\exception\AuthnException as AuthnException;

class SigninAction extends Action {

    protected function executeGet() {
        return '<form method="post" action="?action=signin">
            <label>Email : <input type="email" name="email" required></label><br>
            <label>Mot de passe : <input type="password" name="password" required></label><br>
            <button type="submit">Connexion</button>
        </form>';
    }

    protected function executePost(){
        try {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            AuthnProvider::signin($email, $password);
            return "<p>Connexion réussie ! Bienvenue, $email.</p>";
        } catch (AuthnException $e) {
            return "<p>Erreur de connexion : " . $e->getMessage() . "</p>";
        }
    }
}
