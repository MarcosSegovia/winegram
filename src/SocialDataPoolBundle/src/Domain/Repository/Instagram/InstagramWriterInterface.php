<?php

namespace SocialDataPool\Domain\Repository\Instagram;

use SocialDataPool\Domain\Model\Instagram\Post;

interface InstagramWriterInterface
{
    public function persistNewPost(Post $a_new_post);
    public function tagPostAsRead(Post $a_new_post);
}
