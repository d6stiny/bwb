<?php
require_once __DIR__ . '/Model.php';

class Bottle extends Model
{
    public function create($userId)
    {
        return $this->db->query(
            "INSERT INTO bottle (user_id) VALUES (?)",
            [$userId]
        );
    }

    public function getTemperatures($bottleId)
    {
        return $this->db->query(
            "SELECT * FROM temperature WHERE bottle_id = ? ORDER BY measured_at DESC",
            [$bottleId]
        )->fetchAll();
    }

    public function delete($bottleId, $userId)
    {
        return $this->db->query(
            "DELETE FROM bottle WHERE id = ? AND user_id = ?",
            [$bottleId, $userId]
        )->rowCount();
    }

    public function getById($bottleId)
    {
        return $this->db->query(
            "SELECT * FROM bottle WHERE id = ?",
            [$bottleId]
        )->fetch();
    }

    public function getLevel($bottleId)
    {
        $result = $this->db->query(
            "SELECT level FROM bottle WHERE id = ?",
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
}