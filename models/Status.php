<?php
class Status extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM status")->fetchAll();
    }
    
    public function updateBottleStatus($bottleId, $statusId) {
        return $this->db->query(
            "INSERT INTO bottle_status (bottle_id, status_id) VALUES (?, ?)",
            [$bottleId, $statusId]
        );
    }
}