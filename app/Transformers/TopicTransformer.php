<?php

namespace App\Transformers;

use App\Topic;
use League\Fractal\TransformerAbstract;

/**
 * Class TopicTransformer
 * @package App\Transformers
 */
class TopicTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = ['user', 'posts'];

    /**
     * @param Topic $topic
     * @return array
     */
    public function transform(Topic $topic) : array
    {
        return [
            'id' => $topic->id,
            'title' => $topic->title,
            'created_at' => $topic->created_at->toDateTimeString(),
            'created_at_human' => $topic->created_at->diffForHumans(),
        ];
    }

    /**
     * @param Topic $topic
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Topic $topic)
    {
        return $this->item($topic->user, new UserTransformer);
    }

    /**
     * @param Topic $topic
     * @return \League\Fractal\Resource\Collection
     */
    protected function includePosts(Topic $topic)
    {
        return $this->collection($topic->posts, new PostTransformer);
    }
}
