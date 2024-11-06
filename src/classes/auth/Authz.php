<?php

namespace iutnc\deefy\auth;
require_once 'vendor/autoload.php';
use iutnc\deefy\exception\AuthnException as AuthnException;
use iutnc\deefy\auth\AuthnProvider as AuthnProvider;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;

class Authz{
    
    public const NORMAL_USER = 1;
    public const ADMIN_USER = 100;

    public static function checkRole(int $roleAttendu){
        $user = AuthnProvider::getSignedInUser();
        $role = DeefyRepository::getInstance()->getUserRole($user['passwd']);
        $user = AuthnProvider::getSignedInUser();
        return $role === $roleAttendu;
    }

    public static function checkPlaylistOwner(int $id){
        $user = AuthnProvider::getSignedInUser();
        $userId = DeefyRepository::getInstance()->getUserId($user['passwd']);
        $ownerId = DeefyRepository::getInstance()->getPlaylistOwner($id);
        $role = DeefyRepository::getInstance()->getUserRole($user['passwd']);

        return $userId === $ownerId || $role === self::checkRole(self::ADMIN_USER);
    }
}