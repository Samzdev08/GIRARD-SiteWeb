<?php
namespace App\Models;
use App\Services\Database;
use PDO;

class Keyword
{
    public $id;
    public $keyword;

    public function __construct($id = null, $keyword = null)
    {
        $this->id = $id;
        $this->keyword = $keyword;
    }

    public static function findAll()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM keywords ORDER BY keyword ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($keyword)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('INSERT INTO keywords (keyword) VALUES (:keyword)');
        $stmt->bindParam(':keyword', $keyword);
        return $stmt->execute();
    }

    public static function update($data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('UPDATE keywords SET keyword = :keyword WHERE id = :id');
        $stmt->bindParam(':keyword', $data['keyword']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public static function delete($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM keywords WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}