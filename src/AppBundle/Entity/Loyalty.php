<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loyalty
 *
 * @ORM\Table(name="loyalty")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoyaltyRepository")
 */
class Loyalty
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
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="loyaltyPoints", type="integer")
     */
    private $loyaltyPoints;


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
     * @return Loyalty
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
     * Set loyaltyPoints
     *
     * @param integer $loyaltyPoints
     *
     * @return Loyalty
     */
    public function setLoyaltyPoints($loyaltyPoints)
    {
        $this->loyaltyPoints = $loyaltyPoints;

        return $this;
    }

    /**
     * Get loyaltyPoints
     *
     * @return int
     */
    public function getLoyaltyPoints()
    {
        return $this->loyaltyPoints;
    }
}

