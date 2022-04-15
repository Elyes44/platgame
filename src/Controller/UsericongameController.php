<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Icoingame;
use App\Form\IconGameType;

class UsericongameController extends AbstractController
{
    /**
     * @Route("/usericongame", name="usericongame")
     */
    public function index(): Response
    {
        $icon = $this->getDoctrine()->getManager()->getRepository(Icoingame::class)->findAll();
        return $this->render('usericongame/index.html.twig', ['b' => $icon]);
    }

    /**
     * @Route("/useraddicongame", name="useraddicongame")
     */
    public function addicongame (Request $request) :Response
    {
        $coin = new Icoingame();
        $form = $this-> createForm(IconGameType::class,$coin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> persist ($coin);
            $em -> flush();
            return $this-> redirectToRoute('usericongame');
        }
        else
            return $this->render('usericongame/create.html.twig',['f'=> $form->createView()]);
    }

    /**
     * @Route("/userdelicongame/{id}", name="userdelicongame")
     */
    public function Delete(Icoingame $icongame): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($icongame);
        $em->flush();
        return $this-> redirectToRoute('usericongame');

    }

    /**
     * @Route("/userupdateicongame/{id}", name="userupdateicongame")
     */
    public function UpdateReclamation (Request $request,$id) :Response
    {
        $coin = $this->getDoctrine()->getManager()->getRepository(Icoingame::class)->find($id);
        $form = $this-> createForm(IconGameType::class,$coin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('usericongame');
        }
        else
            return $this->render('usericongame/update.html.twig',['f'=> $form->createView()]);
    }
}
