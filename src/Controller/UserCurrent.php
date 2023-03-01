<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCurrent extends AbstractController
{
  private ?UserInterface $user;

  public function __construct(Security $security)
  {
    $this->user = $security->getUser();
  }

  public function __invoke(): UserInterface
  {
    return $this->user;
  }
}
