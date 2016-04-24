<?php

namespace SocialDataPool\Domain\Entity\Tweet\Exception;

final class InvalidDataProvided extends InvalidTweetArgumentProvided
{
    protected $message = 'The data associated with the Tweet cannot be empty or null.';
}
