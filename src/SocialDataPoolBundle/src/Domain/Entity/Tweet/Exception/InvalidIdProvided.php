<?php

namespace SocialDataPool\Domain\Entity\Tweet\Exception;

final class InvalidIdProvided extends InvalidTweetArgumentProvided
{
    protected $message = 'The id provided cannot be null or empty.';
}
