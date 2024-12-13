<?php
require_once __DIR__ . '/Model.php';

class Bottle extends Model
{
    public function redeem($bottleId, $userId, $bottleName)
    {
        // First check if bottle exists
        $bottle = $this->db->query(
            "SELECT * FROM bottles WHERE id = ?",
            [$bottleId]
        )->fetch();

        if (!$bottle) {
            throw new Exception('Bottle not found', 404);
        }

        // Check if bottle is already redeemed
        if ($bottle['user_id'] !== null) {
            throw new Exception('This bottle is already linked to another user', 400);
        }

        // Proceed with redemption
        return $this->db->query(
            "UPDATE bottles SET user_id = ?, name = ? WHERE id = ?",
            [$userId, $bottleName, $bottleId]
        );
    }

    public function getTemperatures($bottleId)
    {
        return $this->db->query(
            "SELECT * FROM temperatures WHERE bottle_id = ? ORDER BY measured_at DESC",
            [$bottleId]
        )->fetchAll();
    }

    public function getTodaysTemperatures($bottleId)
    {
        return $this->db->query(
            "SELECT * FROM temperatures WHERE bottle_id = ? AND measured_at >= CURDATE() ORDER BY measured_at DESC",
            [$bottleId]
        )->fetchAll();
    }

    public function release($bottleId, $userId)
    {
        // set user id to null, name to 'Unnamed Bottle', level to 0 and delete all temperatures
        return $this->db->query(
            "UPDATE bottles SET user_id = NULL, name = 'Unnamed Bottle', level = 0 WHERE id = ? AND user_id = ?",
            [$bottleId, $userId]
        );
    }

    public function getById($bottleId)
    {
        return $this->db->query(
            "SELECT * FROM bottles WHERE id = ?",
            [$bottleId]
        )->fetch();
    }

    public function getLevel($bottleId)
    {
        $result = $this->db->query(
            "SELECT level_percentage FROM bottle_level 
        WHERE bottle_id = ? 
        ORDER BY measured_at DESC 
        LIMIT 1",
            [$bottleId]
        )->fetch();

        return $result ? $result['level_percentage'] : 0;
    }

    public function getUserBottles($userId)
    {
        return $this->db->query(
            "SELECT * FROM bottles WHERE user_id = ?",
            [$userId]
        )->fetchAll();
    }

    public function getCurrentTemperature($bottleId)
    {
        return $this->db->query(
            "SELECT value FROM temperatures WHERE bottle_id = ? ORDER BY measured_at DESC LIMIT 1",
            [$bottleId]
        )->fetchColumn();
    }

    public function rename($bottleId, $newName)
    {
        return $this->db->query(
            "UPDATE bottles SET name = ? WHERE id = ?",
            [$newName, $bottleId]
        );
    }

    public function getAverageTemperature($bottleId)
    {
        return $this->db->query(
            "SELECT AVG(value) FROM temperatures WHERE bottle_id = ?",
            [$bottleId]
        )->fetchColumn();
    }
}