<?php

namespace TEST2\RegistrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="TEST2\RegistrationBundle\Repository\AccountRepository")
 */
class Account
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="TEST2\RegistrationBundle\Entity\City")
     * @ORM\JoinColumn(nullable=false)  //to not allow an account without City
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="TEST2\RegistrationBundle\Entity\Province")
     * @ORM\JoinColumn(nullable=false)  //to not allow an account without Province
     */
    private $province;
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
     * Set name
     *
     * @param string $name
     *
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set city
     *
     * @param \TEST2\RegistrationBundle\Entity\city $city
     *
     * @return Account
     */
    public function setCity(\TEST2\RegistrationBundle\Entity\city $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \TEST2\RegistrationBundle\Entity\city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set province
     *
     * @param \TEST2\RegistrationBundle\Entity\Province $province
     *
     * @return Account
     */
    public function setProvince(\TEST2\RegistrationBundle\Entity\Province $province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \TEST2\RegistrationBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }
}
