<?php

namespace JuniorISEP\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JuniorISEP\UserBundle\Entity\User;

class LoadUser implements FixtureInterface
{
  public function load(ObjectManager $manager){
    $listName = array('Alexandre', 'Marine', 'Anna');

    foreach ($listName as $name) {
      $user = new User;

      $user->setUsername($name);
      // $user->setFirstname($name);
      // $user->setLastname($name);
      $user->setPassword($name);
      // $user->setBirthdate(new \DateTime('11-11-1997'));
      // $user->setAcces(false);
      $user->setEmail($name);


      // On ne se sert pas du sel pour l'instant
      // $user->setSalt('');
      // On définit uniquement le role ROLE_USER qui est le role de base
      // $user->setRoles(array('ROLE_USER'));

      // On le persiste
      $manager->persist($user);
    }

    $manager->flush();
  }
}

?>
