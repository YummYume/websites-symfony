<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Website;
use DateTime;
use App\Form\WebsiteType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

class WebsiteController extends AbstractController
{
    /**
     * @Route("/", name="website")
     */
    public function websites(Request $request): Response
    {
        $filtered = false;
        $message = null;
        $error = null;
        $easterEgg = false;

        if ($request->query->get('search'))
        {
            $search = $request->query->get('search');

            if (is_string($search))
            {
                $filtered = true;
                $search = trim($search);

                if (strtolower($search) == "do a barrel roll")
                {
                    $easterEgg = true;
                }

                $websites = $this->getDoctrine()->getRepository(Website::class)->createQueryBuilder('searchFilter')
                ->where('searchFilter.Name LIKE :search')
                ->setParameter('search', '%'.$search.'%')
                ->orderBy('searchFilter.date', 'DESC')
                ->getQuery()
                ->execute();

                $message = count($websites)." résultat pour \"".$search."\".";
                
                if (count($websites) > 1)
                {
                    $message = count($websites)." résultats pour \"".$search."\".";
                }
            }
            else
            {
                $websites = null;
                $error = "Une erreur s'est produite pendant la recherche.";
            }
        }
        else
        {
            $websites = $this->getDoctrine()->getRepository(Website::class)->findBy(
                array(),
                array('date' => 'DESC'),
            );

            if (empty($websites))
            {
                $message = "Aucun site.";
            }
            elseif (count($websites) == 1)
            {
                $message = count($websites)." site web.";
            }
            else
            {
                $message = count($websites)." sites web.";
            }
        }

        return $this->render('website/index.html.twig', [
            'websites' => $websites,
            'filtered' => $filtered,
            'message' => $message,
            'error' => $error,
            'easterEgg' => $easterEgg
        ]);
    }

    /**
     * @Route("/website/create", name="createWebsite")
     */
    public function createWebsite(Request $request, ValidatorInterface $validator): Response
    {
        if ($request->query->get('message') !== null)
        {
            $this->addFlash('notice', $request->query->get('message'));
        }

        if ($request->query->get('error') !== null)
        {
            $this->addFlash('error', $request->query->get('error'));
        }

        try
        {
            $website = new Website();

            $form = $this->createForm(WebsiteType::class, $website);
        
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $error = false;
                $errorMessage = "Erreur dans les champs suivants : ";
                $urlConstraint = new UrlConstraint();
                $choicesPHP = [
                    '7.4' => "7.4",
                    '7.3' => "7.3",
                    '7.2' => "7.2",
                    '7.1' => "7.1",
                    '7.0' => "7.0",
                ];

                if (null === $form->get('Name')->getData() || !is_string($form->get('Name')->getData()) || !preg_match("/^.{2,50}+$/", $form->get('Name')->getData()))
                {
                    $error = true;
                    $errorMessage = $errorMessage."Nom, ";
                }
                if (null === $form->get('Link')->getData() || !is_string($form->get('Link')->getData()) || count($validator->validate($form->get('Link')->getData(), $urlConstraint)) !== 0)
                {
                    $error = true;
                    $errorMessage = $errorMessage."Lien, ";
                }
                if (null === $form->get('Client')->getData() || !$form->get('Client')->getData() instanceof Client)
                {
                    $error = true;
                    $errorMessage = $errorMessage."Client, ";
                }
                if (null !== $form->get('PHP')->getData() && (!is_string($form->get('PHP')->getData()) || !in_array($form->get('PHP')->getData(), $choicesPHP)))
                {
                    $error = true;
                    $errorMessage = $errorMessage."Version PHP, ";
                }
                $errorMessage = substr($errorMessage, 0, -2);

                if ($error)
                {
                    return $this->redirectToRoute("createWebsite", [
                        'error' => $errorMessage,
                    ]);
                }

                $website = $form->getData();
                $website->setDate(new DateTime("NOW"));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($website);
                $manager->flush();

                return $this->redirectToRoute("createWebsite", [
                    'message' => 'Site '.$website->getName().' ajouté avec succès.',
                ]);
            }
        }
        catch (Exception $e)
        {
            return $this->redirectToRoute("createWebsite", [
                'error' => 'Une erreur s\'est produite.',
            ]);
        }

        return $this->render('website/create.html.twig', [
            'websiteForm' => $form->createView(),
        ]);
    }
}
