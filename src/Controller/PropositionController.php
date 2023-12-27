<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Proposition;
use App\Entity\WishList;
use App\Form\ChangeLabelsType;
use App\Form\ChangeStateType;
use App\Form\CommentType;
use App\Form\PropositionType;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proposition')]
class PropositionController extends AbstractController
{
    #[Route('/', name: 'app_proposition_index', methods: ['GET'])]
    public function index(PropositionRepository $propositionRepository): Response
    {
        return $this->render('proposition/index.html.twig', [
            'propositions' => $propositionRepository->findAll(),
        ]);
    }

    #[Route('{slug}/new', name: 'app_proposition_new', methods: ['GET', 'POST'])]
    public function new(
        #[MapEntity(mapping: ['slug' => 'slug'])] WishList $wishList,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $proposition = new Proposition();
        $proposition->setWishList($wishList);
        $proposition->setCreator($this->getUser());
        $proposition->setState("Created");
        $form = $this->createForm(PropositionType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($proposition);
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_show', ['slug' => $wishList->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('proposition/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proposition_show', methods: ['GET'])]
    public function show(Proposition $proposition): Response
    {
        return $this->render('proposition/show.html.twig', [
            'proposition' => $proposition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_proposition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropositionType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_proposition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('proposition/edit.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proposition_delete', methods: ['POST'])]
    public function delete(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($proposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_proposition_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/changestate', name: 'app_proposition_changestate')]
    public function changeState(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChangeStateType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_show', ['slug' => $proposition->getWishList()->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('proposition/change_state.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/addcomment', name: 'app_add_comment')]
    public function addComment(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $comment->setProposition($proposition);
        $comment->setAuthor($this->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_proposition_show', ['id' => $proposition->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/changelabels', name: 'app_proposition_changelabels')]
    public function changeLabels(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChangeLabelsType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_show', ['slug' => $proposition->getWishList()->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('proposition/change_labels.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }
}
