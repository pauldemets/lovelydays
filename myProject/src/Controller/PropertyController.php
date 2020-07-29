<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="IndexProperty")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Property::class);

        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);

        $properties = $repository->findAll();

        return $this->render(
            'property/index.html.twig',
            [
                'form' => $form->createView(),
                'properties' => $properties
            ]
        );
    }

    /**
     * @Route("/add", name="NewProperty")
     */
    public function new(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('IndexProperty');
        }

        return $this->render('property/add.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'PropertyController',
        ]);
    }


    /**
     * @Route("/delete/{id}", name="deleteProperty")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $property = $entityManager->getRepository(Property::class)->find($id);

        if (!$property) {
            throw $this->createNotFoundException(
                'No property found for id ' . $id
            );
        }

        $entityManager->remove($property);
        $entityManager->flush();

        return $this->redirectToRoute('IndexProperty');
    }

    /**
     * @Route("/update/{id}", name="updateProperty")
     */
    public function update($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $property = $entityManager->getRepository(Property::class)->find($id);

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash('success', 'Edit success !');
            return $this->redirectToRoute('IndexProperty');
        }

        return $this->render('property/update.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'PropertyController',
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detailProperty")
     */
    public function detail($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $property = $entityManager->getRepository(Property::class)->find($id);

        if (!$property) {
            throw $this->createNotFoundException(
                'No property found for id ' . $id
            );
        }

        return $this->render(
            'property/detail.html.twig',
            [
                'property' => $property
            ]
        );;
    }
}
