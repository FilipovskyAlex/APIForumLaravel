<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Post;
use App\Topic;
use App\Transformers\TopicTransformer;
use Illuminate\Http\JsonResponse;
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
    public function index() : array
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
     * @param Topic $topic
     * @return array
     */
    public function show(Topic $topic) : array
    {
        return fractal()
            ->item($topic)
            ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }

    /**
     * @param UpdateTopicRequest $request
     * @param Topic $topic
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTopicRequest $request, Topic $topic) : array
    {
        // Use policy to check user policies to update his own topic
        $this->authorize('update', $topic);

        $topic->title = $request->get('title', $topic->title);
        $topic->save();

        return fractal()
            ->item($topic)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
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
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }

    /**
     * @param Topic $topic
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Topic $topic) : JsonResponse
    {
        // Use policy to check user policies to delete his own topic
        $this->authorize('delete', $topic);

        $topic->delete();

        return new JsonResponse(null, 204);
    }
}
