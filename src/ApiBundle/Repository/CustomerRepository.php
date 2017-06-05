<?php

namespace ApiBundle\Repository;

/**
 * CustomerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomerRepository extends \Doctrine\ORM\EntityRepository
{
  /**
  * @return string
  **/
  public function getCustomer($age, $gender)
  {
    $query = "";
    if ($gender == "both") {
        $query = "SELECT * FROM customer c WHERE age BETWEEN 18 AND :age AND visible_gender IN('M', 'F') AND visible_age >= :age AND is_visible = true";
    }
    else {
      $query = "SELECT * FROM customer c WHERE age BETWEEN 18 AND :age AND gender = :gender AND visible_age >= :age  AND is_visible = true";
    }
    $params = array(
      "age" => $age,
      "gender" => $gender,
      "visible_gender" => $gender
    );
    $array = $this->getEntityManager()->getConnection()->executeQuery($query, $params)->fetchAll();
    return $array;
  }

  public function setVisibleParams($visible_age, $visible_gender, $customer_id, $position)
  {
    $this->createQueryBuilder('c')
      ->update()
      ->set('c.visibleAge', '?1')
          ->setParameter(1, $visible_age)
      ->set('c.visibleGender', '?2')
          ->setParameter(2, $visible_gender)
      ->set('c.position', '?3')
          ->setParameter(3, $position)
      ->where('c.id = ?4')
          ->setParameter(4, $customer_id)
      ->getQuery()->execute();
  }

}
