<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'matiere_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'username',
        'password',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function verifyCredentials(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)->first();
        if ($user === null) {
            return null;
        }

        if (! password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }
}
