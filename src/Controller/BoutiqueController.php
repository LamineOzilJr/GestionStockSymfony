<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Form\BoutiqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique/liste', name: 'boutique_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $b = new Boutique;
        $form = $this->createForm(
            BoutiqueType::class, $b,
                            array('action' => $this->generateUrl('boutique_add'))
        );
        $data['form'] = $form->createView();

        $data['boutiques'] = $em->getRepository(Boutique::class)->findAll();

        return $this->render('boutique/liste.html.twig', $data);

    }

    // #[route('/Boutique/edit/{id}', name: 'boutique_edit')]
    // public function getboutique($id): Response
    // {
    //     return $this->render('boutique/liste.html.twig');
    // }

    #[route('/Boutique/add', name: 'boutique_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $b = new Boutique();
        $form = $this->createForm(BoutiqueType::class, $b);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $b = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($b);
            $em->flush();
        
        return $this->redirectToRoute('boutique_liste');
        }
    }

    #[route('/Boutique/delete/{id}', name: 'boutique_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $boutique = $em->getRepository(Boutique::class)->find($id);
        if ($boutique != null) {
            $em->remove($boutique);
            $em->flush();
        }
        return $this->redirectToRoute('boutique_liste');
    }

    #[route('/Boutique/edit/{id}', name: 'boutique_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $b = $em->getRepository(Boutique::class)->find($id);
        $form = $this->createForm(BoutiqueType::class, $b, 
                                                array('action' => $this->generateUrl('boutique_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['boutiques'] = $em->getRepository(Boutique::class)->findAll();
        return $this->render('boutique/liste.html.twig', $data);
      
    }

    #[route('/Boutique/update/{id}', name: 'boutique_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $b = new Boutique();
        $form = $this->createForm(BoutiqueType::class, $b);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $b = $form->getData();
          //  $b->setUser($this->getUser()); // en cas de blem delete this line 
            $b->getId($id);
            $em = $doctrine->getManager();
            $boutique = $em->getRepository(Boutique::class)->find($id);
            $boutique->setNom($b->getNom());
            $boutique->setAdresse($b->getAdresse());
            $em->flush();
        }
       
        return $this->redirectToRoute('boutique_liste');
    }
}
