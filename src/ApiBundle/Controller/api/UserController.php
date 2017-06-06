<?php

namespace ApiBundle\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use ApiBundle\Entity\Customer;
use ApiBundle\Form\CustomerType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class UserController extends FOSRestController
{

    /**
    * @Route("/users", name="list_customer")
    */
    public function getUsersAction(Request $request)
    {
      $em = $this->get('doctrine')->getManager();
      $customers = $em->getRepository('ApiBundle:Customer')->findAll();

      // translate object to json object
      $encoders = array(new XmlEncoder(), new JsonEncoder());
      $normalizer = new ObjectNormalizer();
      $normalizer->setIgnoredAttributes(array('user'));
      $serializer = new Serializer(array($normalizer), $encoders);
      return new JsonResponse(array("success" => true,
                                    "customers" => $serializer->normalize($customers)));
    }

    /**
    * @Route("/users/{id}", name="update_customer")
    */
    public function putUsersAction(Request $request, $id)
    {
      $user = $this->getUser();
      $em = $this->get('doctrine')->getManager();
      $customer = $em->getRepository('ApiBundle:Customer')->findOneById($id);
      if (!$customer) {
        return new JsonResponse(array("error" => "customer doesn't exist"));
      }elseif ($customer->getUser() !== $user) {
        return new JsonResponse(array("error" => "token and Customer id doesn\'t match"));
      }else{
          // translate object to json object
          $encoders = array(new XmlEncoder(), new JsonEncoder());
          $normalizer = new ObjectNormalizer();
          $normalizer->setIgnoredAttributes(array('user'));
          $serializer = new Serializer(array($normalizer), $encoders);

          $form = $this->createForm(CustomerType::class, $customer);
          $data = json_decode($request->getContent(), true);
          $form->submit($data, false);
          $em->persist($customer);
          $em->flush();
          return new JsonResponse(array("success" => true,
                                        "user" => $serializer->normalize($customer)));
      }
    }
}
