<?php

namespace SocialDataPool\Domain\Model\Instagram\Exception;

use SocialDataPool\Domain\Model\Core\Exception\InvalidSocialArgumentProvided;

final class InvalidInstagramPostDataProvided extends InvalidSocialArgumentProvided
{
    protected $message = 'The data associated with the Instagram post cannot be empty or null.';
}
