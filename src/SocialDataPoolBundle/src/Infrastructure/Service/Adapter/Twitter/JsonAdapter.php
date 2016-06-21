<?php

namespace SocialDataPool\Infrastructure\Service\Adapter\Twitter;

use SocialDataPool\Domain\Model\Tweet\Tweet;

final class JsonAdapter
{
    /** @var array */
    private $my_array_of_social_data;

    public function __invoke(
        $a_twitter_response_to_adapt,
        $a_product_id = null
    )
    {
        $this->my_array_of_social_data = [];

        $this->my_array_of_social_data['id']             = $a_twitter_response_to_adapt['id_str'];
        $this->my_array_of_social_data['type']           = Tweet::TWITTER_TYPE;
        $this->my_array_of_social_data['text']           = $a_twitter_response_to_adapt['text'];
        $this->my_array_of_social_data['username'] = $a_twitter_response_to_adapt['user']['name'];
        $this->my_array_of_social_data['likes_count'] = $a_twitter_response_to_adapt['favorite_count'];
        
        foreach ($a_twitter_response_to_adapt['entities']['hashtags'] as $current_hashtag)
        {
            $this->my_array_of_social_data['tags'][] = $current_hashtag['text'];
        }
        
        if (null !== $a_product_id)
        {
            $this->my_array_of_social_data['uvinum_product_id'] = $a_product_id;
        }



        return $this->encodeTweetData();
    }

    private function encodeTweetData()
    {
        return json_encode($this->my_array_of_social_data);
    }
}
