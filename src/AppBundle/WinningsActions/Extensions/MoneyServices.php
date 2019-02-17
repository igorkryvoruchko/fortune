<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 17.02.19
 * Time: 20:04
 */

namespace AppBundle\WinningsActions\Extensions;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Container;

class MoneyServices
{

    protected $em;
    private $container;

    // We need to inject this variables later.
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }


    public function setStatusFalseWinnings($winnings) {
        foreach ($winnings as $win) {
            $id =$win->getId();
            $qb = $this->em->createQuery(
                "UPDATE AppBundle:Winning u SET u.status = false WHERE u.id= $id"
            )->getResult(); // update all money winnings to false
        }
        return true;
    }


}