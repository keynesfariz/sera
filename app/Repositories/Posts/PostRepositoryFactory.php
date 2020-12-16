<?php

namespace App\Repositories\Posts;

use RuntimeException;

class PostRepositoryFactory
{
    const FIRESTORE = 'firestore';
    const REALTIME = 'realtime';
    const MONGODB = 'mongodb';

    public function make($database)
    {
        switch ($database) {
            case self::FIRESTORE:
                return new PostFirestore;
            case self::REALTIME:
                return new PostRealtime;
            case self::MONGODB:
                return new PostMongoDB;
            default:
                throw new RuntimeException('Unknown Repository: ' . $database);
        }
    }
}
