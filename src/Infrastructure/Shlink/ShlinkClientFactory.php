<?php

declare(strict_types=1);

namespace App\Infrastructure\Shlink;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Shlinkio\Shlink\SDK\Config\ShlinkConfig;
use Shlinkio\Shlink\SDK\Domains\DomainsClient;
use Shlinkio\Shlink\SDK\Http\HttpClient;
use Shlinkio\Shlink\SDK\RedirectRules\RedirectRulesClient;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Shlinkio\Shlink\SDK\ShortUrls\ShortUrlsClient;
use Shlinkio\Shlink\SDK\Tags\TagsClient;
use Shlinkio\Shlink\SDK\Visits\VisitsClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ShlinkClientFactory
{
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        #[Autowire(env: 'SHLINK_URL')]
        private readonly string $baseUrl,
        #[Autowire(env: 'SHLINK_API_KEY')]
        private readonly string $apiKey,
        #[Autowire(env: 'SHLINK_VERSION')]
        private readonly string $version,
    ) {
    }

    public function __invoke(): ShlinkClient
    {
        $config = ShlinkConfig::fromArray([
            'baseUrl' => $this->baseUrl,
            'apiKey' => $this->apiKey,
            'version' => $this->version,
        ]);

        $httpClient = new HttpClient(
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory,
            $config,
        );

        $shortUrlsClient     = new ShortUrlsClient($httpClient);
        $visitsClient        = new VisitsClient($httpClient);
        $tagsClient          = new TagsClient($httpClient);
        $domainsClient       = new DomainsClient($httpClient);
        $redirectRulesClient = new RedirectRulesClient($httpClient);

        return new ShlinkClient(
            $shortUrlsClient,
            $visitsClient,
            $tagsClient,
            $domainsClient,
            $redirectRulesClient,
        );
    }
}
