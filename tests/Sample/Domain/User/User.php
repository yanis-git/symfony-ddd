<?php

namespace App\Tests\Sample\Domain\User;

use Domain\Core\Aggregate\AggregateRootAbstract;
use Domain\Core\Contract\EntityIdInterface;
use Exception;

class User extends AggregateRootAbstract
{
    public function __construct(EntityIdInterface $userId)
    {
        parent::__construct($userId);
    }

    /**
     * @throws Exception
     */
    public static function create(): User
    {
        $user = new User(UserId::generate());
        $user->recordEvent(new UserWasCreatedEvent($user->getUuid()));
        return $user;
    }

    public function jsonData(): array
    {
        return [
            'foo' => 'bar',
        ];
    }
}
