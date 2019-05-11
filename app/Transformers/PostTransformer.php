<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

/**
 * Class PostTransformer
 * @package App\Transformers
 */
class PostTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = ['user', 'likes'];

    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post) : array
    {
        return [
            'id' => $post->id,
            'body' => $post->body,
            'likes_count' => $post->likes->count(),
            'created_at' => $post->created_at->toDateTimeString(),
            'created_at_human' => $post->created_at->diffForHumans(),
        ];
    }

    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeLikes(Post $post)
    {
        return $this->collection($post->likes->pluck('user'), new UserTransformer());
    }
}
