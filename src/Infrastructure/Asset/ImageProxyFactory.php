<?php

declare(strict_types=1);

namespace App\Infrastructure\Asset;

use App\Infrastructure\ImgProxy\ImgProxy;
use App\Infrastructure\ImgProxy\Signer\KeyPairSigner;

class ImageProxyFactory
{
    public function __invoke(): ImgProxy
    {
        return ImgProxy::create(
            'http://localhost:8080',
            new KeyPairSigner(
                '2d5e052902893310f94a568c604a2de540a3966b92da89eed8d153f6ed3b2775787e2e057093ccf1dbb5449bfff14d0b4f74195bfbd22e844e87892f2b032513',
                '01ccf236bc7771b3f4b66a0d6b5d623801fa96b1404b2c7ca91c816f6f20a22644c7dbb926fa4c288f3c458d7425f29fb33763ce8f7a821cde68ec2d22ba9b60',
            ),
        );
    }
}
