<?php

namespace SocialDataPoolBundle\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class InstagramAuthenticationController extends Controller
{
    public function indexAction()
    {
        $this->get('session')->start();

        $instagram_client = $this->get('instagram_api_client');
        $login_url        = $instagram_client->getLoginUrl(['basic', 'public_content']);

        return $this->redirect($login_url);
    }

    public function codeAction(Request $request)
    {
        if (null !== $request->query->get('code'))
        {
            $current_code     = $request->query->get('code');
            $instagram_client = $this->get('instagram_api_client');
            $this->get('session')->set('instagram_token', $instagram_client->getOAuthToken($current_code));
            return $this->redirectToRoute('social_data_pool_instagram');
        }

        return new Response('fail');
    }
}
