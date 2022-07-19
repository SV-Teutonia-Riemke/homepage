<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Storage\Entity\Common\ModifiedInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use StellaMaris\Clock\ClockInterface;

final class ModifiedListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly ClockInterface $clock,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (! ($entity instanceof ModifiedInterface)) {
            return;
        }

        $this->setDates($entity);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (! ($entity instanceof ModifiedInterface)) {
            return;
        }

        $this->setDates($entity);
    }

    private function setDates(ModifiedInterface $entity): void
    {
        $now = $this->clock->now();

        if ($entity->getCreatedAt() === null) {
            $entity->setCreatedAt($now);
        }

        $entity->setUpdatedAt($now);
    }
}
