<?php

namespace App\Controller;

use App\Entity\WishList;
use App\Form\AddContributorType;
use App\Form\WishListType;
use App\Repository\WishListRepository;
use App\Service\RandomPropositionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/wishlist')]
class WishListController extends AbstractController
{
    #[Route('/new', name: 'app_wish_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $wishList = new WishList();
        $form = $this->createForm(WishListType::class, $wishList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishList->setSlug($slugger->slug($wishList->getName()));
            $wishList->setCreator($this->getUser());
            $entityManager->persist($wishList);
            $entityManager->flush();

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wish_list/new.html.twig', [
            'wish_list' => $wishList,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_wish_list_show', methods: ['GET'])]
    public function show(WishList $wishList): Response
    {
        if(!($wishList->getCreator() === $this->getUser() || $wishList->getContributors()->contains($this->getUser())) ){
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette page !');
        }
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

    #[Route('/{slug}/addfriend', name: 'app_wish_list_addfriend', methods: ['GET', 'POST'])]
    public function addFriend(Request $request, WishList $wishList, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm( AddContributorType::class, $wishList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_show', ['slug' => $wishList->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wish_list/addFriend.html.twig', [
            'wish_list' => $wishList,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/random', name: 'app_random_proposition')]
    public function random(WishList $wishList, RandomPropositionService $randomService, EntityManagerInterface $entityManager): Response
    {
        $proposition = $randomService->getRandomProposition($wishList);
        if ($proposition !== null) {
            $proposition->setState('Pending');
            $entityManager->flush();
        }

        return $this->render('wish_list/random.html.twig', [
            'proposition' => $proposition,
            'wishlist' => $wishList,
        ]);
    }

    #[Route('/{slug}/editlabels', name: 'app_edit_labels')]
    public function editLabels(WishList $wishList): Response
    {
        return $this->render('wish_list/editlabels.html.twig', [
           'wishlist' => $wishList,
        ]);
    }
}
