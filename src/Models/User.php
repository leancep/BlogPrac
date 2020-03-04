<?php
namespace Blogs\Models;

class User {

    protected $userId;
    protected $password;

    public function __construct(string $userId, string $password) {
        $this->userId = $userId;
        $this->password = $password;
    }

    public function getUserId(): string {
        return $this->userId;
    }

    public function getPassword(): string {
        return $this->password;
    }
}