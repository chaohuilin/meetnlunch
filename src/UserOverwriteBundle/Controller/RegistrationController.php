<?php

namespace UserOverwriteBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     * @Route("/register", name="register")
     * @return Response
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        if ($request->isMethod("POST")) {
          $password = $request->request->get('password');
          self::cryptPassword($password, $user);
          $user->setUsername($request->request->get('username'));
          $user->setEmail($request->request->get('email'));
          $user->setEnabled(true);
          $userManager->updateUser($user);
          $response = new JsonResponse(array("success" => true));
          $response->setStatusCode(200);
          return $response;
        }
        $response = new JsonResponse(array("success" => false, "error" => $form->isSubmitted()));
        $response->setStatusCode(200);
        return $response;
    }

    public function cryptPassword($password, $user){
      $encoder = $this->get('security.encoder_factory')->getEncoder($user);
      $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
      $user->setSalt($salt);
      $hashedPassword = $encoder->encodePassword($password, $user->getSalt());
      $user->setPassword($hashedPassword);
    }
}
