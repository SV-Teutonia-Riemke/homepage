<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\DBAL\Schema\AbstractAsset;
use Doctrine\DBAL\Schema\Name;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Tools\Console\Command\DoctrineCommand;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

use function debug_backtrace;
use function is_a;

use const DEBUG_BACKTRACE_IGNORE_ARGS;

#[AutoconfigureTag('doctrine.dbal.schema_filter')]
final class DoctrineMigrationsFilterSubscriber
{
    /** @param AbstractAsset<Name>|string $asset */
    public function __invoke(AbstractAsset|string $asset): bool
    {
        if ($asset instanceof AbstractAsset) {
            $asset = $asset->getName();
        }

        if ($asset === new TableMetadataStorageConfiguration()->getTableName()) { // 'doctrine_migration_versions'
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $call) {
                $class = $call['class'] ?? null;
                if ($class !== null && is_a($class, DoctrineCommand::class, true)) {
                    return true;
                }
            }

            // If we are not in the context of the command executed by doctrine-migrations bundle
            // but a doctrine command, we want to ignore/filter the doctrine_migration_versions table
            return false;
        }

        return true;
    }
}
