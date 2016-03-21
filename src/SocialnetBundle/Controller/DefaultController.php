<?php

namespace SocialnetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SocialnetBundle:Default:index.html.twig');
    }
}
