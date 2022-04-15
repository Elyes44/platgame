<?php

namespace App\Controller;

use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="appreclamation")
     */
    public function index(): Response
    {
        $rec = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamation/index.html.twig', ['b' => $rec]);
    }

    /**
     * @Route("/addreclamation", name="addreclamation")
     */
    public function addreclamation (Request $resquest) :Response
    {
        $rec = new Reclamation();
        $form = $this-> createForm(ReclamationType::class,$rec);
        $form->handleRequest($resquest);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> persist ($rec);
            $em -> flush();
            return $this-> redirectToRoute('appreclamation');
        }
        else
            return $this->render('reclamation/create.html.twig',['f'=> $form->createView()]);
    }

    /**
     * @Route("/delreclamation/{id}", name="delreclamation")
     */
    public function Delete(Reclamation $reclamation): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this-> redirectToRoute('appreclamation');

    }

    /**
     * @Route("/updatereclamation/{id}", name="updatereclamation")
     */
    public function UpdateReclamation (Request $request,$id) :Response
    {
        $rec = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);
        $form = $this-> createForm(ReclamationType::class,$rec);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('appreclamation');
        }
        else
            return $this->render('reclamation/update.html.twig',['f'=> $form->createView()]);
    }
}
