<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Repository\FileRepository;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

use function fopen;
use function stream_copy_to_stream;

#[AsController]
#[Route('/f/{uuid}/{name}.{extension}', name: 'app_file')]
final class FileController extends AbstractController
{
    public function __construct(
        private readonly FileRepository $fileRepository,
        private readonly FilesystemOperator $defaultFilesystem,
        private readonly AssetUrlGenerator $assetUrlGenerator,
    ) {
    }

    public function __invoke(
        Request $request,
        Uuid $uuid,
        string $name,
        string $extension,
    ): Response {
        $file = $this->fileRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if ($file === null) {
            throw $this->createNotFoundException();
        }

        $download = $request->query->getBoolean('download');

        if (
            $file->getSafeName() !== $name ||
            $file->getExtension() !== $extension
        ) {
            return $this->redirect(
                $this->assetUrlGenerator->__invoke($file, $download),
            );
        }

        $mimeType = $this->defaultFilesystem->mimeType($file->getFilePath());

        $outputStream = fopen('php://output', 'wb');
        if ($outputStream === false) {
            throw $this->createNotFoundException();
        }

        $response = new StreamedResponse(function () use ($file, $outputStream): void {
            $fileStream = $this->defaultFilesystem->readStream($file->getFilePath());
            stream_copy_to_stream($fileStream, $outputStream);
        });

        $disposition = HeaderUtils::makeDisposition(
            $download ? HeaderUtils::DISPOSITION_ATTACHMENT : HeaderUtils::DISPOSITION_INLINE,
            $file->getFileName(),
        );

        $response->headers->set('Content-Type', $mimeType);
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
