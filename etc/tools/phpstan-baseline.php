<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$start of static method App\\\\Domain\\\\YearGroup\\:\\:fromYears\\(\\) expects int, int\\|null given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Domain/YearGroup.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#2 \\$end of static method App\\\\Domain\\\\YearGroup\\:\\:fromYears\\(\\) expects int, int\\|null given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Domain/YearGroup.php',
];
$ignoreErrors[] = [
	'message' => '#^PHPDoc tag @return contains unresolvable type\\.$#',
	'identifier' => 'return.unresolvableType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Module/Admin/Controller/AbstractCrudController.php',
];
$ignoreErrors[] = [
	'message' => '#^Method App\\\\Module\\\\Admin\\\\Controller\\\\MenuItemController\\:\\:getFormType\\(\\) should return class\\-string\\<App\\\\Module\\\\Admin\\\\Form\\\\Type\\\\Forms\\\\MenuItemType\\> but returns string\\.$#',
	'identifier' => 'return.type',
	'count' => 2,
	'path' => __DIR__ . '/../../src/Module/Admin/Controller/MenuItemController.php',
];
$ignoreErrors[] = [
	'message' => '#^Method App\\\\Storage\\\\Entity\\\\Person\\:\\:__toString\\(\\) should return string but returns string\\|null\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Person.php',
];
$ignoreErrors[] = [
	'message' => '#^Method App\\\\Storage\\\\Entity\\\\Person\\:\\:getAnonymizedName\\(\\) should return string but returns string\\|null\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Person.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Person\\:\\:\\$firstName type mapping mismatch\\: property can contain string\\|null but database expects string\\.$#',
	'identifier' => 'doctrine.columnType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Person.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\PersonGroupMember\\:\\:\\$group type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\PersonGroup\\|null but database expects App\\\\Storage\\\\Entity\\\\PersonGroup\\.$#',
	'identifier' => 'doctrine.associationType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/PersonGroupMember.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Player\\:\\:\\$person type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Person\\|null but database expects App\\\\Storage\\\\Entity\\\\Person\\.$#',
	'identifier' => 'doctrine.associationType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Player.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Player\\:\\:\\$team type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Team\\|null but database expects App\\\\Storage\\\\Entity\\\\Team\\.$#',
	'identifier' => 'doctrine.associationType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Player.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Staff\\:\\:\\$person type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Person\\|null but database expects App\\\\Storage\\\\Entity\\\\Person\\.$#',
	'identifier' => 'doctrine.associationType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Staff.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Staff\\:\\:\\$team type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Team\\|null but database expects App\\\\Storage\\\\Entity\\\\Team\\.$#',
	'identifier' => 'doctrine.associationType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Staff.php',
];
$ignoreErrors[] = [
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Team\\:\\:\\$ageCategory type mapping mismatch\\: database can contain App\\\\Domain\\\\TeamAgeCategory\\|null but property expects App\\\\Domain\\\\TeamAgeCategory\\.$#',
	'identifier' => 'doctrine.columnType',
	'count' => 1,
	'path' => __DIR__ . '/../../src/Storage/Entity/Team.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
