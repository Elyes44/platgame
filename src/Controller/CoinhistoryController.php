<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HistoriqueCoins;
use App\Form\HistoriqueCoinsType;

class CoinhistoryController extends AbstractController
{
    /**
     * @Route("/coinhistory", name="coinhistory")
     */
    public function index(): Response
    {
        $icon = $this->getDoctrine()->getManager()->getRepository(HistoriqueCoins::class)->findAll();
        return $this->render('coinhistory/index.html.twig', ['b' => $icon]);
    }

    /**
     * @Route("/addcoinhistory", name="addcoinhistory")
     */
    public function addcoinhistory (Request $request) :Response
    {
        $coin = new HistoriqueCoins();
        $form = $this-> createForm(HistoriqueCoinsType::class,$coin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {
            $em = $this -> getDoctrine()->getManager();
            $em -> persist ($coin);
            $em -> flush();
            return $this-> redirectToRoute('coinhistory');
        }
        else
            return $this->render('coinhistory/create.html.twig',['f'=> $form->createView()]);
    }


    /**
     * @Route("/DellhistoriqueCoins/{id}", name="DellhistoriqueCoins")
     */
    public function Delete(HistoriqueCoins $historiqueCoins): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($historiqueCoins);
        $em->flush();
        return $this-> redirectToRoute('coinhistory');

    }

    /**
     * @Route("/updatehistoriqueCoins/{id}", name="updatehistoriqueCoins")
     */
    public function UpdatehistoriqueCoins (Request $request,$id) :Response
    {
        $coin = $this->getDoctrine()->getManager()->getRepository(HistoriqueCoins::class)->find($id);
        $form = $this-> createForm(HistoriqueCoinsType::class,$coin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('coinhistory');
        }
        else
            return $this->render('coinhistory/update.html.twig',['f'=> $form->createView()]);
    }
}
