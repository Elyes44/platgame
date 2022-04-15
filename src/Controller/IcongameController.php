<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Icoingame;
use App\Form\IconGameType;

class IcongameController extends AbstractController
{
    /**
     * @Route("/icongame", name="icongame")
     */
    public function index(): Response
    {
        $icon = $this->getDoctrine()->getManager()->getRepository(Icoingame::class)->findAll();
        return $this->render('icongame/index.html.twig', ['b' => $icon]);
    }


    /**
     * @Route("/addicongame", name="addicongame")
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
            return $this-> redirectToRoute('icongame');
        }
        else
            return $this->render('icongame/create.html.twig',['f'=> $form->createView()]);
    }

    /**
     * @Route("/delicongame/{id}", name="delicongame")
     */
    public function Delete(Icoingame $icongame): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($icongame);
        $em->flush();
        return $this-> redirectToRoute('icongame');

    }

    /**
     * @Route("/updateicongame/{id}", name="updateicongame")
     */
    public function UpdateReclamation (Request $request,$id) :Response
    {
        $coin = $this->getDoctrine()->getManager()->getRepository(Icoingame::class)->find($id);
        $form = $this-> createForm(IconGameType::class,$coin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('icongame');
        }
        else
            return $this->render('icongame/update.html.twig',['f'=> $form->createView()]);
    }
}
