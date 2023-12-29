<?php

namespace App\Controller;

use App\Entity\Label;
use App\Entity\WishList;
use App\Form\LabelType;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/label')]
class LabelController extends AbstractController
{
    #[Route('{slug}/new', name: 'app_label_new', methods: ['GET', 'POST'])]
    public function new(
        #[MapEntity(mapping: ['slug' => 'slug'])] WishList $wishList,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $label = new Label();
        $label->setWhishList($wishList);
        $form = $this->createForm(LabelType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($label);
            $entityManager->flush();
            return $this->redirectToRoute('app_wish_list_show', ['slug' => $wishList->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('label/new.html.twig', [
            'label' => $label,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_label_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Label $label, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LabelType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wish_list_show', ['slug' => $label->getWhishList()->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('label/edit.html.twig', [
            'label' => $label,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_label_delete', methods: ['POST'])]
    public function delete(Request $request, Label $label, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$label->getId(), $request->request->get('_token'))) {
            $entityManager->remove($label);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wish_list_show', ['slug' => $label->getWhishList()->getSlug()], Response::HTTP_SEE_OTHER);
    }
}
