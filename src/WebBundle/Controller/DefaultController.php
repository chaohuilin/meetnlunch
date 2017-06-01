<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
  /**
   * @Route("/", name="homepage")
   */
  public function indexAction()
  {
    // replace this example code with whatever you need
    return $this->render('WebBundle:homepage:index.html.twig');
  }

  /**
   * @Route("/getting_started", name="getting_started")
   */
  public function gettingstartedAction()
  {
    return $this->render('WebBundle:gettingstarted:index.html.twig');
  }
}
