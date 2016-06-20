<?php

namespace SocialDataPool\Infrastructure\Service\Adapter\Instagram;

use SocialDataPool\Domain\Model\Instagram\Post;

final class JsonAdapter
{
    /** @var array */
    private $my_array_of_social_data;

    public function __invoke(
        $an_instagram_post_response_to_adapt,
        $a_product_id = null
    )
    {
        $this->my_array_of_social_data = [];

        $this->my_array_of_social_data['id']                      = $an_instagram_post_response_to_adapt->id;
        $this->my_array_of_social_data['type']                    = Post::INSTAGRAM_TYPE;
        $this->my_array_of_social_data['text']                    = $an_instagram_post_response_to_adapt->caption->text;
        $this->my_array_of_social_data['url_images']['low']       = $an_instagram_post_response_to_adapt->images->low_resolution->url;
        $this->my_array_of_social_data['url_images']['thumbnail'] = $an_instagram_post_response_to_adapt->images->thumbnail->url;
        $this->my_array_of_social_data['url_images']['standard']  = $an_instagram_post_response_to_adapt->images->standard_resolution->url;
        $this->my_array_of_social_data['likes']                   = $an_instagram_post_response_to_adapt->likes->count;

        if (null !== $a_product_id)
        {
            $this->my_array_of_social_data['uvinum_product_id'] = $a_product_id;
        }
        
        foreach ($an_instagram_post_response_to_adapt->tags as $current_hashtag)
        {
            $this->my_array_of_social_data['tags'][] = $current_hashtag;
        }
        $this->my_array_of_social_data['username'] = $an_instagram_post_response_to_adapt->caption->from->full_name;

        return $this->encodePostData();
    }

    private function encodePostData()
    {
        return json_encode($this->my_array_of_social_data);
    }
}
