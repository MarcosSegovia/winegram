<?php

namespace SocialDataPoolBundle\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

	public function indexAction()
	{
		$repository = $this->container->get('tweet_repository');
		

		return new JsonResponse(array('message' => 'OK'));
	}

}
