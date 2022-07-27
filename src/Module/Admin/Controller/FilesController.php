<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\DirectoryType;
use App\Storage\Entity\Directory;
use App\Storage\Repository\DirectoryRepository;
use App\Storage\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/files', name: 'app_admin_files_')]
final class FilesController extends AbstractController
{
    public function __construct(
        private readonly DirectoryRepository $directoryRepository,
        private readonly FileRepository $fileRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'index')]
    #[Route('/{directory}', name: 'directory')]
    public function index(
        ?Directory $directory
    ): Response {
        $directories = $this->directoryRepository->findBy([
            'parent' => $directory,
        ]);
        $files       = $this->fileRepository->findBy([
            'directory' => $directory,
        ]);

        return $this->render('admin/files/index.html.twig', [
            'directories' => $directories,
            'files'       => $files,
        ]);
    }

    #[Route('/directory/create', name: 'directory_create')]
    public function directoryCreate(
        Request $request,
    ): Response {
        $form = $this->createForm(DirectoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directory = $form->getData();
            assert($directory instanceof Directory);

            $this->entityManager->persist($directory);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_files_index');
        }

        return $this->render('admin/files/directory_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/directory/{directory}/remove', name: 'directory_remove')]
    public function directoryRemove(
        Directory $directory
    ): Response {
        $this->entityManager->remove($directory);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_files_index');
    }
}
