<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HistoriqueCoins;
use App\Form\HistoriqueCoinsType;

class UserhistoryController extends AbstractController
{
    /**
     * @Route("/userhistory", name="userhistory")
     */
    public function index(): Response
    {
        $icon = $this->getDoctrine()->getManager()->getRepository(HistoriqueCoins::class)->findAll();
        return $this->render('userhistory/index.html.twig', ['b' => $icon]);
    }

    /**
     * @Route("/useraddcoinhistory", name="useraddcoinhistory")
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
            return $this-> redirectToRoute('userhistory');
        }
        else
            return $this->render('userhistory/create.html.twig',['f'=> $form->createView()]);
    }

    /**
     * @Route("/userDellhistoriqueCoins/{id}", name="userDellhistoriqueCoins")
     */
    public function Delete(HistoriqueCoins $historiqueCoins): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($historiqueCoins);
        $em->flush();
        return $this-> redirectToRoute('userhistory');

    }

    /**
     * @Route("/userupdatehistoriqueCoins/{id}", name="userupdatehistoriqueCoins")
     */
    public function UpdatehistoriqueCoins (Request $request,$id) :Response
    {
        $coin = $this->getDoctrine()->getManager()->getRepository(HistoriqueCoins::class)->find($id);
        $form = $this-> createForm(HistoriqueCoinsType::class,$coin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('userhistory');
        }
        else
            return $this->render('userhistory/update.html.twig',['f'=> $form->createView()]);
    }
}
