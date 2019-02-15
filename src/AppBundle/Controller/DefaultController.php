<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Winning;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction(Request $request)
    {
        $prizes = ["phone", "car", "boeing 777"];
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:main.html.twig', array(
            "prizes" => $prizes
        ));
    }


    public function winAction(Request $request)
    {
        if($request->request->get('userId')){
            $entityManager = $this->getDoctrine()->getManager();
            $winning = new Winning();
            $winning->setUserId($request->request->get('userId'));
            $winning->setWinCategory($request->request->get('category'));
            $winning->setWinItem($request->request->get('item'));
            $winning->setDateTime(date("Y-m-d H:i:s"));

            $entityManager->persist($winning);
            $entityManager->flush();

            return new JsonResponse("Winnings added successfully");
        }

    }
}
