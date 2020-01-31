<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $adRepository)
    {
        $ads = $adRepository->findBy([], ['id' => 'desc']);

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Create and edit ad
     *
     * @Route("/ads/{slug}/edit", name="ad_edit")
     * @Route("/ads/new", name="ad_new")
     *
     * @return Response
     */
    public function form(Ad $ad = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$ad){
            $ad = new Ad();
        }

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($ad);

            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistré");

            return $this->redirectToRoute('ad_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $ad->getId() !== null
        ]);
    }

    /**
     * Display ad
     *
     * @Route("/ads/{slug}", name="ad_show")
     *
     * @return Response
     */
    public function show(Ad $ad)
    {
        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);
    }
}
