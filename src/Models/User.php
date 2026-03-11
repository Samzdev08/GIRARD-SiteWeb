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
        $stmt = $db->prepare('INSERT INTO users (login, password, user_type) VALUES (:username, :password, :type)');
        $stmt->bindParam(':username', $nomUtilisateur);
        $stmt->bindParam(':password', $motdepasse);
        $stmt->bindParam(':type', $typeCompte);
        return $stmt->execute();
    }

    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM users ORDER BY id ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateUser($data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('UPDATE users SET user_type = :user_type WHERE id = :id');
        $stmt->bindParam(':user_type', $data['user_type']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public static function deleteUser($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public static function usernameExists($username): bool
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE login = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return (int) $stmt->fetchColumn() > 0;
    }
}