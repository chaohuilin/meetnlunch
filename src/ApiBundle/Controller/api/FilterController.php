<?php

namespace ApiBundle\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;

class FilterController extends FOSRestController
{
  /**
   * @Route("/filter", name="filter")
   */
  public function getFilterAction(Request $request)
  {
    $all_query = $request->query->all();
    $range = $all_query["range"];
    $food_id = $all_query["food_id"];
    $age = $all_query["wanted_age"];
    $gender = $all_query["wanted_gender"];
    $visible_age = $all_query["visible_age"];
    $visible_gender = $all_query["visible_gender"];
    $customer_id = $all_query["customer_id"];
    $lagitude = $all_query["lagitude"];
    $longitude = $all_query["longitude"];
    $em = $this->getDoctrine()->getManager();
    $food = $em->getRepository("ApiBundle:Food")->getFood($food_id);
    $customers = json_encode(array("customers" => $em->getRepository("ApiBundle:Customer")->getCustomer($age, $gender)));
    $em->getRepository("ApiBundle:Customer")->setVisibleParams($visible_age, $visible_gender, $customer_id, $lagitude, $longitude);

    return new Response($customers);
  }
}
