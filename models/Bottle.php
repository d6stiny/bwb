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

    public function getAverageTemperature($bottleId)
    {
        return $this->db->query(
            "SELECT AVG(value) FROM temperatures WHERE bottle_id = ?",
            [$bottleId]
        )[0];
    }
}