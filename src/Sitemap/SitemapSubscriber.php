<?php

declare(strict_types=1);

namespace App\Sitemap;

use App\Storage\Repository\ArticleRepository;
use App\Storage\Repository\PageRepository;
use App\Storage\Repository\TeamRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEventListener]
class SitemapSubscriber
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly ArticleRepository $articleRepository,
        private readonly PageRepository $pageRepository,
        private readonly SluggerInterface $slugger,
    ) {
    }

    public function __invoke(SitemapPopulateEvent $event): void
    {
        $this->registerTeams($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerArticles($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerPages($event->getUrlContainer(), $event->getUrlGenerator());
    }

    public function registerTeams(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $teams = $this->teamRepository->findAllEnabled();

        foreach ($teams as $team) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'app_team_slug',
                        [
                            'team' => $team->getId(),
                            'slug' => $team->getSlug($this->slugger),
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL,
                    ),
                ),
                'team',
            );
        }
    }

    public function registerArticles(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $teams = $this->articleRepository->findLatestEnabled();

        foreach ($teams as $team) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'app_news_article',
                        [
                            'id' => $team->getId(),
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL,
                    ),
                ),
                'article',
            );
        }
    }

    public function registerPages(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $pages = $this->pageRepository->findEnabled();

        foreach ($pages as $page) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'app_page',
                        [
                            'page' => $page->getId(),
                            'slug' => $page->getSlug($this->slugger),
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL,
                    ),
                ),
                'page',
            );
        }
    }
}
