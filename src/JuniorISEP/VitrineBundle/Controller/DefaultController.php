<?php

namespace JuniorISEP\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use JuniorISEP\UserBundle\Entity\User;
use JuniorISEP\UserBundle\Entity\logs;
use JuniorISEP\VitrineBundle\Entity\Article;
use JuniorISEP\VitrineBundle\Entity\Sentence;
use JuniorISEP\VitrineBundle\Entity\Brand;
use JuniorISEP\VitrineBundle\Entity\Section;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route as Route;



class DefaultController extends Controller{

    public function getLawSentenceAction(){

      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('JuniorISEPVitrineBundle:Sentence');



      $sentence = $repository->find(1);
      $text = $sentence->getSentence();

      return new Response(
        $text

        );
    }


    public function indexAction(Request $request)
    {

      return $this->render('vitrine/accueil.html.twig');
    }

    public function connectionorregistrationAction(){
      return $this->render('index.html.twig');
    }

    public function verificationsAction(Request $request)
    {
      $curentUser = $this->getUser()->getEmail();
      if ($curentUser === 'tabacbercy@gmail.com') {



        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $now = new \DateTime();

        $entityManager = $this->getDoctrine()->getManager();

        $log = new logs();

        $log->setDatetime($now);
        $log->setIp($ip);

        $entityManager->persist($log);

        $entityManager->flush();

      }
      return $this->redirectToRoute('junior_isep_vitrine_accueil');

      }







    public function accueilAction(Request $request)
    {



      return $this->render('vitrine/accueil.html.twig');



    }

    public function cigarettesAction($page, $order, $form, Request $request)  {
    $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');


    $nb = 8;

    $offset = $nb * $page ;
    $offset = $offset - $nb;

      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('JuniorISEPVitrineBundle:Article');

      $repositoryAccess = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('JuniorISEPVitrineBundle:Access');

      $repositoryBrand = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('JuniorISEPVitrineBundle:Brand');

      $listArticles = $repository->findArticle(1,$order,$page,$repositoryBrand);


      $state = $repositoryAccess->find(1)->getTabac();

      if ($form != 'none'){
        $article = $listArticles[$form];
        $formView = $this->createFormBuilder($article)
          ->add('name', TextType::class, array(
            'label'  => 'Nom : ',
          ))
          ->add('description', TextType::class, array(
            'label'  => 'Description : ',
          ))
          ->add('price', NumberType::class, array(
            'label'  => 'Prix : ',
          ))
          ->add('brand', EntityType::class, array(
          'class' => 'JuniorISEPVitrineBundle:Brand',
          'query_builder' => function(EntityRepository $er){
            return $er->createQueryBuilder('u')
            ->where('u.dispTabac = true');
            },
          'choice_label' => 'name',
          'label' => 'Marque : ',

          ))
          ->add('available', CheckboxType::class, array(
            'required' => false,
            'label'  => 'Disponible : ',
          ))
          ->add('onOrder', CheckboxType::class, array(
            'required' => false,
            'label'  => 'Sur commande : ',
          ))
          ->add('Enregistrer', SubmitType::class)
          ->getForm();


        if ($request->isMethod('POST')){
          $entityManager = $this->getDoctrine()->getManager();
          $formView->handleRequest($request);
          $data = $formView->getData();


          $article->setName($data->getName());
          $article->setDescription($data->getDescription());
          $article->setPrice($data->getPrice());
          $article->setBrand($data->getBrand());


          $entityManager->persist($article);
          $entityManager->flush();





          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>1,
            'form'=>'none',
            'sentence' => $response->getContent(),
          ));

        }

        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>1,
          'form'=>$formView->createView(),
          'sentence' => $response->getContent(),

        ));

      }


      return $this->render('vitrine/articles.html.twig', array(
        'order'=>$order,
        'page'=>$page,
        'listArticles'=>$listArticles,
        'state'=>$state,
        'section'=>1,
        'form'=>'none',
        'sentence' => $response->getContent(),

      ));

    }

    public function cigaresAction($page, $order, $form, Request $request)
    {
      $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');

      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(2,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getTabac();




        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispTabac = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>1,
              'form'=>'none',
              'sentence' => $response->getContent(),
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>1,
            'form'=>$formView->createView(),
            'sentence' => $response->getContent(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>1,
          'form'=>'none',
          'sentence' => $response->getContent(),

        ));

    }

    public function tabacapipeAction($page, $order, $form, Request $request)
    {
      $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');

      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(3,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getTabac();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispTabac = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>1,
              'form'=>'none',
              'sentence' => $response->getContent(),
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>1,
            'form'=>$formView->createView(),
            'sentence' => $response->getContent(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>1,
          'form'=>'none',
          'sentence' => $response->getContent(),

        ));


    }
    public function cigaretteelectroniquejuniorAction($page, $order, $form, Request $request)
    {
      $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(5,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getCigaretteElec();


        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispCigaretteElec = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>2,
              'form'=>'none',
              'sentence' => $response->getContent(),
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>2,
            'form'=>$formView->createView(),
            'sentence' => $response->getContent(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>2,
          'form'=>'none',
          'sentence' => $response->getContent(),

        ));


    }

    public function cigaretteelectroniqueseniorAction($page, $order, $form, Request $request)
    {
      $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(6,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getCigaretteElec();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispCigaretteElec = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>2,
              'form'=>'none',
              'sentence' => $response->getContent(),
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>2,
            'form'=>$formView->createView(),
            'sentence' => $response->getContent(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>2,
          'form'=>'none',
          'sentence' => $response->getContent(),

        ));



    }

    public function materielAction($page, $order, $form, Request $request)
    {
      $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(4,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getCigaretteElec();


        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispCigaretteElec = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>2,
              'form'=>'none',
              'sentence' => $response->getContent(),
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>2,
            'form'=>$formView->createView(),
            'sentence' => $response->getContent(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>2,
          'form'=>'none',
          'sentence' => $response->getContent(),

        ));


    }
    public function liquidesAction($page, $order, $form, Request $request)
    {
      $response = $this->forward('JuniorISEPVitrineBundle:Default:getLawSentence');
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(7,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getCigaretteElec();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispCigaretteElec = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>2,
              'form'=>'none',
              'sentence' => $response->getContent(),
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>2,
            'form'=>$formView->createView(),
            'sentence' => $response->getContent(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>2,
          'form'=>'none',
          'sentence' => $response->getContent(),

        ));


    }
    public function briquetsAction($page, $order, $form, Request $request){
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(8,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAccessoires();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAccessoires = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>3,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>3,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>3,
          'form'=>'none',

        ));


    }


    public function accessoirescigaresAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(16,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAccessoires();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAccessoires = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>3,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>3,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>3,
          'form'=>'none',

        ));




    }
    public function pipesAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(9,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAccessoires();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAccessoires = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>3,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>3,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>3,
          'form'=>'none',

        ));




    }
    public function autresAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(10,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAccessoires();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAccessoires = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>3,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>3,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>3,
          'form'=>'none',

        ));




    }
    public function champagnesAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(11,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAlcools();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAlcools = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>4,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>4,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>4,
          'form'=>'none',

        ));



    }

    public function vinsrougesAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(12,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAlcools();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAlcools = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>4,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>4,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>4,
          'form'=>'none',

        ));

    }

    public function vinsblancsAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(13,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAlcools();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAlcools = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>4,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>4,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>4,
          'form'=>'none',

        ));

    }

    public function curiositesAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(14,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAlcools();

        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAlcools = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>4,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>4,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>4,
          'form'=>'none',

        ));

    }

    public function spiritueuxAction($page, $order, $form, Request $request)
    {
      $nb = 8;

      $offset = $nb * $page ;
      $offset = $offset - $nb;

        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Article');

        $repositoryAccess = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Access');

        $repositoryBrand = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPVitrineBundle:Brand');

        $listArticles = $repository->findArticle(15,$order,$page,$repositoryBrand);

        $state = $repositoryAccess->find(1)->getAlcools();



        if ($form != 'none'){
          $article = $listArticles[$form];
          $formView = $this->createFormBuilder($article)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('description', TextType::class, array(
              'label'  => 'Description : ',
            ))
            ->add('price', NumberType::class, array(
              'label'  => 'Prix : ',
            ))
            ->add('brand', EntityType::class, array(
            'class' => 'JuniorISEPVitrineBundle:Brand',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('u')
              ->where('u.dispAlcools = true');
              },
            'choice_label' => 'name',
            'label' => 'Marque : ',

            ))
            ->add('available', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Disponible : ',
            ))
            ->add('onOrder', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Sur commande : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();


          if ($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $formView->handleRequest($request);
            $data = $formView->getData();


            $article->setName($data->getName());
            $article->setDescription($data->getDescription());
            $article->setPrice($data->getPrice());
            $article->setBrand($data->getBrand());


            $entityManager->persist($article);
            $entityManager->flush();





            return $this->render('vitrine/articles.html.twig', array(
              'order'=>$order,
              'page'=>$page,
              'listArticles'=>$listArticles,
              'state'=>$state,
              'section'=>4,
              'form'=>'none',
            ));

          }

          return $this->render('vitrine/articles.html.twig', array(
            'order'=>$order,
            'page'=>$page,
            'listArticles'=>$listArticles,
            'state'=>$state,
            'section'=>4,
            'form'=>$formView->createView(),

          ));

        }


        return $this->render('vitrine/articles.html.twig', array(
          'order'=>$order,
          'page'=>$page,
          'listArticles'=>$listArticles,
          'state'=>$state,
          'section'=>4,
          'form'=>'none',

        ));

    }



    public function loginAction()
    {
      return $this->render('login.html.twig');
    }

    public function registerAction()
    {
      return $this->render('register.html.twig');
    }

    public function infosAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {


        $curentUser = $this->getUser();


              $form1 = $this->createFormBuilder($curentUser)

              ->add('Email', EmailType::class, array(
                'label' => 'Email : ',
              ))
              ->add('saveEmail', SubmitType::class, array('label' => 'Changer Email' ))
              ->getForm();



              if ($request->isMethod('POST')) {
                $form1->handleRequest($request);


                if ($form1->isSubmitted()) {

                    $entityManager = $this->getDoctrine()->getManager();

                    $data1 = $form1->getData();
                    $mail=$data1->getEmail();
                    $curentUser->setEmail($mail);
                    $entityManager->persist($curentUser);
                    $entityManager->flush();

                    return $this->redirectToRoute('junior_isep_vitrine_espaceclient', array(
                      'status' => 'valid',
                    ));



                }


              }

            return $this->render('infos.html.twig', array(
              'form1' => $form1->createView(),
              'status' => $request->query->get('status'),
            ));
    }


    public function changepasswordAction(Request $request,  UserPasswordEncoderInterface $passwordEncoder){
      $curentUser = $this->getUser();
      $form1 = $this->createFormBuilder($curentUser)


        ->add('plainPassword', RepeatedType::class, array(
          'type' => PasswordType::class,
          'first_options'  => array('label' => 'Mot de passe'),
          'second_options' => array('label' => 'Confirmer mot de passe'),
        ))
        ->add('savePassword', SubmitType::class, array('label' => 'Changer mot de passe' ))
        ->getForm();



      if ($request->isMethod('POST')) {
        $form1->handleRequest($request);


        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $data1 = $form1->getData();

            $pass=$data1->getPlainPassword();
            $password = $passwordEncoder->encodePassword($curentUser, $pass);
            $curentUser->setPassword($password);
            $entityManager->persist($curentUser);
            $entityManager->flush();
            return $this->redirectToRoute('junior_isep_vitrine_changepassword', array(
              'status' => 'valid',
            ));

          }



        }

        return $this->render('changepassword.html.twig', array(
          'form1' => $form1->createView(),
          'status' => $request->query->get('status'),
        ));

    }



  public function contactAction(){
   $entityManager = $this->getDoctrine()->getManager()->getRepository('JuniorISEPVitrineBundle:InfosContact');
   $infos = $entityManager->find(1);
   return $this->render('vitrine/contact.html.twig', array(
     'infos' => $infos,
   ));

  }

    public function forgotpasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
    $user = new User();

    $form1 = $this->createFormBuilder($user)


      ->add('email', EmailType::class)
      ->add('plainPassword', HiddenType::class,array(
        'data' => 'abcde',
      ))
      ->add('Save', SubmitType::class, array('label' => 'Envoyer nouveau mot de passe') )
      ->getForm();



    if ($request->isMethod('POST')) {
      $form1->handleRequest($request);


      if ($form1->isSubmitted() && $form1->isValid()) {
        $data1 = $form1->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('JuniorISEPUserBundle:User');
        $foundUser = $repository->findOneBy(array(
          'email' => $data1->getEmail() ,
        ));

        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        $passwordToSend = implode($pass);

        if ($foundUser){
          $password = $passwordEncoder->encodePassword($foundUser, implode($pass));
          $foundUser->setPassword($password);
          $entityManager->persist($foundUser);
          $entityManager->flush();
          $message = (new \Swift_Message('[Tabac Le Bercy] Changement de mot de passe'))
           ->setFrom('antoine.ap.57@gmail.com')
           ->setTo($foundUser->getEmail())
           ->setBody('Bonjour, votre nouveau mot de passe a été réinitialisé : '.$passwordToSend)
          ;
          $this->get('mailer')->send($message);
          return $this->render('forgot.html.twig', array(
            'form1' => $form1->createView(),
            'status' =>'valid',
          ));

        }
        else{
          return $this->render('forgot.html.twig', array(
            'form1' => $form1->createView(),
            'status' =>'notfound',
          ));

        }}}


      return $this->render('forgot.html.twig', array(
        'form1' => $form1->createView(),
        'status' => $request->query->get('status'),

      ));

    }

    public function mentionslegalesAction(){
      return $this->render('vitrine/mentionslegales.html.twig');
    }

    public function testAction(Request $request){

      $pass = "12345";

      $message = (new \Swift_Message('Hello Email'))
        ->setFrom('antoine.ap.57@gmail.com')
        ->setTo('aperry@juniorisep.com')
        ->setBody('Votre nouveau mot de passe est'.$pass)
      ;
      $this->get('mailer')->send($message);
      return $this->render('vitrine/mentionslegales.html.twig');
}}
