<?php

namespace App\Factory;

use App\Entity\Instructor;
use App\Repository\InstructorRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Instructor>
 *
 * @method        Instructor|Proxy                     create(array|callable $attributes = [])
 * @method static Instructor|Proxy                     createOne(array $attributes = [])
 * @method static Instructor|Proxy                     find(object|array|mixed $criteria)
 * @method static Instructor|Proxy                     findOrCreate(array $attributes)
 * @method static Instructor|Proxy                     first(string $sortedField = 'id')
 * @method static Instructor|Proxy                     last(string $sortedField = 'id')
 * @method static Instructor|Proxy                     random(array $attributes = [])
 * @method static Instructor|Proxy                     randomOrCreate(array $attributes = [])
 * @method static InstructorRepository|RepositoryProxy repository()
 * @method static Instructor[]|Proxy[]                 all()
 * @method static Instructor[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Instructor[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Instructor[]|Proxy[]                 findBy(array $attributes)
 * @method static Instructor[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Instructor[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class InstructorFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
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
            'email' => self::faker()->email(),
            'firstname' => self::faker()->firstName(),
            'isVerified' => self::faker()->boolean(),
            'name' => self::faker()->name(),
            'password' => 'password',
            'phone' => self::faker()->phoneNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
             ->afterInstantiate(function(Instructor $instructor): void {
                $instructor->setPassword($this->hasher->hashPassword($instructor, $instructor->getPassword()));
             })
        ;
    }

    protected static function getClass(): string
    {
        return Instructor::class;
    }
}
