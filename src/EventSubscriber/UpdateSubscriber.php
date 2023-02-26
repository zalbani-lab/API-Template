<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class UpdateSubscriber implements EventSubscriberInterface
{
    protected array $updateMethods = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
    ];

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['update', EventPriorities::POST_VALIDATE],
        ];
    }

    public function update(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (in_array($method, $this->updateMethods, true)) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}