<?php
class User extends Model {
    public function create($name, $email) {
        return $this->db->query(
            "INSERT INTO user (name, email) VALUES (?, ?)",
            [$name, $email]
        );
    }
    
    public function getById($id) {
        return $this->db->query(
            "SELECT * FROM user WHERE id = ?",
            [$id]
        )->fetch();
    }
}
