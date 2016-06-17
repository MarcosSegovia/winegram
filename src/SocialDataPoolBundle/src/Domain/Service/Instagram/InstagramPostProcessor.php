<?php

namespace SocialDataPool\Domain\Service\Instagram;

use SocialDataPool\Domain\Model\Instagram\Post;
use SocialDataPool\Domain\Repository\Instagram\InstagramReaderInterface;
use SocialDataPool\Domain\Repository\Instagram\InstagramWriterInterface;
use SocialDataPool\Infrastructure\Service\Adapter\Instagram\JsonAdapter;

final class InstagramPostProcessor
{
    /** @var InstagramWriterInterface */
    private $instagram_posts_writer;

    /** @var InstagramReaderInterface */
    private $instagram_posts_reader;

    /** @var JsonAdapter */
    private $json_instagram_adapter;

    public function __construct(
        InstagramWriterInterface $a_writer,
        InstagramReaderInterface $a_reader,
        JsonAdapter $an_instagram_json_adapter
    )
    {
        $this->instagram_posts_writer = $a_writer;
        $this->instagram_posts_reader = $a_reader;
        $this->json_instagram_adapter = $an_instagram_json_adapter;
    }

    public function __invoke($all_raw_instagram_posts_to_process)
    {
        foreach ($all_raw_instagram_posts_to_process as $raw_instagram_post)
        {
            if ($this->instagram_posts_reader->checkIfPostIdHasBeenAlreadyProcessed($raw_instagram_post->id))
            {
                continue;
            }
            $post_information_encoded = $this->json_instagram_adapter->__invoke($raw_instagram_post);
            $a_new_post_to_persist = new Post($raw_instagram_post->id, $post_information_encoded);
            $this->instagram_posts_writer->persistNewPost($a_new_post_to_persist);
            $this->instagram_posts_writer->tagPostAsRead($a_new_post_to_persist);
        }
    }
}
