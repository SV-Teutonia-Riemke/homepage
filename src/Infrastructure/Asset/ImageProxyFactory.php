<?php

declare(strict_types=1);

namespace App\Infrastructure\Asset;

use Nicklog\ImgProxy\ImgProxy;
use Nicklog\ImgProxy\Signer\Insecure;
use Nicklog\ImgProxy\Signer\KeyPair;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ImageProxyFactory
{
    public function __construct(
        #[Autowire(env: 'IMGPROXY_BASE_URL')]
        private readonly string $baseUrl,
        #[Autowire(env: 'default::IMGPROXY_KEY')]
        private readonly string|null $key,
        #[Autowire(env: 'default::IMGPROXY_SALT')]
        private readonly string|null $salt,
    ) {
    }

    public function __invoke(): ImgProxy
    {
        $signer = $this->key === null || $this->salt === null
            ? new Insecure()
            : new KeyPair(
                $this->key,
                $this->salt,
            );

        return ImgProxy::create(
            $this->baseUrl,
            $signer,
        );
    }
}
