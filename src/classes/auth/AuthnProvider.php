<?php

namespace iutnc\deefy\auth;
require_once 'vendor/autoload.php';
use iutnc\deefy\exception\AuthnException as AuthnException;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;

class AuthnProvider{

    public static function signin(string $email,string $passwd2check): void {
        $user = DeefyRepository::getInstance()->getPasswd($email);
        print_r($user);
        if (!password_verify($passwd2check, $user['passwd'])){
            throw new AuthnException("Auth error : invalid credentials");
        }
        $_SESSION['user'] = serialize($user);
        return ;
    }


    public static function register( string $email, string $pass): void {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new AuthnException("error : invalid user email");
        }
        if(self::checkPasswordStrength($pass, 10)){
            throw new AuthnException("error : password too short");   
        }
        $hash = password_hash($pass, PASSWORD_DEFAULT, ['cost'=>12]);
        $newUser = DeefyRepository::getInstance()->addUser($email, $hash);
        $_SESSION['user'] = serialize($newUser);
        return ;
    }

    public static function checkPasswordStrength(string $pass,int $minimumLength): bool {
        $length = (strlen($pass) < $minimumLength); // longueur minimale
        $digit = preg_match("#[\d]#", $pass); // au moins un digit
        $special = preg_match("#[\W]#", $pass); // au moins un car. spécial
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule
        if (!$length || !$digit || !$special || !$lower || !$upper)return false;
        return true;
    }

    public static function getSignedInUser() {
        if ( !isset($_SESSION['user']))
        throw new AuthnException("Auth error : not signed in");
       
        return unserialize($_SESSION['user']);
    }
}