<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class PasswordHasherSubscriber implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE],
        ];
    }

    public function hashPassword(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $requestContent = json_decode($event->getRequest()->getContent());

        // encode password only if the property password is present inside the request content
        if (isset($requestContent->password)) {
            if ($user instanceof User) {
                $userPassword = $user->getPassword();
                $encodedPassword = $this->passwordHasher->hashPassword($user, $userPassword);
                $user->setPassword($encodedPassword);
            }
        }
    }

}