<?php

namespace SocialDataPool\Domain\Model\Tweet\Exception;

use SocialDataPool\Domain\Model\Core\Exception\InvalidSocialArgumentProvided;

final class InvalidTweetDataProvided extends InvalidSocialArgumentProvided
{
    protected $message = 'The data associated with the Tweet cannot be empty or null.';
}
