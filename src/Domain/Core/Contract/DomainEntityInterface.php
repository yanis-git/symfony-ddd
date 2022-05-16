<?php

namespace Domain\Core\Contract;

interface DomainEntityInterface
{
    public function getUuid(): EntityIdInterface;

    public function __toString();
}
