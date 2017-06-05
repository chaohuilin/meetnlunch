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
     * @ORM\OneToOne(targetEntity="User", inversedBy="customer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     * @ORM\OrderBy({"startAt" = "DESC"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
    * @var string
    *
    * @ORM\Column(name="visible_age", type="string", nullable=true)
    */
    private $visibleAge = "0-99";

    /**
    * @var string
    *
    * @ORM\Column(name="visible_gender", type="string" ,length=255)
    */
    private $visibleGender = "both";

    /**
    * @var boolean
    *
    * @ORM\Column(name="show_age", type="boolean")
    */
    private $showAge = false;

    /**
    * @var boolean
    *
    * @ORM\Column(name="show_gender", type="boolean")
    */
    private $showGender = false;

    /**
    * @var boolean
    *
    * @ORM\Column(name="is_visible", type="boolean")
    */
    private $isVisible = true;


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
     * @return integer
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
     * Set visibleAge
     *
     * @param string $visibleAge
     *
     * @return Customer
     */
    public function setVisibleAge($visibleAge)
    {
        $this->visibleAge = $visibleAge;

        return $this;
    }

    /**
     * Get visibleAge
     *
     * @return string
     */
    public function getVisibleAge()
    {
        return $this->visibleAge;
    }

    /**
     * Set visibleGender
     *
     * @param string $visibleGender
     *
     * @return Customer
     */
    public function setVisibleGender($visibleGender)
    {
        $this->visibleGender = $visibleGender;

        return $this;
    }

    /**
     * Get visibleGender
     *
     * @return string
     */
    public function getVisibleGender()
    {
        return $this->visibleGender;
    }

    /**
     * Set showAge
     *
     * @param boolean $showAge
     *
     * @return Customer
     */
    public function setShowAge($showAge)
    {
        $this->showAge = $showAge;

        return $this;
    }

    /**
     * Get showAge
     *
     * @return boolean
     */
    public function getShowAge()
    {
        return $this->showAge;
    }

    /**
     * Set showGender
     *
     * @param boolean $showGender
     *
     * @return Customer
     */
    public function setShowGender($showGender)
    {
        $this->showGender = $showGender;

        return $this;
    }

    /**
     * Get showGender
     *
     * @return boolean
     */
    public function getShowGender()
    {
        return $this->showGender;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return Customer
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Set user
     *
     * @param \ApiBundle\Entity\User $user
     *
     * @return Customer
     */
    public function setUser(\ApiBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ApiBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
