<?php
class Bottle extends Model {
    public function create($userId) {
        return $this->db->query(
            "INSERT INTO bottle (user_id) VALUES (?)",
            [$userId]
        );
    }
    
    public function getTemperatures($bottleId) {
        return $this->db->query(
            "SELECT * FROM temperature WHERE bottle_id = ? ORDER BY measured_at DESC",
            [$bottleId]
        )->fetchAll();
    }
}