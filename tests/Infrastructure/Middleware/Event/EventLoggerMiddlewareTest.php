<?php

namespace App\Tests\Infrastructure\Middleware\Event;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\Sample\Domain\User\UserId;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Infrastructure\Middleware\Event\EventLoggerMiddleware;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\StackMiddleware;

class EventLoggerMiddlewareTest extends KernelTestCase
{
    #[Test]
    public function it_should_ignore_none_event_envelop_message(): void
    {
        $eventLogger = $this
            ->getMockBuilder(LoggerInterface::class)
            ->getMock()
        ;
        $eventLogger->expects($this->never())
            ->method('info');

        $eventLoggerMiddleware = new EventLoggerMiddleware($eventLogger);

        $eventLoggerMiddleware->handle(
            new Envelope(new \StdClass()),
            new StackMiddleware()
       );
    }

    #[Test]
    public function it_should_log_domain_events(): void
    {
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
    }
}