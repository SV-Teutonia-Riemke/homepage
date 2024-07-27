<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Module\Page\Form\Type\Forms\ContactForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        return $this->render('@page/contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
