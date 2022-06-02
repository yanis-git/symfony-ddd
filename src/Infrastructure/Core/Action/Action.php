<?php

namespace Infrastructure\Core\Action;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

abstract class Action implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public static function getSubscribedServices(): array
    {
        return [
            'messenger.default_bus' => '?' . MessageBusInterface::class,
            'router' => '?' . RouterInterface::class,
        ];
    }

    protected function getRouter(): RouterInterface
    {
        return $this->container->get('router');
    }

    protected function query($query)
    {
        $envelop = $this->getMessageBus()->dispatch($query);
        /** @var HandledStamp $stamp */
        $stamp = $envelop->last(HandledStamp::class);

        return $stamp->getResult();
    }


    protected function getMessageBus(): MessageBusInterface
    {
        return $this->container->get('internal_bus');
    }

    protected function command($command)
    {
        $envelop = $this->getMessageBus()->dispatch($command);
        /** @var HandledStamp $stamp */
        $stamp = $envelop->last(HandledStamp::class);

        return $stamp->getResult();
    }
}
