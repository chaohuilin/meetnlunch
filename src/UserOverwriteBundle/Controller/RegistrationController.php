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

use ApiBundle\Entity\Customer;
use ApiBundle\Form\CustomerType;

class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     * @Route("/register", name="register")
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');

        $form = $this->createForm(CustomerType::class);
        $form->handleRequest($request);
        if ($request->isMethod("POST")) {
          $usernameResponse = self::fillUsername($username, $user);
          $passwordResponse = self::cryptPassword($password, $user);
          $emailResponse = self::fillEmail($email, $user);
          if ( $usernameResponse == "" &&
               $passwordResponse == "" &&
               $emailResponse == ""){
               $user->setUsername($username);
               $user->setEmail($email);
               $user->setEnabled(true);

                // create Customer
                $customer = new Customer();
                $customer->setAge($request->request->get('age'));
                $customer->setGender($request->request->get('gender'));
                $customer->setUser($user);
                $userManager->updateUser($user);
      	        $em->persist($customer);
      	        $em->flush();
                $currentCustomer = $em->getRepository("ApiBundle:Customer")->findOneByUser($user);
                $response = new JsonResponse(array("success" => true, "customer" => array(
                  "age" => $currentCustomer->getAge(),
                  "gender" => $currentCustomer->getGender(),
                  "description" => $currentCustomer->getDescription(),
                  "contact" => $currentCustomer->getContact(),
                  "visibleAge" => $currentCustomer->getVisibleAge(),
                  "visibleGender" => $currentCustomer->getVisibleGender(),
                  "showAge" => $currentCustomer->getShowAge(),
                  "showGender" => $currentCustomer->getShowGender(),
                  "isVisible" => $currentCustomer->getIsVisible()
                ) ));
                $response->setStatusCode(200);
                return $response;
            }
          }
        $response = new JsonResponse(array("success" => false,
                                           "message" => array(
                                             "username" => $usernameResponse,
                                             "password" => $passwordResponse,
                                             "email" => $emailResponse),
                                             "errors" => $form->getErrors()
                                           ));
        $response->setStatusCode(400);
        return $response;
    }

    public function cryptPassword($password, $user){
      if ($password){
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
        $user->setSalt($salt);
        $hashedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($hashedPassword);
        return ("");
      }
      return ("password missing");
    }

    public function fillUsername($username, $user){
      $em = $this->getDoctrine()->getManager();
      if ($username){
        $existUser = $em->getRepository("ApiBundle:User")->findByUsername($username);
        if ($existUser)
          return ("user already exist");
        return ("");
      }else{
          return ("username missing");
      };
    }

    public function fillEmail($email, $user){
      $em = $this->getDoctrine()->getManager();
      if ($email){
        $email = $em->getRepository("ApiBundle:User")->findByEmail($email);
        if ($email)
          return ("email already exist");
        return ("");
      }else{
        return ("email missing");
      };
    }
}
