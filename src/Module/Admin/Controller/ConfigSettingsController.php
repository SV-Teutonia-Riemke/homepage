<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\ConfigSettingCollectionType;
use App\Storage\Repository\ConfigSettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/config', name: 'app_admin_config_settings')]
class ConfigSettingsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ConfigSettingRepository $configSettingRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $allStoredSettings = $this->configSettingRepository->findAll();

        $formData = [
            'settings' => $allStoredSettings,
        ];

        $form = $this->createForm(ConfigSettingCollectionType::class, $formData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($formData['settings'] as $formSetting) {
                $this->entityManager->persist($formSetting);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_config_settings');
        }

        return $this->renderForm('@admin/config/settings.html.twig', [
            'form' => $form,
        ]);
    }
}
