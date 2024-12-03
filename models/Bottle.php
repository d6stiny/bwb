<?php
require_once __DIR__ . '/Model.php';

class Bottle extends Model
{
    public function redeem($bottleId, $userId, $bottleName)
    {
        return $this->db->query(
            "UPDATE bottles SET user_id = ?, name = ? WHERE id = ? AND user_id IS NULL",
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

    public function release($bottleId, $userId)
    {
        return $this->db->query(
            "UPDATE bottles SET user_id = NULL, name = 'Unnamed Bottle' WHERE id = ? AND user_id = ?",
            [$bottleId, $userId]
        )->fetch();
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
            "SELECT level FROM bottles WHERE id = ?",
            [$bottleId]
        )->fetch();
        return $result ? $result['level'] : 0;
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

    public function rename($bottleId)
    {
        return $this->db->query(
            "UPDATE bottles SET name = ? WHERE id = ?",
            [$bottleId]
        );
    }
}