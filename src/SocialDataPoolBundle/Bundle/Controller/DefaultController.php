<?php

namespace SocialDataPoolBundle\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SocialDataPoolBundle:Default:index.html.twig');
    }
}
