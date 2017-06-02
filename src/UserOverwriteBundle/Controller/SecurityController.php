<?php

namespace UserOverwriteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurityController extends BaseController
{
    /**
     * @param Request $request
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginAction(Request $request)
    {
	    $em = $this->get('doctrine')->getManager();
      if ($request->isMethod("POST")) {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $user = $em->getRepository('ApiBundle:User')->findOneBy(array('username' => $username));
        if ($user){
           if (self::checkPassword($password, $user)){
              $token = Request::create('http://localhost:8888/meetnlunch/web/app_dev.php/api/login', 'GET');
              $response = new JsonResponse(array("user" => $user->getUsername()));
              $response->setStatusCode(200);
              return $response;
           }
        }
        return new JsonResponse(array("error" => "username or password failed"));
      }else {
        return new JsonResponse(array("success" => "false"));
      }
    }

    public function checkPassword($password, $user){
      $encoder = $this->get('security.encoder_factory')->getEncoder($user);
      if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
        return true;
      }
    }
}
