<?php

use App\Tests\Sample\Domain\User\UserId;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Infrastructure\Middleware\Event\EventLoggerMiddleware;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\StackMiddleware;

it('should should ignore none event envelop message', function () {
    $eventLogger = $this
        ->getMockBuilder(LoggerInterface::class)
        ->getMock()
    ;
    $eventLogger->expects($this->never())
        ->method('info');

    $eventLoggerMiddleware = new EventLoggerMiddleware($eventLogger);

    $eventLoggerMiddleware ->handle(
        new Envelope(new \StdClass()),
        new StackMiddleware()
   );
});

it('should log Domain Event', function () {
    $userUuid = '98264eab-5084-40d2-b805-435327bbc3db';
    $userWasCreated = new UserWasCreatedEvent(UserId::fromString($userUuid));
    $eventLogger = $this
        ->getMockBuilder(LoggerInterface::class)
        ->getMock()
    ;
    $eventLogger->expects($this->once())
        ->method('info')
        ->with(sprintf('Event for %s dispatched to the bus', $userWasCreated->getAggregateClassName()))
    ;

    $eventLoggerMiddleware = new EventLoggerMiddleware($eventLogger);
    $eventLoggerMiddleware->handle(
        new Envelope($userWasCreated),
        new StackMiddleware()
    );
});
