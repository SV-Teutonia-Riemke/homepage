<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Form\Type\Forms\DirectoryType;
use App\Admin\Form\Type\Forms\FileEditType;
use App\Admin\Form\Type\Forms\FileUploadType;
use App\Domain\Role;
use App\Storage\Entity\Directory;
use App\Storage\Entity\File;
use App\Storage\Repository\DirectoryRepository;
use App\Storage\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;

use function pathinfo;
use function sha1;
use function sprintf;
use function Symfony\Component\String\u;

use const PATHINFO_FILENAME;

#[IsGranted(Role::MANAGE_FILES->value)]
#[Route('/files', name: 'files_')]
final class FilesController extends AbstractController
{
    public function __construct(
        private readonly DirectoryRepository $directoryRepository,
        private readonly FileRepository $fileRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly SluggerInterface $slugger,
        private readonly FilesystemOperator $defaultFilesystem,
    ) {
    }

    #[Route('', name: 'index')]
    #[Route('/directory/{directory}', name: 'directory', requirements: ['directory' => Requirement::DIGITS])]
    public function index(
        Directory|null $directory,
    ): Response {
        $directories = $this->directoryRepository->findBy([
            'parent' => $directory,
        ], [
            'name' => 'ASC',
        ]);

        $files = $this->fileRepository->findBy([
            'directory' => $directory,
        ], [
            'name' => 'ASC',
        ]);

        return $this->render('@admin/files/index.html.twig', [
            'directory'   => $directory,
            'directories' => $directories,
            'files'       => $files,
        ]);
    }

    #[Route('/directory/create', name: 'directory_create')]
    #[Route('/directory/{directory}/create', name: 'directory_create_parent')]
    public function directoryCreate(
        Request $request,
        Directory|null $directory,
    ): Response {
        $newDirectory = new Directory('', $directory);

        $form = $this->createForm(DirectoryType::class, $newDirectory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($newDirectory);
            $this->entityManager->flush();

            return $directory === null
                ? $this->redirectToRoute('app_admin_files_index')
                : $this->redirectToRoute('app_admin_files_directory', [
                    'directory' => $directory->getId(),
                ]);
        }

        return $this->render('@admin/files/directory_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/directory/{directory}/edit', name: 'directory_edit')]
    public function directoryEdit(
        Request $request,
        Directory $directory,
    ): Response {
        $form = $this->createForm(DirectoryType::class, $directory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($directory);
            $this->entityManager->flush();

            return $directory->getParent() === null
                ? $this->redirectToRoute('app_admin_files_index')
                : $this->redirectToRoute('app_admin_files_directory', [
                    'directory' => $directory->getParent()->getId(),
                ]);
        }

        return $this->render('@admin/files/directory_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/directory/{directory}/remove', name: 'directory_remove')]
    public function directoryRemove(
        Directory $directory,
    ): RedirectResponse {
        $this->entityManager->remove($directory);
        $this->entityManager->flush();

        if ($directory->getParent() !== null) {
            return $this->redirectToRoute('app_admin_files_directory', [
                'directory' => $directory->getParent()->getId(),
            ]);
        }

        return $this->redirectToRoute('app_admin_files_index');
    }

    #[Route('/upload', name: 'upload')]
    #[Route('/upload/{directory}', name: 'upload_directory')]
    public function fileUpload(
        Request $request,
        Directory|null $directory,
    ): Response {
        $form = $this->createForm(FileUploadType::class, [
            'directory' => $directory,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var list<UploadedFile> $uploadedFiles */
            $uploadedFiles = $form->get('files')->getData();

            foreach ($uploadedFiles as $uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $extension        = $uploadedFile->guessExtension();

                $uid  = Uuid::v4();
                $hash = u(sha1($uid->__toString()));

                $dir1     = $hash->slice(0, 1);
                $dir2     = $hash->slice(1, 1);
                $filePath = sprintf(
                    '%s/%s/%s.%s',
                    $dir1->__toString(),
                    $dir2->__toString(),
                    $hash->__toString(),
                    $extension,
                );

                $safeFilename = $this->slugger->slug($originalFilename);

                $file = new File(
                    $originalFilename,
                    $safeFilename->toString(),
                    $extension,
                    $uploadedFile->getMimeType(),
                    $uid,
                    $filePath,
                    $form->get('directory')->getData(),
                );

                $this->defaultFilesystem->write($filePath, $uploadedFile->getContent());

                $this->entityManager->persist($file);
            }

            $this->entityManager->flush();

            return $directory === null
                ? $this->redirectToRoute('app_admin_files_index')
                : $this->redirectToRoute('app_admin_files_directory', [
                    'directory' => $directory->getId(),
                ]);
        }

        return $this->render('@admin/files/upload.html.twig', [
            'directory' => $directory,
            'form'      => $form,
        ]);
    }

    #[Route('/file/{file}/edit', name: 'file_edit')]
    public function fileEdit(
        Request $request,
        File $file,
    ): Response {
        $form = $this->createForm(FileEditType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file->setSafeName($this->slugger->slug($file->getName())->toString());

            $this->entityManager->flush();

            return $file->getDirectory() === null
                ? $this->redirectToRoute('app_admin_files_index')
                : $this->redirectToRoute('app_admin_files_directory', [
                    'directory' => $file->getDirectory()->getId(),
                ]);
        }

        return $this->render('@admin/files/directory_create.html.twig', [
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/file/{file}/remove', name: 'file_remove')]
    public function fileRemove(File $file): RedirectResponse
    {
        $this->defaultFilesystem->delete($file->getFilePath());

        $this->entityManager->remove($file);
        $this->entityManager->flush();

        if ($file->getDirectory() !== null) {
            return $this->redirectToRoute('app_admin_files_directory', [
                'directory' => $file->getDirectory()->getId(),
            ]);
        }

        return $this->redirectToRoute('app_admin_files_index');
    }
}
