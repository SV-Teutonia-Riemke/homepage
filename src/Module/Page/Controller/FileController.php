<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Repository\FileRepository;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

use function fopen;
use function stream_copy_to_stream;

#[AsController]
#[Route('/f/{uuid}/{name}.{extension}', name: 'app_file', requirements: ['uuid' => Requirement::UUID])]
final class FileController extends AbstractController
{
    public function __construct(
        private readonly FileRepository $fileRepository,
        private readonly FilesystemOperator $defaultFilesystem,
    ) {
    }

    public function __invoke(
        Request $request,
        Uuid $uuid,
        string $extension,
    ): Response {
        $file = $this->fileRepository->findOneBy([
            'uuid' => $uuid,
        ]);

        if ($file === null) {
            throw $this->createNotFoundException();
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

        $download = $request->query->getBoolean('download');

        $disposition = HeaderUtils::makeDisposition(
            $download ? HeaderUtils::DISPOSITION_ATTACHMENT : HeaderUtils::DISPOSITION_INLINE,
            $file->getFileName(),
        );

        $response->headers->set('Content-Type', $mimeType);
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
