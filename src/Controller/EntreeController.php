<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Entree;
use App\Entity\Produit;

use App\Form\EntreeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreeController  extends AbstractController
{
    #[Route('/Entree/liste', name: 'entree_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        //$data['produits'] = $em->getRepository(Produit::class)->findAll();
        $e = new Entree();
        
        $form = $this->createForm(EntreeType::class, $e, 
                                                array('action' => $this->generateUrl('entree_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['entrees'] = $em->getRepository(Entree::class)->findAll();
        return $this->render('entree/liste.html.twig', $data);
    }

    #[route('/Entree/edit/{id}', name: 'entree_edit')]
    public function getentree($id): Response
    {
        return $this->render('entree/liste.html.twig');
    }

    #[route('/Entree/add', name: 'entree_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $e = new Entree();
       
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $e= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($e);
            $em->flush();
            //mise a jour produit
            $p = $em->getRepository(Produit::class)->find($e->getProduit()->getId());
            $stock = $p->getQtStock() + $e->getQtE();
            $p->setQtStock($stock);
            $em->flush();

        }
       
        return $this->redirectToRoute('entree_liste');
    }

    #[route('/Entree/delete/{id}', name: 'entree_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $entree = $em->getRepository(Entree::class)->find($id);
        if ($entree != null) {
            $em->remove($entree);
            $em->flush();
        }
        return $this->redirectToRoute('entree_liste');
       
    }

    #[route('/Entree/edit/{id}', name: 'entree_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $ent = $em->getRepository(Entree::class)->find($id);
     
       
        $form = $this->createForm(EntreeType::class, $ent, 
                                          array('action' => $this->generateUrl('entree_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['entrees'] = $em->getRepository(Entree::class)->findAll();
        return $this->render('entree/liste.html.twig', $data);
      
    }

    #[route('/Entree/update/{id}', name: 'entree_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $e = new Entree();
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            $e->setUser($this->getUser()); // en cas de blem delete this line 
            $e->setId($id);
            $em = $doctrine->getManager();
            $entree = $em->getRepository(Entree::class)->find($id);
            $entree->setDateE($e->getDateE());
            $entree->setProduit($e->getProduit());
            $entree->setCategorie($e->getCategorie());
            $entree->setQtE($e->getQtE());

            $em->flush();


        }
       
        return $this->redirectToRoute('entree_liste');
    }

   
}
