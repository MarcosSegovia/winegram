<?php

namespace SocialDataPool\Domain\Repository;

interface TweetReaderInterface
{
    public function getTweet();
    
    public function checkIfTweetIdHasBeenAlreadyProcessed($current_tweet_id);
}
