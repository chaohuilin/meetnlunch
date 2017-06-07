<?php

namespace ApiBundle\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FilterController extends FOSRestController
{
  /**
   * @Route("/filter", name="filter")
   */
  public function getFilterAction(Request $request)
  {

    // translate object to json object
    $encoders = array(new XmlEncoder(), new JsonEncoder());
    $normalizer = new ObjectNormalizer();
    $normalizer->setIgnoredAttributes(array('user'));
    $serializer = new Serializer(array($normalizer), $encoders);

    $all_query = $request->query->all();
    $range = $all_query["range"];
    $age = $all_query["wanted_age"];
    $gender = $all_query["wanted_gender"];
    $visible_age = $all_query["visible_age"];
    $visible_gender = $all_query["visible_gender"];
    $customer_id = $all_query["customer_id"];
    $latitude = $all_query["latitude"];
    $longitude = $all_query["longitude"];
    $food = $all_query['food'];
    $em = $this->getDoctrine()->getManager();
    $customers = $em->getRepository("ApiBundle:Customer")->getCustomer($age,$gender, $food);
    $em->getRepository("ApiBundle:Customer")->setVisibleParams($visible_age, $visible_gender, $customer_id, $latitude, $longitude);
    return new JsonResponse(array('customers' => $serializer->normalize($customers)));
  }
}
