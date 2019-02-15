<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Winning
 *
 * @ORM\Table(name="winning")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WinningRepository")
 */
class Winning
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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="win_category", type="string", length=255)
     */
    private $winCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="win_item", type="string", length=255)
     */
    private $winItem;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status = true;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="date_time", type="string", length=255)
     */
    private $dateTime;


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
     * @return Winning
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
     * Set winCategory
     *
     * @param string $winCategory
     *
     * @return Winning
     */
    public function setWinCategory($winCategory)
    {
        $this->winCategory = $winCategory;

        return $this;
    }

    /**
     * Get winCategory
     *
     * @return string
     */
    public function getWinCategory()
    {
        return $this->winCategory;
    }

    /**
     * Set winItem
     *
     * @param string $winItem
     *
     * @return Winning
     */
    public function setWinItem($winItem)
    {
        $this->winItem = $winItem;

        return $this;
    }

    /**
     * Get winItem
     *
     * @return string
     */
    public function getWinItem()
    {
        return $this->winItem;
    }

    /**
     * Set dateTime
     *
     * @param string $dateTime
     *
     * @return Winning
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return string
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }
}

