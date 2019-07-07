<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prizes
 *
 * @ORM\Table(name="prizes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrizesRepository")
 */
class Prizes
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
     * @ORM\Column(name="prize", type="string", length=255, unique=true)
     */
    private $prize;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
     * Set prize
     *
     * @param string $prize
     *
     * @return Prizes
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;

        return $this;
    }

    /**
     * Get prize
     *
     * @return string
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Prizes
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }
}

