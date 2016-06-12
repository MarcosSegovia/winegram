<?php

namespace SocialDataPool\Domain\Repository\Twitter;

interface TweetReaderInterface
{
    public function getTweet();
    public function checkIfTweetIdHasBeenAlreadyProcessed($current_tweet_id);
}
