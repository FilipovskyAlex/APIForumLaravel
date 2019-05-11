<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function store(Request $request, Topic $topic, Post $post) : JsonResponse
    {
        $this->authorize('like', $post);

        if($request->user()->hasLikedPost($post)) {
            return new JsonResponse([
                'error' => 'Already liked'
            ], 409);
        }

        $like = new Like;
        $like->user()->associate($request->user());

        $post->likes()->save($like);

        return new JsonResponse(null, 204);
    }
}
