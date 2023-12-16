<?php

namespace App\Factory;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Student>
 *
 * @method        Student|Proxy                     create(array|callable $attributes = [])
 * @method static Student|Proxy                     createOne(array $attributes = [])
 * @method static Student|Proxy                     find(object|array|mixed $criteria)
 * @method static Student|Proxy                     findOrCreate(array $attributes)
 * @method static Student|Proxy                     first(string $sortedField = 'id')
 * @method static Student|Proxy                     last(string $sortedField = 'id')
 * @method static Student|Proxy                     random(array $attributes = [])
 * @method static Student|Proxy                     randomOrCreate(array $attributes = [])
 * @method static StudentRepository|RepositoryProxy repository()
 * @method static Student[]|Proxy[]                 all()
 * @method static Student[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Student[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Student[]|Proxy[]                 findBy(array $attributes)
 * @method static Student[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Student[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class StudentFactory extends ModelFactory
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
            'registeredAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'roles' => ['ROLE_STUDENT'],
            'credit' => self::faker()->numberBetween(0, 20),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
             ->afterInstantiate(function(Student $student): void {
                 $student->setPassword($this->hasher->hashPassword($student, $student->getPassword()));
                 $student->agreeTerms();
             })
        ;
    }

    protected static function getClass(): string
    {
        return Student::class;
    }
}
