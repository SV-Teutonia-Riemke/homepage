<?php

declare(strict_types=1);

namespace App\Infrastructure\Asset;

use Nicklog\ImgProxy\ImgProxy;
use Nicklog\ImgProxy\Signer\KeyPair;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ImageProxyFactory
{
    public function __construct(
        #[Autowire(env: 'IMGPROXY_BASE_URL')]
        private readonly string $baseUrl,
        #[Autowire(env: 'IMGPROXY_KEY')]
        private readonly string $key,
        #[Autowire(env: 'IMGPROXY_SALT')]
        private readonly string $salt,
    ) {
    }

    public function __invoke(): ImgProxy
    {
        return ImgProxy::create(
            $this->baseUrl,
            new KeyPair(
                $this->key,
                $this->salt,
            ),
        );
    }
}
