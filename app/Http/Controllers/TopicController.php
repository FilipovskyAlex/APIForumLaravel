<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Post;
use App\Topic;
use App\Transformers\TopicTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
 * Class TopicController
 * @package App\Http\Controllers
 */
class TopicController extends Controller
{

    /**
     * Get paginate list of all topics
     * @return array
     */
    public function index()
    {
        $topics = Topic::newestFirst()->paginate(2);
        $topicsCollection = $topics->getCollection();

        return fractal()
            ->collection($topicsCollection)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($topics))
            ->toArray();
    }

    /**
     * @param StoreTopicRequest $request
     * @return array
     */
    public function store(StoreTopicRequest $request) : array
    {
        // Bind request topic params to the storing topic
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        // Bind request post params to the storing post
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return fractal()
            ->item($topic)
            ->parseIncludes(['user', 'posts', 'posts.user'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }
}
