<?php

namespace App\Factory;

use App\Entity\DrivingSessionBooking;
use App\Repository\DrivingSessionBookingRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<DrivingSessionBooking>
 *
 * @method        DrivingSessionBooking|Proxy                     create(array|callable $attributes = [])
 * @method static DrivingSessionBooking|Proxy                     createOne(array $attributes = [])
 * @method static DrivingSessionBooking|Proxy                     find(object|array|mixed $criteria)
 * @method static DrivingSessionBooking|Proxy                     findOrCreate(array $attributes)
 * @method static DrivingSessionBooking|Proxy                     first(string $sortedField = 'id')
 * @method static DrivingSessionBooking|Proxy                     last(string $sortedField = 'id')
 * @method static DrivingSessionBooking|Proxy                     random(array $attributes = [])
 * @method static DrivingSessionBooking|Proxy                     randomOrCreate(array $attributes = [])
 * @method static DrivingSessionBookingRepository|RepositoryProxy repository()
 * @method static DrivingSessionBooking[]|Proxy[]                 all()
 * @method static DrivingSessionBooking[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static DrivingSessionBooking[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static DrivingSessionBooking[]|Proxy[]                 findBy(array $attributes)
 * @method static DrivingSessionBooking[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static DrivingSessionBooking[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class DrivingSessionBookingFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'date' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'instructor' => InstructorFactory::new(),
            'status' => self::faker()->text(255),
            'student' => StudentFactory::new(),
            'time' => \DateTimeImmutable::createFromMutable(self::faker()->datetime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(DrivingSessionBooking $drivingSessionBooking): void {})
        ;
    }

    protected static function getClass(): string
    {
        return DrivingSessionBooking::class;
    }
}
