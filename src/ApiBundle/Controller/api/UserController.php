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
    * @param int $customer
    * @Route("/users/{id}", name="update_customer")
    */
    public function putUsersAction(Request $request, $id)
    {
      $em = $this->get('doctrine')->getManager();
      $customer = $em
                  ->getRepository('ApiBundle:Customer')
                  ->findOneById($id);
      if (!$customer) {
        throw $this->createNotFoundException(sprintf(
                'No customer found with id "%s"',
                $id
            ));
      }else{
          // translate object to json object
          $encoders = array(new XmlEncoder(), new JsonEncoder());
          $normalizer = new ObjectNormalizer();
          $normalizer->setIgnoredAttributes(array('user'));
          $serializer = new Serializer(array($normalizer), $encoders);


          $form = $this->createForm(CustomerType::class, $customer);
          $data = json_decode($request->getContent(), true);
          $form->submit($data);
          $em->persist($customer);
          $em->flush();
          return new JsonResponse(array("success" => true,
                                        "user" => $serializer->normalize($customer)));
      }
    }
}
