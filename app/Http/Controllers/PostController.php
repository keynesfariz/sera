<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Repositories\Posts\PostRepositoryFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Connection;

class PostController extends Controller
{
    protected $postRepository;
    
    public function __construct()
    {
        $database = request()->route('database');

        $postFactory = new PostRepositoryFactory;
        $this->postRepository = $postFactory->make($database);
    }

    public function index(Request $request, $database)
    {
        $posts = $this->postRepository->all();

        return Helper::response($posts, true);
    }

    public function show(Request $request, $database, $id)
    {
        $post = $this->postRepository->find($id);

        if ($post) {
            $errorStatus = 1;
            $message = 'Success';
        } else {
            $errorStatus = 0;
            $message = 'Post not found';
        }

        return Helper::response($post, false, $errorStatus, $message);
    }
    
    public function store(Request $request, $database)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $postData = $request->only('title', 'body');
        $postData['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $postData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $post = $this->postRepository->store($postData);

        if ($post) {
            $errorStatus = 1;
            $message = 'A post has been created';
            $statusCode = 201;
        } else {
            $errorStatus = 0;
            $message = 'Failed to create a post';
            $statusCode = 200;
        }

        return Helper::response($post, false, $errorStatus, $message, $statusCode);
    }
    
    public function update(Request $request, $database, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $post = $this->postRepository->find($id);

        if ($post) {
            
            unset($post['id']);
            
            $postData = array_merge($post, $request->only('title', 'body'));
            $postData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            $post = $this->postRepository->update($id, $postData);
        }


        if ($post) {
            $errorStatus = 1;
            $message = 'Post updated';
        } else {
            $errorStatus = 0;
            $message = 'Failed to update this post';
        }

        return Helper::response($post, false, $errorStatus, $message);
    }

    public function destroy(Request $request, $database, $id)
    {
        $post = $this->postRepository->delete($id);

        if ($post) {
            $errorStatus = 1;
            $message = 'Post deleted';
        } else {
            $errorStatus = 0;
            $message = 'Failed to delete this post';
        }

        return Helper::response(null, false, $errorStatus, $message);
    }
}
