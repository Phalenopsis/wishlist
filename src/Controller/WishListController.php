<?php

namespace App\Controller;

use App\Entity\WishList;
use App\Form\WishListType;
use App\Repository\WishListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/wishlist')]
class WishListController extends AbstractController
{
    #[Route('/', name: 'app_wish_list_index', methods: ['GET'])]
    public function index(WishListRepository $wishListRepository): Response
    {
        return $this->render('wish_list/index.html.twig', [
            'wish_lists' => $wishListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_wish_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $wishList = new WishList();
        $form = $this->createForm(WishListType::class, $wishList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishList->setSlug($slugger->slug($wishList->getName()));
            $entityManager->persist($wishList);
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wish_list/new.html.twig', [
            'wish_list' => $wishList,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_wish_list_show', methods: ['GET'])]
    public function show(WishList $wishList): Response
    {
        return $this->render('wish_list/show.html.twig', [
            'wish_list' => $wishList,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_wish_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WishList $wishList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WishListType::class, $wishList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wish_list/edit.html.twig', [
            'wish_list' => $wishList,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_wish_list_delete', methods: ['POST'])]
    public function delete(Request $request, WishList $wishList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wishList->getId(), $request->request->get('_token'))) {
            $entityManager->remove($wishList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wish_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
