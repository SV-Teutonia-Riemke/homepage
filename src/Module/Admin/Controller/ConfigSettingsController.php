<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Infrastructure\Config\ConfigBuilder;
use App\Infrastructure\Config\ConfigSettingProvider;
use App\Module\Admin\Form\Type\Forms\ConfigType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/config', name: 'app_admin_config_settings')]
class ConfigSettingsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ConfigBuilder $configBuilder,
        private readonly ConfigSettingProvider $configSettingProvider,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ConfigType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collection = $this->configBuilder->build();

            foreach ($collection->getAllItems() as $item) {
                $setting = $this->configSettingProvider->get($item->name);

                $this->entityManager->persist($setting);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_config_settings');
        }

        return $this->render('@admin/config/settings.html.twig', [
            'form' => $form,
        ]);
    }
}
