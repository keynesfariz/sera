<?php

namespace App\Repositories\Posts;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Ramsey\Uuid\Uuid;

class PostRealtime implements PostRepositoryInterface
{
    protected $tree;
    protected $database;

    public function __construct()
    {
        $this->tree = 'posts';
        $this->database = Firebase::database();
    }

    public function all() : array
    {
        $posts = $this->database
            ->getReference($this->tree)
            ->getValue();

        foreach ($posts as $id => $post) {
            $posts[$id] = array_merge(['id' => $id], $post);
        }

        return array_values($posts);
    }

    public function find($id) : ?array
    {
        $reference = $this->database
            ->getReference($this->tree)
            ->getChild($id);
        
        if ($reference->getSnapshot()->exists()) {
            $item['id'] = $id;
            $post = array_merge($item, $reference->getSnapshot()->getValue());

            return $post;

        } else {
            return null;
        }
    }
    
    public function store($data) : array
    {
        $uuid = Uuid::uuid4();
        $id = $uuid->toString();

        $this->database
            ->getReference($this->tree)
            ->getChild($id)
            ->set($data);

        if ($id) {
            return $this->find($id);
        } else {
            return null;
        }
    }
    
    public function update(string $id, array $data): array
    {
        $this->database
            ->getReference($this->tree)
            ->getChild($id)
            ->set($data);

        return $this->find($id);
    }
    
    public function delete($id) : bool
    {
        $delete = $this->database
            ->getReference($this->tree)
            ->getChild($id)
            ->remove();
        
        return $delete ? true : false;
    }
}
