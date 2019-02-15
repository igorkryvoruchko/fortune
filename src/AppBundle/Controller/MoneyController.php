<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Winning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Unirest;

class MoneyController extends Controller
{
    /**
     * @Route("/moneytobank/{code}", name="moneytobank")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function moneyToBankAction($code)
    {
        $userId = $this->getUser()->getId();
        $winnings = $this->getDoctrine()->getRepository(Winning::class)->findAllWinnings($userId);
        $totalMoney = 0;

        foreach ($winnings as $win) {
            switch ($win->getWinCategory()) {
                case "money":
                    $totalMoney += $win->getWinItem();
                    break;
            }
        }
        $headers = array('Accept' => 'application/json');
        $query = array($code);

        $response = Unirest\Request::get('https://jsonplaceholder.typicode.com/todos/',$headers, $query);
        if($response->code == 200) {
            foreach ($winnings as $win) {
                switch ($win->getWinCategory()) {
                    case "money":
                        $entityManager = $this->getDoctrine()->getManager();
                        $win = $entityManager->getRepository(Winning::class)->find($win->getId());
                        $win->setStatus(false);
                        $entityManager->flush();
                        break;
                }
            }
            return $this->redirectToRoute('homepage');
        } else {
            return new Response("Error with your account!!!");
        }
    }
}
