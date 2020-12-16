<?php

namespace App\Repositories\Posts;

use Kreait\Laravel\Firebase\Facades\Firebase;

class PostFirestore implements PostRepositoryInterface
{
    protected $postCollection;

    public function __construct()
    {
        $this->postCollection = Firebase::firestore()
            ->database()
            ->collection('posts');
    }

    public function all() : array
    {
        $documents = $this->postCollection->documents();

        $data = [];

        foreach ($documents as $document) {

            if ($document->exists()) {

                $item['id'] = $document->id();
                $post = array_merge($item, $document->data());

                $data[] = $post;
            }
        }

        return $data;
    }

    public function find($id) : ?array
    {
        $document = $this->postCollection->document($id);
        $snapshot = $document->snapshot();

        if ($snapshot->exists()) {

            $item['id'] = $document->id();
            $post = array_merge($item, $snapshot->data());

            return $post;

        } else {
            return null;
        }
    }
    
    public function store($data) : array
    {
        $post = $this->postCollection->add($data);

        if ($post->id()) {
            return $this->find($post->id());
        } else {
            return null;
        }
    }
    
    public function update(string $id, array $data): array
    {
        $this->postCollection
            ->document($id)
            ->set($data);

        return $this->find($id);
    }
    
    public function delete($id) : bool
    {
        $delete = $this->postCollection->document($id)->delete();
        
        return $delete ? true : false;
    }
}
