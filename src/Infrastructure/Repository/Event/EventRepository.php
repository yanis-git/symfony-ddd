<?php

namespace Infrastructure\Repository\Event;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Core\Contract\DomainEntityInterface;
use Domain\Core\Contract\DomainEventInterface;
use Domain\Core\Event\DomainEvents;
use Domain\Core\Event\EventId;
use Domain\Core\Repository\EventRepositoryInterface;
use Exception;
use Infrastructure\Entity\Event\Event;
use Infrastructure\Transformer\Event\EventTransformer;
use LogicException;


/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EventTransformer $eventTransformer,
    )
    {
        parent::__construct($registry, Event::class);
    }

    public function persist(DomainEvents $domainEvents, ?string $userUuid = null): void
    {
        foreach ($domainEvents as $domainEvent) {
            $eventEntity = $this->eventTransformer->fromDomain($domainEvent, $userUuid);
            $this->_em->persist($eventEntity);
        }
    }

    public function fetch(int $page, int $countPerPage): array
    {
        $qb = $this->createQueryBuilder('m');
        $qb->select()->setMaxResults($countPerPage)->setFirstResult(($page - 1) * $countPerPage);

        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function fetchByAggregate(DomainEntityInterface $aggregateRoot): DomainEvents
    {
        throw new Exception('Not yet implemented.');
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function get(EventId $eventId): DomainEventInterface
    {
        $event = $this->findOneBy(['uuid' => $eventId]);

        if (!$event instanceof Event) {
            throw new LogicException(sprintf('Event with uuid %s not found.', $eventId));
        }

        return $this->eventTransformer->toDomain($event);
    }

    public function fetchByUuids(array $eventIds): DomainEvents
    {
        $events = $this->findBy(['uuid' => $eventIds]);
        // return directly entity event because we do not have a way to transform it to domain
        return new DomainEvents($events);
    }

    /**
     * @return array
     */
    public function fetchByVersion(string $version)
    {
        return $this->findBy(['version' => $version]);
    }

    /**
     * @throws Exception
     */
    public function fetchByAggregateAndId(DomainEntityInterface $aggregateRoot, EventId $eventId): DomainEvents
    {
        throw new Exception('Not yet implemented.');
    }
}
