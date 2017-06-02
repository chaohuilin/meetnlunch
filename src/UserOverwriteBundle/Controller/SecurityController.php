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
use GuzzleHttp\Client;

class SecurityController extends BaseController
{
    /**
     * @param Request $request
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginAction(Request $request)
    {
      $client_id = $request->request->get('client_id');
      $client_secret = $request->request->get('client_secret');
      $host = $request->request->get('host');
      $username = $request->request->get('username');
      $password = $request->request->get('password');
      $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://meetnlunchapp.herokuapp.com',
        // You can set any number of default request options.
        'timeout'  => 20.0,
      ]);
      $response = $client->request('POST', "/oauth/v2/token", [
        'json' => [
          'grant_type' => "password",
          'client_id'  => $client_id,
          'client_secret' => $client_secret,
          'username' => $username,
          'password' => $password,
        ]
      ]);

      $data = json_decode($response->getBody());
      return new JsonResponse($data);
    }

    public function checkPassword($password, $user){
      $encoder = $this->get('security.encoder_factory')->getEncoder($user);
      if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
        return true;
      }
    }
}
