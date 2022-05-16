<?php
namespace Infrastructure\Service\Event;

use Domain\Core\Contract\DomainEventInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

class EventLogger implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function logEvent(DomainEventInterface $event)
    {
        $logger = $this->getLogger($event);
        $logger?->writeInfo(
            sprintf('Event for %s dispatched to the bus', $event->getAggregateClassName()),
            [
                'aggregateName' => $event->getAggregateClassName(),
                'aggregateId' => (string)$event->getAggregateId(),
                'version' => $event->getVersion(),
                'name' => $event->getEventName(),
            ]
        );
    }

    /**
     * @return mixed
     */
    private function getLogger(DomainEventInterface $event)
    {
        $loggerName = strtolower($event->getAggregateClassName()) . '.logger';

        if (!array_key_exists($loggerName, self::getSubscribedServices())) {
            return null;
        }

        return $this->container->get(strtolower($event->getAggregateClassName()) . '.logger');
    }

    public static function getSubscribedServices(): array
    {
        return [];
    }
}
