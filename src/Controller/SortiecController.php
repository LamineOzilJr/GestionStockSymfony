<?php

namespace App\Controller;

use App\Entity\Sortiec;
use App\Entity\Produitc;
use App\Form\SortiecType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiecController extends AbstractController
{
    #[Route('/Sortiec/liste', name: 'sortiec_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        //$data['produits'] = $em->getRepository(Produit::class)->findAll();
        $s = new Sortiec();
        
        $form = $this->createForm(SortiecType::class, $s, 
                                                array('action' => $this->generateUrl('sortiec_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['sortiecs'] = $em->getRepository(Sortiec::class)->findAll();
        return $this->render('sortiec/liste.html.twig', $data);
    }

    #[route('/Sortiec/edit/{id}', name: 'sortiec_edit')]
    public function getentree($id): Response
    {
        return $this->render('sortiec/liste.html.twig');
    }

    #[route('/Sortiec/add', name: 'sortiec_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $s = new Sortiec();
       
        $form = $this->createForm(SortiecType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $s= $form->getData();
            $qsortie = $s->getQtS();
            $p = $em->getRepository(Produitc::class)->find($s->getProduit()->getId());
            if($p->getQtStock() <  $s->getQtS()) {
                $s = new Sortiec();
        
                $form = $this->createForm(SortiecType::class, $s, 
                                                        array('action' => $this->generateUrl('sortiec_add'))
                                                    );
                                                    
                $data['form'] = $form->createView();
                $data['sortiecs'] = $em->getRepository(Sortiec::class)->findAll();
                $data['error_message'] = 'Le stock disponible est inferieur a '.$qsortie ;
                
                return $this->render('sortiec/liste.html.twig', $data);
            }else{

            
            $em->persist($s);
            $em->flush();
            //mise a jour produit
            
             $stock = $p->getQtStock() - $s->getQtS();
             $p->setQtStock($stock);
             $em->flush();
             return $this->redirectToRoute('sortiec_liste');
            }
        }
       
    }

    #[route('/Sortiec/delete/{id}', name: 'sortiec_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $qsortie = $em->getRepository(Sortiec::class)->find($id);
        if ($qsortie != null) {
            $em->remove($qsortie);
            $em->flush();
        }
        return $this->redirectToRoute('sortiec_liste');  
    }

    #[route('/Sortiec/edit/{id}', name: 'sortiec_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $ent = $em->getRepository(Sortiec::class)->find($id);
     
       
        $form = $this->createForm(SortiecType::class, $ent, 
                                            array('action' => $this->generateUrl('sortiec_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['sortiecs'] = $em->getRepository(Sortiec::class)->findAll();
        return $this->render('sortiec/liste.html.twig', $data);
      
    }

    #[route('/Sortiec/update/{id}', name: 'sortiec_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $s = new Sortiec();
        $form = $this->createForm(SortiecType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $s = $form->getData();
            $s->setUser($this->getUser()); // en cas de blem delete this line 
            $s->getId($id);
            $em = $doctrine->getManager();
            $qsortie = $em->getRepository(Sortiec::class)->find($id);
            $qsortie->setDateS($s->getDateS());
            $qsortie->setProduit($s->getProduit());
            $qsortie->setCategorie($s->getCategorie());
            $qsortie->setQtS($s->getQtS());
            $em->flush();
        }

        return $this->redirectToRoute('sortiec_liste');
    }
}
