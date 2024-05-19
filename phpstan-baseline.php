<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	// identifier: offsetAccess.nonArray
	'message' => '#^Cannot use array destructuring on array\\<int, int\\|null\\>\\|null\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/YearGroup.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#1 \\$start of static method App\\\\Domain\\\\YearGroup\\:\\:fromYears\\(\\) expects int, int\\|null given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/YearGroup.php',
];
$ignoreErrors[] = [
	// identifier: argument.type
	'message' => '#^Parameter \\#2 \\$end of static method App\\\\Domain\\\\YearGroup\\:\\:fromYears\\(\\) expects int, int\\|null given\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Domain/YearGroup.php',
];
$ignoreErrors[] = [
	// identifier: return.type
	'message' => '#^Method App\\\\Storage\\\\Entity\\\\Person\\:\\:__toString\\(\\) should return string but returns string\\|null\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Person.php',
];
$ignoreErrors[] = [
	// identifier: return.type
	'message' => '#^Method App\\\\Storage\\\\Entity\\\\Person\\:\\:getAnonymizedName\\(\\) should return string but returns string\\|null\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Person.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.columnType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Person\\:\\:\\$firstName type mapping mismatch\\: property can contain string\\|null but database expects string\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Person.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.associationType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\PersonGroupMember\\:\\:\\$group type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\PersonGroup\\|null but database expects App\\\\Storage\\\\Entity\\\\PersonGroup\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/PersonGroupMember.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.associationType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Player\\:\\:\\$person type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Person\\|null but database expects App\\\\Storage\\\\Entity\\\\Person\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Player.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.associationType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Player\\:\\:\\$team type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Team\\|null but database expects App\\\\Storage\\\\Entity\\\\Team\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Player.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.associationType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Staff\\:\\:\\$person type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Person\\|null but database expects App\\\\Storage\\\\Entity\\\\Person\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Staff.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.associationType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Staff\\:\\:\\$team type mapping mismatch\\: property can contain App\\\\Storage\\\\Entity\\\\Team\\|null but database expects App\\\\Storage\\\\Entity\\\\Team\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Staff.php',
];
$ignoreErrors[] = [
	// identifier: doctrine.columnType
	'message' => '#^Property App\\\\Storage\\\\Entity\\\\Team\\:\\:\\$ageCategory type mapping mismatch\\: database can contain App\\\\Domain\\\\TeamAgeCategory\\|null but property expects App\\\\Domain\\\\TeamAgeCategory\\.$#',
	'count' => 1,
	'path' => __DIR__ . '/src/Storage/Entity/Team.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
