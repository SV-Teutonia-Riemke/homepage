<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Module\Page\Form\Model\Contact;
use App\Module\Page\Form\Type\Forms\ContactForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

use function assert;
use function sprintf;

#[Route('/contact', name: 'contact')]
class ContactController extends AbstractController
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            assert($data instanceof Contact);

            $email = new Email()
                ->from('noreply@teutonia-riemke.de')
                ->to($data->subject->getSendTo())
                ->replyTo($data->email)
                ->subject(sprintf('Neue Anfrage über das Kontaktformular: %s', $data->subject->getLabel()))
                ->text(
                    sprintf(
                        <<<'EOF'
                        Subject: %s
                        Name: %s %s
                        E-Mail: %s
                        Telefonnummer: %s

                        Nachricht:
                        %s
                        EOF,
                        $data->subject->getLabel(),
                        $data->firstName,
                        $data->lastName,
                        $data->email,
                        $data->phoneNumber ?? 'nicht angegeben',
                        $data->content,
                    ),
                );

            $this->mailer->send($email);

            $this->addFlash('success', 'Ihre Anfrage wurde erfolgreich versendet.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('@page/contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
