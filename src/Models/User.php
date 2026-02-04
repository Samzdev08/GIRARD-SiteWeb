<?php

namespace App\Models;

use App\Services\Database;
use PDO;

class User
{
    public $id;
    public $nomUtilisateur;
    public $motdepasse;
    public $typeCompte;

    public function __construct($id = null, $nomUtilisateur = null, $motdepasse = null, $typeCompte = null)
    {
        $this->id = $id;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motdepasse = $motdepasse;
        $this->typeCompte = $typeCompte;
    }

    public static function findByUsername($username)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE login = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function create($nomUtilisateur, $motdepasse, $typeCompte)
    {
        $db = Database::getInstance()->getConnection();
        $hashedPassword = password_hash($motdepasse, PASSWORD_BCRYPT);
        $stmt = $db->prepare('INSERT INTO users (login, password, user_type) VALUES (:username, :password, :type)');
        $stmt->bindParam(':username', $nomUtilisateur);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':type', $typeCompte);
        return $stmt->execute();
    }
}