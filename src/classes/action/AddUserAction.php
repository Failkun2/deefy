<?php

namespace iutnc\deefy\action;
require_once 'vendor/autoload.php';
use iutnc\deefy\action\Action as Action;
use iutnc\deefy\auth\AuthnProvider as AuthnProvider;
use iutnc\deefy\exception\AuthnException as AuthnException;


class AddUserAction extends Action{
    public function __construct(){
        parent::__construct();
    }
    
    protected function executeGet() {
        return '<form method="post" action="?action=add-user">
            <label>Email : <input type="email" name="email" required></label><br>
            <label>Mot de passe : <input type="password" name="password" required></label><br>
            <label>Confirmer le mot de passe : <input type="password" name="passwordConfirm" required></label><br>
            <button type="submit">Connexion</button>
        </form>';
    }

    protected function executePost(){
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];

        if ($password !== $passwordConfirm) {
            return "<p>Les mots de passe ne correspondent pas.</p>";
        }

        try {
            AuthnProvider::register($email, $password);
            return "<p>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>";
        } catch (AuthnException $e) {
            return "<p>Erreur d'inscription : " . $e->getMessage() . "</p>";
        }
    }
}