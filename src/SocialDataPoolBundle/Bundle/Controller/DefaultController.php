<?php

namespace SocialDataPoolBundle\Bundle\Controller;

use SocialDataPool\Application\Service\Tweet\LookForTweetRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $use_case = $this->container->get('look_for_tweet_use_case');

        $query_to_send = '"Pruno"';
        $request       = new LookForTweetRequest($query_to_send);
        $use_case->__invoke($request);

        return new Response('Success');
    }

}
