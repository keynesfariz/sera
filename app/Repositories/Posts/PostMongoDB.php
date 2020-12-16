<?php

namespace App\Repositories\Posts;

use App\Models\Post;
use Ramsey\Uuid\Uuid;

class PostMongoDB implements PostRepositoryInterface
{
    public function all() : array
    {
        return Post::all()->toArray();
    }

    public function find($id) : ?array
    {
        return Post::find($id);
    }
    
    public function store($data) : array
    {
        $uuid = Uuid::uuid4();
        $id = $uuid->toString();

        return Post::create(array_merge(['id' => $id], $data));
    }
    
    public function update(string $id, array $data): array
    {
        Post::where('id', $id)->update($data);

        return $this->find($id);
    }
    
    public function delete($id) : bool
    {
        $delete = Post::destroy($id);
        
        return $delete ? true : false;
    }
}
