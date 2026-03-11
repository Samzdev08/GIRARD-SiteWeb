<?php
namespace App\Models;
use App\Services\Database;
use PDO;

class Wishlist
{
    public $adId;
    public $userId;
    public $addedAt;

    public function __construct($adId = null, $userId = null, $addedAt = null)
    {
        $this->adId = $adId;
        $this->userId = $userId;
        $this->addedAt = $addedAt;
    }

    public static function exists($adId, $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT 1 FROM wishlist WHERE ad_id = :adId AND user_id = :userId');
        $stmt->bindParam(':adId', $adId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    public static function add($adId, $userId)
    {
        if (self::exists($adId, $userId)) return false;
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('INSERT INTO wishlist (ad_id, user_id, added_at) VALUES (:adId, :userId, NOW())');
        $stmt->bindParam(':adId', $adId);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    public static function remove($adId, $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM wishlist WHERE ad_id = :adId AND user_id = :userId');
        $stmt->bindParam(':adId', $adId);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    public static function getByUser($userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('
            SELECT a.*, w.added_at AS wishlist_date 
            FROM wishlist w 
            JOIN ads a ON a.id = w.ad_id 
            WHERE w.user_id = :userId 
            ORDER BY w.added_at DESC
        ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countByAnnonce($adId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT COUNT(*) FROM wishlist WHERE ad_id = :adId');
        $stmt->bindParam(':adId', $adId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}