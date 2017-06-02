<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", unique=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
    * @var integer
    *
    * @ORM\Column(name="visible_age", type="integer")
    */
    private $visibleAge;

    /**
    * @var string
    *
    * @ORM\Column(name="visible_gender", type="string" , length=255)
    */
    private $visibleGender;

    /**
    * @var boolean
    *
    * @ORM\Column(name="show_age", type="boolean", options={"default" : true})
    */
    private $showAge;

    /**
    * @var boolean
    *
    * @ORM\Column(name="show_gender", type="boolean", options={"default" : true})
    */
    private $showGender;

    /**
    * @var boolean
    *
    * @ORM\Column(name="is_visible", type="boolean", options={"default" : true})
    */
    private $isVisible;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Customer
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Customer
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Customer
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Customer
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Customer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Customer
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set visible age
     *
     * @param string $age
     *
     * @return Customer
     */
    public function setVisibleAge($age)
    {
        $this->visibleAge = $age;

        return $this;
    }

    /**
     * Get visible_age
     *
     * @return string
     */
    public function getVisibleAge()
    {
        return $this->visibleAge;
    }

    /**
     * Set visible gender
     *
     * @param string $gender
     *
     * @return Customer
     */
    public function setVisibleGender($gender)
    {
        $this->visibleGender = $gender;

        return $this;
    }

    /**
     * Get visible_age
     *
     * @return string
     */
    public function getVisibleGender()
    {
        return $this->visibleGender;
    }

    /**
     * Set show gender
     *
     * @param boolean $gender
     *
     * @return Customer
     */
    public function setShowGender($gender)
    {
        $this->showGender = $gender;

        return $this;
    }

    /**
     * Get show_gender
     *
     * @return boolean
     */
    public function getShowGender()
    {
        return $this->showGender;
    }

    /**
     * Set show age
     *
     * @param boolean $gender
     *
     * @return Customer
     */
    public function setShowAge($gender)
    {
        $this->showAge = $gender;

        return $this;
    }

    /**
     * Get show_age
     *
     * @return boolean
     */
    public function getShowAge()
    {
        return $this->showAge;
    }

    /**
     * Set is visible
     *
     * @param boolean $gender
     *
     * @return Customer
     */
    public function setIsVisible($gender)
    {
        $this->isVisible = $gender;

        return $this;
    }

    /**
     * Get is visible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }
}
