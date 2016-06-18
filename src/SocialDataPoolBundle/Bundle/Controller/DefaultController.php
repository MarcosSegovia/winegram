<?php

namespace SocialDataPoolBundle\Bundle\Controller;

use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $use_case = $this->get('look_for_tweet_use_case');

        $query_to_send = '"Pruno"';
        $request       = new LookForTweetRequest($query_to_send);
        $use_case->__invoke($request);

        return new Response('Success');
    }

    public function index2Action()
    {
        $session_service = $this->get('session');
        if(!$session_service->isStarted() || !$session_service->has('instagram_token'))
        {
            $this->forward('SocialDataPoolBundle:InstagramAuthentication:index');
        }
        $uinvum_api_client = $this->get('uvinum_api_client');
        $response = $uinvum_api_client->getTopSellingWines('blanco');
        dump($response->json());
        $instagram_client = $this->get('instagram_api_client');
        $instagram_client->setAccessToken($session_service->get('instagram_token'));
        dump($instagram_client->getTagMedia('vino'));
        
        return new Response('OK');
    }

}
