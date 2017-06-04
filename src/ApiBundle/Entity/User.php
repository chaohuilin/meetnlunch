<?php
// src/Acme/ApiBundle/Entity/User.php

namespace ApiBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table("users")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
      * @ORM\OneToMany(targetEntity="Customer", mappedBy="User")
      * @ORM\OrderBy({"name" = "ASC"})
    */
    private $customer;

    /**
    * @var string
    *
    * @ORM\Column(name="resetToken", type="string" ,length=255, nullable=true)
    *
    */
    private $resetToken;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add customer
     *
     * @param \ApiBundle\Entity\Customer $customer
     *
     * @return User
     */
    public function addCustomer(\ApiBundle\Entity\Customer $customer)
    {
        $this->customer[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \ApiBundle\Entity\Customer $customer
     */
    public function removeCustomer(\ApiBundle\Entity\Customer $customer)
    {
        $this->customer->removeElement($customer);
    }

    /**
     * Get customer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set resetToken
     *
     * @param string $resetToken
     *
     * @return User
     */
    public function setResetToken($resetToken)
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * Get resetToken
     *
     * @return string
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }
}
