<?php

namespace App\Controller;

use App\Entity\Client;
use DateTime;
use App\Form\ClientType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class ClientController extends AbstractController
{
    /**
     * @Route("/client/create", name="createClient")
     */
    public function createClient(Request $request, ValidatorInterface $validator): Response
    {
        if ($request->query->get('message') !== null)
        {
            $this->addFlash('notice', $request->query->get('message'));
        }

        if ($request->query->get('error') !== null)
        {
            $this->addFlash('error', $request->query->get('error'));
        }

        
            $client = new Client();

            $form = $this->createForm(ClientType::class, $client);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $error = false;
                $errorMessage = "Erreur dans les champs suivants : ";
                $emailConstraint = new EmailConstraint();

                if (null === $form->get('CompanyName')->getData() || !is_string($form->get('CompanyName')->getData()) || !preg_match("/^.{2,50}+$/", $form->get('CompanyName')->getData()))
                {
                    $error = true;
                    $errorMessage = $errorMessage."Nom de l'entreprise, ";
                }
                if (null === $form->get('ContactName')->getData() || !is_string($form->get('ContactName')->getData()) || !preg_match("/^[a-zA-Z-'\s]{2,50}+$/", $form->get('ContactName')->getData()))
                {
                    $error = true;
                    $errorMessage = $errorMessage."Nom du contact, ";
                }
                if (null !== $form->get('ContactEmail')->getData() && (!is_string($form->get('ContactEmail')->getData()) || count($validator->validate($form->get('ContactEmail')->getData(), $emailConstraint)) !== 0))
                {
                    $error = true;
                    $errorMessage = $errorMessage."Email, ";
                }
                if (null !== $form->get('ContactPhone')->getData() && (!is_string($form->get('ContactPhone')->getData()) || !preg_match('/^([0-9]{10})|\+([0-9]{11})+$/', $form->get('ContactPhone')->getData())))
                {
                    $error = true;
                    $errorMessage = $errorMessage."Numéro de téléphone, ";
                }
                $errorMessage = substr($errorMessage, 0, -2);

                if ($error)
                {
                    return $this->redirectToRoute("createClient", [
                        'error' => $errorMessage,
                    ]);
                }

                $client = $form->getData();
                $client->setDate(new DateTime("NOW"));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($client);
                $manager->flush();

                return $this->redirectToRoute("createClient", [
                    'message' => 'Client '.$client->getCompanyName().' ajouté avec succès.',
                ]);
            }
        

        return $this->render('client/create.html.twig', [
            'clientForm' => $form->createView(),
        ]);
    }
}
