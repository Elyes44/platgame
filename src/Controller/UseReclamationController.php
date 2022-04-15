<?php

namespace App\Controller;

use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;

class UseReclamationController extends AbstractController
{
    /**
     * @Route("/usereclamation", name="usereclamation")
     */
    public function index(): Response
    {
        $rec = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('use_reclamation/index.html.twig', ['b' => $rec]);
    }

    /**
     * @Route("/useraddreclamation", name="useraddreclamation")
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
            return $this-> redirectToRoute('usereclamation');
        }
        else
            return $this->render('use_reclamation/create.html.twig',['f'=> $form->createView()]);
    }

    /**
     * @Route("/userdelreclamation/{id}", name="userdelreclamation")
     */
    public function Delete(Reclamation $reclamation): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this-> redirectToRoute('usereclamation');

    }

    /**
     * @Route("/userupdatereclamation/{id}", name="userupdatereclamation")
     */
    public function UpdateReclamation (Request $request,$id) :Response
    {
        $rec = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);
        $form = $this-> createForm(ReclamationType::class,$rec);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('usereclamation');
        }
        else
            return $this->render('use_reclamation/update.html.twig',['f'=> $form->createView()]);
    }
}
