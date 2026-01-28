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
        $stmt = $db->prepare("SELECT * FROM " . self::$table );
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
    

}