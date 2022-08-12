<?php

class User {
    public string $username;
    public int $role;

    function __construct(string $username, int $role) {
        $this->username = $username;
        $this->role = $role;
    }

    function isAdmin(): bool {
        if ($this->role == 1) {
            return true;
        }
        return false;
    }
}
