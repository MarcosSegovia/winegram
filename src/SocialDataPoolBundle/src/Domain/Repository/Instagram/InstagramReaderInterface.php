<?php

namespace SocialDataPool\Domain\Repository\Instagram;

interface InstagramReaderInterface
{
    public function getPost();

    public function checkIfPostIdHasBeenAlreadyProcessed($current_post_id);
}
