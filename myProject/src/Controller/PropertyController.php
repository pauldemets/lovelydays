<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="property")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Property::class);


        // looks for multiple products matching the given name, ordered by price
        $properties = $repository->findAll();

        return $this->render('property/index.html.twig',array('properties' => $properties));
    }

    /**
     * @Route("/add", name="property")
     */
    public function new()
    {
        $entityManager = $this->getDoctrine()->getManager();

        return $this->render('property/add.html.twig', [
            'controller_name' => 'PropertyController',
        ]);
    }

    /**
     * @Route("/store", name="store")
     */
    public function storeProperty(Request $request){
        dd($request->request->get('name'));
    }
}
