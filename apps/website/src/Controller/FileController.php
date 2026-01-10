<?php

declare(strict_types=1);

namespace App\Website\Controller;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Entity\File;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

use function Safe\fopen;
use function Safe\stream_copy_to_stream;

#[Route(
    path: '/f/{uuid:file}/{name}.{extension}',
    name: 'file',
    requirements: [
        'uuid' => Requirement::UID_RFC4122,
        'name' => Requirement::ASCII_SLUG,
        'extension' => Requirement::ASCII_SLUG,
    ],
)]
final class FileController extends AbstractController
{
    public function __construct(
        private readonly FilesystemOperator $defaultFilesystem,
        private readonly AssetUrlGenerator $assetUrlGenerator,
    ) {
    }

    public function __invoke(
        Request $request,
        File $file,
        string $name,
        string $extension,
    ): Response {
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
