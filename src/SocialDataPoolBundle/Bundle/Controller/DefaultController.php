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

    public function authenticationAction()
    {
        $session_service = $this->get('session');
        if(!$session_service->isStarted() || !$session_service->has('instagram_token'))
        {
            $this->forward('SocialDataPoolBundle:InstagramAuthentication:index');
        }
        dump($session_service->get('instagram_token'));
        
        return new Response('OK');
    }

}
