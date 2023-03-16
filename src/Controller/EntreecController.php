<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Entreec;
use App\Entity\Produitc;

use App\Form\EntreecType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreecController  extends AbstractController
{
    #[Route('/Entreec/liste', name: 'entreec_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        //$data['produits'] = $em->getRepository(Produit::class)->findAll();
        $e = new Entreec();
        
        $form = $this->createForm(EntreecType::class, $e, 
                                                array('action' => $this->generateUrl('entreec_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['entreecs'] = $em->getRepository(Entreec::class)->findAll();
        return $this->render('entreec/liste.html.twig', $data);
    }

    #[route('/Entreec/edit/{id}', name: 'entreec_edit')]
    public function getentree($id): Response
    {
        return $this->render('entreec/liste.html.twig');
    }

    #[route('/Entreec/add', name: 'entreec_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $e = new Entreec();
       
        $form = $this->createForm(EntreecType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $e= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($e);
            $em->flush();
            //mise a jour produit
            $p = $em->getRepository(Produitc::class)->find($e->getProduit()->getId());
            $stock = $p->getQtStock() + $e->getQtE();
            $p->setQtStock($stock);
            $em->flush();

        }
       
        return $this->redirectToRoute('entreec_liste');
    }

    #[route('/Entreec/delete/{id}', name: 'entreec_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $entree = $em->getRepository(Entreec::class)->find($id);
        if ($entree != null) {
            $em->remove($entree);
            $em->flush();
        }
        return $this->redirectToRoute('entreec_liste');
       
    }

    #[route('/Entreec/edit/{id}', name: 'entreec_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $ent = $em->getRepository(Entreec::class)->find($id);
     
       
        $form = $this->createForm(EntreecType::class, $ent, 
                                                array('action' => $this->generateUrl('entreec_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['entreecs'] = $em->getRepository(Entreec::class)->findAll();
        return $this->render('entreec/liste.html.twig', $data);
      
    }

    #[route('/Entreec/update/{id}', name: 'entreec_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $e = new Entreec();
        $form = $this->createForm(EntreecType::class, $e);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            $e->setUser($this->getUser()); // en cas de blem delete this line 
            $e->setId($id);
            $em = $doctrine->getManager();
            $entree = $em->getRepository(Entreec::class)->find($id);
            $entree->setDateE($e->getDateE());
            $entree->setProduit($e->getProduit());
            $entree->setCategorie($e->getCategorie());
            $entree->setQtE($e->getQtE());
            $em->flush();
        }  

        return $this->redirectToRoute('entreec_liste');
    }
   
}
