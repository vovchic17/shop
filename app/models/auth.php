<?php

class AuthModel extends Model
{
    public function createUser(string $username, string $salt, string $pwdHash): void
    {
        $this->pdo->prepare(
            "INSERT INTO `user` (username, salt, pwd_hash) VALUES (?, ?, ?)",
        )->execute([$username, $salt, $pwdHash]);
    }

    public function getUserSalt(string $login): string|null
    {
        $stmt = $this->pdo->prepare(
            "SELECT salt FROM `user` WHERE username = ?"
        );
        $stmt->execute([$login]);
        return $stmt->fetch()["salt"] ?? null;
    }

    public function getUserHash(string $login): string|null
    {
        $stmt = $this->pdo->prepare(
            "SELECT pwd_hash FROM `user` WHERE username = ?"
        );
        $stmt->execute([$login]);
        return $stmt->fetch()["pwd_hash"] ?? null;
    }


    public function getUserId(string $login): int|null
    {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM `user` WHERE username = ?"
        );
        $stmt->execute([$login]);
        return $stmt->fetch()["id"] ?? null;
    }
}