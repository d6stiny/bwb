<?php
class Status extends Model
{
    public function getAll()
    {
        return $this->db->query("SELECT * FROM status")->fetchAll();
    }

    public function updateBottleStatus($bottleId, $statusId)
    {
        return $this->db->query(
            "INSERT INTO bottle_status (bottle_id, status_id) VALUES (?, ?)",
            [$bottleId, $statusId]
        );
    }

    public function getCurrentStatus($bottleId)
    {
        return $this->db->query(
            "SELECT s.status_description 
             FROM bottle_status bs 
             JOIN status s ON bs.status_id = s.id 
             WHERE bs.bottle_id = ? 
             ORDER BY bs.measured_at DESC 
             LIMIT 1",
            [$bottleId]
        )->fetch();
    }
}