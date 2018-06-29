<?php


namespace JuniorISEP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
  public function loginAction(Request $request)
  {





    if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

      return $this->redirectToRoute('junior_isep_vitrine_login_after');
    }




    $authenticationUtils = $this->get('security.authentication_utils');

  

    return $this->render('login.html.twig', array(
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
  }
}

?>
