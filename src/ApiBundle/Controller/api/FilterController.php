<?php

namespace ApiBundle\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;

class FilterController extends FOSRestController
{
  /**
   * @Route("/filter", name="filter")
   */
  public function getFiltersAction(Request $request)
  {
    $all_query = $request->query->all();
    $range = $all_query["range"];
    $food_id = $all_query["food_id"];
    $age = $all_query["age"];
    $gender = $all_query["gender"];
    $visible_age = $all_query["visible_age"];
    $visible_gender = $all_query["visible_gender"];
    $user_id = $all_query["user_id"];
    $position = $all_query["position"];
    $em = $this->getDoctrine()->getManager();
    $food = $em->getRepository("ApiBundle:Food")->getFood($food_id);
    $customers = $em->getRepository("ApiBundle:Customer")->getCustomer($age, $gender);
    $toto = $em->getRepository("ApiBundle:Customer")->setVisibleParams($visible_age, $visible_gender, $user_id, $position);
    return new JsonResponse($customers);
  }
}
