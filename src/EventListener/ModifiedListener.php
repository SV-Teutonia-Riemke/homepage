<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Storage\Entity\Common\ModifiedInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Clock\ClockInterface;

#[AsDoctrineListener(Events::prePersist)]
#[AsDoctrineListener(Events::preUpdate)]
final class ModifiedListener
{
    public function __construct(
        private readonly ClockInterface $clock,
    ) {
    }

    /** @param LifecycleEventArgs<EntityManagerInterface> $args */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (! ($entity instanceof ModifiedInterface)) {
            return;
        }

        $this->setDates($entity);
    }

    /** @param LifecycleEventArgs<EntityManagerInterface> $args */
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
