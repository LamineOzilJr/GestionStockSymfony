<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\Frameworkbundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[route('/Produit/liste', name: 'produit_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $p = new Produit(); 
        $form = $this->createForm(ProduitType::class, $p, 
                                                array('action' => $this->generateUrl('produit_add'))
                                );
        $data['form'] = $form->createView();
        
        $data['produits'] = $em->getRepository(Produit::class)->findAll();
        return $this->render('produit/liste.html.twig', $data);
    }

    #[route('/Produit/edit/{id}', name: 'produit_edit')]
    public function getproduit($id): Response
    {
        return $this->render('produit/liste.html.twig');
    }

    #[route('/Produit/add', name: 'produit_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $p = new Produit();
        $form = $this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p= $form->getData();
            
            $em = $doctrine->getManager();
            $em->persist($p);
            $em->flush();

            // return $this->redirectToRoute('task_success');
        }
        // $p->setlibelle("clavier");
        // $p->setqtstock(0.0);

        // $em = $doctrine->getManager();
        // $em->persist($p);
        // $em->flush();
        return $this->redirectToRoute('produit_liste');
    }

    #[route('/Produit/delete/{id}', name: 'produit_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        if ($produit != null) {
            $em->remove($produit);
            $em->flush();
        }
        return $this->redirectToRoute('produit_liste');

    }

    #[route('/Produit/edit/{id}', name: 'produit_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $p = $em->getRepository(Produit::class)->find($id);
        $form = $this->createForm(ProduitType::class, $p, 
                                                array('action' => $this->generateUrl('produit_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['produits'] = $em->getRepository(Produit::class)->findAll();
        return $this->render('produit/liste.html.twig', $data);
      
    }

    #[route('/Produit/update/{id}', name: 'produit_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $p = new Produit();
        $form = $this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p = $form->getData();
            $p->setUser($this->getUser()); // en cas de blem delete this line 
            $p->setId($id);
            $em = $doctrine->getManager();
            $produit = $em->getRepository(Produit::class)->find($id);
            $produit->setLibelle($p->getLibelle());
            $produit->setCategorie($p->getCategorie());
            $produit->setQtStock($p->getQtStock());

            $em->flush();


        }
       
        return $this->redirectToRoute('produit_liste');
    }
}
