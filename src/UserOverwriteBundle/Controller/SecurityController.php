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
      $route = $request->getScheme() . '://' .$request->getHttpHost();
      $client_id = $request->query->get('client_id');
      $client_secret = $request->query->get('client_secret');
      $host = $request->request->get('host');
      $username = $request->request->get('username');
      $password = $request->request->get('password');
      if ($client_id && $client_secret){
        $client = new Client([
          // Base URI is used with relative requests
          'base_uri' => $route,
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
      return new JsonResponse(array("success" => false, "message" => "params missing"));
    }

    /**
     * @param Request $request
     * @Route("/forgot", name="forgot_password")
     * @return Response
     */
    public function forgotPasswordAction(Request $request){

        $username = $request->request->get('username');
        $em = $this->getDoctrine()->getManager();
        if ($username){
          $user = $em->getRepository("ApiBundle:User")->findOneByUsername($username);
          if ($user){
            $email = $user->getEmail();
            if (!$user->getResetToken()){
              $resetToken = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
              $user->setResetToken($resetToken);
              $em->persist($user);
              $em->flush();
            }
            $message = new \Swift_Message('Forgot password');
            $message->setFrom('noreply.meetnlunch@gmail.com')
            ->setTo($email)
            ->setBody(
            $this->renderView(
            // app/Resources/views/Emails/registration.html.twig
            'Emails/password_forgot.html.twig',
            array('username' => $user->getUsername(),
            'token' => $user->getResetToken())
          ),
          'text/html');
          $this->get('mailer')->send($message);
          return new JsonResponse(array('success' => true));
        }
      }
      return new JsonResponse("Username missing");

    }

    public function checkPassword($password, $user){
      $encoder = $this->get('security.encoder_factory')->getEncoder($user);
      if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
        return true;
      }
    }
}
