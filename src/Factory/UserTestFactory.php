<?php

namespace App\Factory;

use App\Entity\UserTest;
use App\Repository\UserTestRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<UserTest>
 *
 * @method static UserTest|Proxy createOne(array $attributes = [])
 * @method static UserTest[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static UserTest|Proxy find(object|array|mixed $criteria)
 * @method static UserTest|Proxy findOrCreate(array $attributes)
 * @method static UserTest|Proxy first(string $sortedField = 'id')
 * @method static UserTest|Proxy last(string $sortedField = 'id')
 * @method static UserTest|Proxy random(array $attributes = [])
 * @method static UserTest|Proxy randomOrCreate(array $attributes = [])
 * @method static UserTest[]|Proxy[] all()
 * @method static UserTest[]|Proxy[] findBy(array $attributes)
 * @method static UserTest[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static UserTest[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserTestRepository|RepositoryProxy repository()
 * @method UserTest|Proxy create(array|callable $attributes = [])
 */
final class UserTestFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->email(),
            'roles' => [],
            'password' => self::faker()->password(),
            'name' => self::faker()->name(),
            'firstname' => self::faker()->firstName(),
            'phone' => self::faker()->phoneNumber(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(UserTest $userTest) {})
        ;
    }

    protected static function getClass(): string
    {
        return UserTest::class;
    }
}