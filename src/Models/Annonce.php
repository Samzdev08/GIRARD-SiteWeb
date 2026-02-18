<?php

namespace App\Models;

use App\Services\Database;
use PDO;

class Annonce
{
    protected static $table = 'ads';
    public $id;
    public $user_id;
    public $titre;
    public $descriptif;
    public $competence_requise;
    public $date_debut;
    public $date_fin;
    public $media;
    public $media_type;

    public function __construct($id = null, $user_id = null, $titre = null, $descriptif = null, $competence_requise = null, $date_debut = null, $date_fin = null, $media = null, $media_type = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->titre = $titre;
        $this->descriptif = $descriptif;
        $this->competence_requise = $competence_requise;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->media = $media;
        $this->media_type = $media_type;
    }


    public static function findAllStage()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public static function findById($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return $result;
    }

    public static function findAnnonceByUserId($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return $result;
    }

    public static function nombreStage()
    {

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM " . self::$table);
        $stmt->execute();
        $total = $stmt->fetchColumn();

        return $total;
    }

    public static function verifMedia($file)
    {

        if ($file['size'] == 0 ||$file['size'] > 1000000) return ['success' => false, 'message' => 'Taille de fichier trop grand max '];



        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

        $finalName = time() . '_' . $file['name'];
        $destination = $uploadDir . $finalName;

        $allowed = ['pdf'];

        $extension = strtolower(pathinfo($finalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {

            return ['success' => false, 'message' => 'Mauvaise extension de fichier.'];
        }

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => false, 'message' => 'Échec du déplacement du fichier.'];
        }

        return ['success' => true, 'filename' => $finalName, 'type' => $extension];
    }

    public static function updateAnnonce($data){
        $db = Database::getInstance()->getConnection();

        $sql = "
        UPDATE ads
        SET 
            title = :title,
            description = :description,
            required_skills = :required_skills,
            media_path = :media_path,
            media_type = :media_type,
            start_date = :date_debut,
            end_date = :date_fin,
            updated_at = NOW()
        WHERE id = :id
        ";
        
        $stmt = $db->prepare($sql);

        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'required_skills' => $data['required_skills'],
            'media_path' => $data['media_path'],
            'media_type' => $data['media_type'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'id' => $data['id']
        ]);

        return true;
    }

    public static function deleteAnnonce($id){
        $db = Database::getInstance()->getConnection();

        $sql = "DELETE FROM ads WHERE id = :id";
        
        $stmt = $db->prepare($sql);

        $stmt->execute(['id' => $id]);

        return true;
    } 
    
    public static function createAnnonce($data){
        $db = Database::getInstance()->getConnection();

        $sql = "
        INSERT INTO ads (user_id, title, description, required_skills, media_path, media_type, start_date, end_date, created_at)
        VALUES (:user_id, :title, :description, :required_skills, :media_path, :media_type, :date_debut, :date_fin, NOW())
        ";
        
        $stmt = $db->prepare($sql);

        $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'required_skills' => $data['required_skills'],
            'media_path' => $data['media_path'],
            'media_type' => $data['media_type'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin']
        ]);

        return true;
    }
}
