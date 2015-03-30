<?php

namespace Ilc\Bundle\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ilc\Bundle\ShopBundle\Entity\Client;
use Ilc\Bundle\ShopBundle\Form\ClientType;


class SecurityController extends Controller
{
	/**
     * @Route("login", name="login")
     * @Template()
     */
    public function loginAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('index'));
        }
        $request = $this->getRequest();
        $session = $request->getSession();
        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return array(
                    // Valeur du précédent nom d'utilisateur entré par l'internaute
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
        );
    }

    /**
     * @Route("signup", name="signup")
     * @Template()
     */
    public function signupAction(Request $request) {
        $objClient = new Client();
        
        $form = $this->createForm(new ClientType(), $objClient);
        
        $form->add('Signup', 'submit', array(
            'attr' => array(
                'class' => 'btn',
            ),
        ));
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.encoder_factory')
                    ->getEncoder($objClient);

            $objClient->setSalt(md5(uniqid()));
            $objClient->setPassword($encoder->encodePassword($form->get('password')->getData(), $objClient->getSalt()));
            
            $group = $em->getRepository('IlcShopBundle:Group')->findOneBy(array('role' => 'ROLE_USER'));
            $objClient->addGroup($group);
            
            
            $em->persist($objClient);
            $em->flush();
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("logout", name="logout")
     */
    public function logoutAction() {
        // Action par défaut
    }
    
    /**
     * @Route("login_check", name="login_check")
     */
    public function loginCheckAction() {
        // Action par défaut
    }
}