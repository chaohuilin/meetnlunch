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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SecurityController extends BaseController
{
    /**
     * @param Request $request
     * @Route("/login", name="login")
     * @return Response
     */
    public function loginAction(Request $request)
    {

      // translate object to json object
      $encoders = array(new XmlEncoder(), new JsonEncoder());
      $normalizer = new ObjectNormalizer();
      $normalizer->setIgnoredAttributes(array('user'));
      $serializer = new Serializer(array($normalizer), $encoders);

      $em = $this->getDoctrine()->getManager();
      $route = $request->getScheme() . '://' .$request->getHttpHost();
      $client_id = $request->query->get('client_id');
      $client_secret = $request->query->get('client_secret');
      $host = $request->request->get('host');
      $username = $request->request->get('username');
      $password = $request->request->get('password');
      $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $route,
        // You can set any number of default request options.
        'timeout'  => 20.0,
      ]);
      $response = $client->request('POST', "/meetnlunch/web/app_dev.php/oauth/v2/token", [
        'json' => [
          'grant_type' => "password",
          'client_id'  => $client_id,
          'client_secret' => $client_secret,
          'username' => $username,
          'password' => $password,
        ]
      ]);

// <<<<<<< Updated upstream
//       if ($client_id && $client_secret){
//         $client = new Client([
//           // Base URI is used with relative requests
//           'base_uri' => $route,
//           // You can set any number of default request options.
//           'timeout'  => 20.0,
//         ]);
//         $response = $client->request('POST', "/oauth/v2/token", [
//           'json' => [
//             'grant_type' => "password",
//             'client_id'  => $client_id,
//             'client_secret' => $client_secret,
//             'username' => $username,
//             'password' => $password,
//           ]
//         ]);
//         $data = json_decode($response->getBody());
//         $user = $em->getRepository('ApiBundle:User')->findOneByUsername($username);
//         if ($user)
//           $customer =  $em->getRepository('ApiBundle:Customer')->findOneByUser($user);
//         return new JsonResponse(array("token"  => $data,
//                                       'user'   => $serializer->normalize($customer)
//                                     ));
//       }
//       return new JsonResponse(array("success" => false, "message" => "params missing"));
// =======
      $data = json_decode($response->getBody());
      return new JsonResponse($data);
// >>>>>>> Stashed changes
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

    /**
     * @param Request $request
     * @Route("/forgot/check", name="forgot_password_check")
     * @return Response
     */
    public function checkForgotPasswordTokenAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $username = $request->request->get('username');
      $token = $request->request->get('token');
      $user = $em->getRepository("ApiBundle:User")->findOneBy(array(
                                                  'username' => $username,
                                                  'resetToken' => $token
      ));
      if ($user){
        return new JsonResponse(array('success' => true));
      }
      return new JsonResponse(array('success' => false));
    }

    /**
     * @param Request $request
     * @Route("/forgot/reset", name="forgot_password_reset")
     * @return Response
     */
    public function resetPasswordTokenAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $username = $request->request->get('username');
      $password = $request->request->get('password');
      $user = $em->getRepository("ApiBundle:User")->findOneByUsername($username);
      if ($user && $password){
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $hashedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();
        return new JsonResponse(array('success' => true));
      }
      return new JsonResponse(array('success' => false, 'message' => 'params missing'));
    }

    public function checkPassword($password, $user){
      $encoder = $this->get('security.encoder_factory')->getEncoder($user);
      if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
        return true;
      }
    }
}
