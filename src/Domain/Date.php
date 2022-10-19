<?php

declare(strict_types=1);

namespace App\Domain;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\Exceptions\InvalidFormatException;
use DateTimeInterface;
use JsonSerializable;
use LogicException;
use RuntimeException;
use Stringable;
use Throwable;

use function sprintf;

final class Date implements JsonSerializable, Stringable
{
    private const FORMAT = 'Y-m-d';

    private readonly CarbonInterface $carbon;

    private function __construct(DateTimeInterface $dateTime)
    {
        $this->carbon = CarbonImmutable::parse($dateTime)->setTime(0, 0);
    }

    public static function fromString(string $dateString): self
    {
        try {
            $date = CarbonImmutable::createFromFormat(self::FORMAT, $dateString, 'UTC');
            if ($date === false) {
                throw new InvalidFormatException('Invalid format', 1627987262343);
            }

            $date = CarbonImmutable::createSafe(
                $date->year,
                $date->month,
                $date->day,
                0,
                0,
                0,
                'UTC',
            );

            if ($date === false || $date->format(self::FORMAT) !== $dateString) {
                throw new InvalidFormatException('Invalid format', 1627987768869);
            }
        } catch (Throwable $exception) {
            throw new RuntimeException(
                sprintf(
                    'Unable to create Date from string "%s". Format must be "%s".',
                    $dateString,
                    self::FORMAT,
                ),
                1627987213388,
                $exception,
            );
        }

        return new self($date);
    }

    public static function fromDateTime(DateTimeInterface $date): self
    {
        return self::fromString($date->format(self::FORMAT));
    }

    public function format(string $format): string
    {
        return $this->carbon->format($format);
    }

    public function translatedFormat(string $format): string
    {
        return $this->carbon->translatedFormat($format);
    }

    public function equals(self $otherDate): bool
    {
        return $this->carbon->format(self::FORMAT) === $otherDate->format(self::FORMAT);
    }

    public function isLaterThan(self $otherDate): bool
    {
        return $this->carbon > $otherDate->carbon;
    }

    public function isLaterOrEqualThan(self $otherDate): bool
    {
        return $this->carbon >= $otherDate->carbon;
    }

    public function isEarlierThan(self $otherDate): bool
    {
        return $this->carbon < $otherDate->carbon;
    }

    public function isEarlierOrEqualThan(self $otherDate): bool
    {
        return $this->carbon <= $otherDate->carbon;
    }

    public function addDays(int $days): self
    {
        return new self(
            $this->carbon->addRealDays($days),
        );
    }

    public function subtractDays(int $days): self
    {
        return new self(
            $this->carbon->subRealDays($days),
        );
    }

    public function addYears(int $years): self
    {
        return new self(
            $this->carbon->addYears($years),
        );
    }

    public function lastDayOfNextMonth(): self
    {
        return $this->lastDayOfMonth()->addDays(1)->lastDayOfMonth();
    }

    public function lastDayOfMonth(): self
    {
        return new self(
            $this->carbon->lastOfMonth(),
        );
    }

    public function subtractMonths(int $months): self
    {
        return new self(
            $this->carbon->subMonths($months),
        );
    }

    public function toDateTimeImmutable(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->carbon);
    }

    public function toDateTime(): Carbon
    {
        return Carbon::parse($this->carbon);
    }

    /** @return array<Date> */
    public static function createInclusiveDatePeriod(
        Date $startDate,
        Date $endDate,
    ): array {
        if ($endDate->isEarlierThan($startDate)) {
            throw new LogicException('Provided Enddate is earlier than Startdate');
        }

        $latestDate = $startDate;
        $dates      = [$latestDate];

        while ($endDate->isLaterThan($latestDate)) {
            $latestDate = $latestDate->addDays(1);
            $dates[]    = $latestDate;
        }

        return $dates;
    }

    public function __toString(): string
    {
        return $this->format(self::FORMAT);
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }
}
