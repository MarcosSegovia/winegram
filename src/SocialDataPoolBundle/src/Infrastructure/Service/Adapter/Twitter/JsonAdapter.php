<?php

namespace SocialDataPool\Infrastructure\Service\Adapter\Twitter;

use SocialDataPool\Domain\Model\Core\Search;
use SocialDataPool\Domain\Model\Tweet\Tweet;

final class JsonAdapter
{
    /** @var array */
    private $my_array_of_social_data;

    public function __invoke(
        $a_twitter_response_to_adapt,
        Search $a_search
    )
    {
        $this->my_array_of_social_data             = [];
        $this->my_array_of_social_data['id']       = $a_twitter_response_to_adapt['id_str'];
        $this->my_array_of_social_data['type']     = Tweet::TWITTER_TYPE;
        $this->my_array_of_social_data['text']     = $a_twitter_response_to_adapt['text'];
        $this->my_array_of_social_data['username'] = $a_twitter_response_to_adapt['user']['name'];

        if (array_key_exists('media', $a_twitter_response_to_adapt['entities']))
        {
            $this->my_array_of_social_data['media'] = $a_twitter_response_to_adapt['entities']['media'][0]['media_url'];
        }
        else
        {
            $this->my_array_of_social_data['media'] = '';
        }

        $this->my_array_of_social_data['likes_count'] = $a_twitter_response_to_adapt['favorite_count'];
        $this->my_array_of_social_data['tags']        = [];

        foreach ($a_twitter_response_to_adapt['entities']['hashtags'] as $current_hashtag)
        {
            $this->my_array_of_social_data['tags'][] = $current_hashtag['text'];
        }

        $this->my_array_of_social_data['search_id']      = $a_search->searchId();
        $this->my_array_of_social_data['search_content'] = $a_search->relatedSearchContent();
        $this->my_array_of_social_data['query']          = $a_search->queryString();

        return $this->encodeTweetData();
    }

    private function encodeTweetData()
    {
        return json_encode($this->my_array_of_social_data);
    }
}
