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
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="food", type="integer")
     */
    private $food = 1;

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
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
    * @var integer
    *
    * @ORM\Column(name="wanted_age", type="integer", nullable=true)
    */
    private $wantedAge = 50;

    /**
    * @var string
    *
    * @ORM\Column(name="wanted_gender", type="string", nullable=true)
    */
    private $wantedGender = 'both';

    /**
    * @var integer
    *
    * @ORM\Column(name="visibility_range", type="integer", nullable=true)
    */
    private $visibilityRange = 1;

    /**
    * @var integer
    *
    * @ORM\Column(name="visible_age", type="integer", nullable=true)
    */
    private $visibleAge = 50;

    /**
    * @var string
    *
    * @ORM\Column(name="visible_gender", type="string", nullable=true)
    */
    private $visibleGender = 'both';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description= '';

    /**
    * @var integer
    *
    * @ORM\Column(name="longitude", type="integer", nullable=true)
    */
    private $longitude = 0;

    /**
    * @var integer
    *
    * @ORM\Column(name="lagitude", type="integer", nullable=true)
    */
    private $lagitude = 0;

    /**
    * @var boolean
    *
    * @ORM\Column(name="show_age", type="boolean")
    */
    private $showAge = false;

    /**
    * @var boolean
    *
    * @ORM\Column(name="is_visible", type="boolean")
    */
    private $isVisible = true;

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
     * @param integer $age
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
     * @return integer
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

    /**
     * Set wantedAge
     *
     * @param integer $wantedAge
     *
     * @return Customer
     */
    public function setWantedAge($wantedAge)
    {
        $this->wantedAge = $wantedAge;

        return $this;
    }

    /**
     * Get wantedAge
     *
     * @return integer
     */
    public function getWantedAge()
    {
        return $this->wantedAge;
    }

    /**
     * Set wantedGender
     *
     * @param string $wantedGender
     *
     * @return Customer
     */
    public function setWantedGender($wantedGender)
    {
        $this->wantedGender = $wantedGender;

        return $this;
    }

    /**
     * Get wantedGender
     *
     * @return string
     */
    public function getWantedGender()
    {
        return $this->wantedGender;
    }

    /**
     * Set longitude
     *
     * @param integer $longitude
     *
     * @return Customer
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return integer
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lagitude
     *
     * @param integer $lagitude
     *
     * @return Customer
     */
    public function setLagitude($lagitude)
    {
        $this->lagitude = $lagitude;

        return $this;
    }

    /**
     * Get lagitude
     *
     * @return integer
     */
    public function getLagitude()
    {
        return $this->lagitude;
    }


    /**
     * Set food
     *
     * @param integer $food
     *
     * @return Customer
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return integer
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Set visibilityRange
     *
     * @param integer $visibilityRange
     *
     * @return Customer
     */
    public function setVisibilityRange($visibilityRange)
    {
        $this->visibilityRange = $visibilityRange;

        return $this;
    }

    /**
     * Get visibilityRange
     *
     * @return integer
     */
    public function getVisibilityRange()
    {
        return $this->visibilityRange;
    }
}
