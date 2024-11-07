<?php
class Temperature extends Model {
    public function create($bottleId, $value) {
        return $this->db->query(
            "INSERT INTO temperature (bottle_id, temperature_value) VALUES (?, ?)",
            [$bottleId, $value]
        );
    }
}