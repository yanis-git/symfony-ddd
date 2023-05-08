<?php

namespace Domain\Core\Event;

use Domain\Core\Aggregate\AggregateRootAbstract;

interface EventManagerInterface
{
    /*
     * Add new aggregate reference
     */
    public function persist(AggregateRootAbstract $aggregateRoot): void;

    /*
     * clear all registered aggregate reference
     */
    public function clear(): void;

    /*
     * fetch all aggregate registered references
     */
    public function getAggregates(): array;

    /*
     * stop track for an aggregate
     */
    public function detach(AggregateRootAbstract $aggregateRoot): void;
}
