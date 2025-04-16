<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


final class BurgersController extends AbstractController
{
    #[Route('/burgers', name: 'app_burgers')]
    public function index(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();

        return $this->render('burgers/index.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/burgers/{id}', name: 'app_burger_show')]
    public function show(Burger $burger): Response
    {
        return $this->render('burgers/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    #[Route('/burgers/{id}/delete', name: 'app_burgers_delete')]
    public function delete(Request $request, Burger $burger, EntityManagerInterface $em): Response
    {
        if($this->isCsrfTokenValid('delete'.$burger->getId(), $request->request->get('_token'))){
            $em->remove($burger);
            $em->flush();
        }
        return $this->redirectToRoute('app_burgers');
    }

    #[Route('/burgers/{id}/edit', name: 'app_burgers_edit')]
    public function edit(Request $request, Burger $burger, EntityManagerInterface $em): Response
    {
        if($this->isCsrfTokenValid('edit'.$burger->getId(), $request->request->get('_token'))){
            $em->persist($burger);
            $em->flush();

            return $this->redirectToRoute('app_burgers');
        }
        return $this->render('burgers/edit.html.twig', [
            'burger' => $burger,
        ]);

    }



}
