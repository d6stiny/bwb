<?php
class User extends Model
{
    public function create($email, $password)
    {
        return $this->db->query(
            "INSERT INTO users (email, password) VALUES (?, ?)",
            [$email, $password]
        );
    }


    public function getById($id)
    {
        return $this->db->query(
            "SELECT id, email FROM users WHERE id = ?",
            [$id]
        )->fetch();
    }
}