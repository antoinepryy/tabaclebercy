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


class AdminController extends Controller{



      public function admininfosAction(Request $request){
        $curentUser = $this->getUser()->getEmail();
        if ($curentUser === 'tabacbercy@gmail.com') {
          $entityManager = $this->getDoctrine()->getManager();
          $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('JuniorISEPVitrineBundle:Access');
          $access = $repository->find(1);

          $form = $this->createFormBuilder($access)
            ->add('tabac', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Tabac',
            ))
            ->add('cigaretteElec', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Cigarette électronique',
            ))
            ->add('accessoires', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Accessoires',
            ))
            ->add('alcools', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Alcools & curiosités',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();




          if ($request->isMethod('POST')){
            $form->handleRequest($request);
            $data = $form->getData();


            $access->setTabac($data->getTabac());
            $access->setAccessoires($data->getAccessoires());
            $access->setCigaretteElec($data->getCigaretteElec());
            $access->setAlcools($data->getAlcools());

            $entityManager->persist($access);
            $entityManager->flush();





            return $this->redirectToRoute('junior_isep_vitrine_espaceadmin');

          }


          return $this->render('admin/espaceadmin.html.twig', array(
            'form' => $form->createView(),
          ));}
        else {

          throw $this->createNotFoundException('');

        }
      }

      public function addbrandAction(Request $request){
        $curentUser = $this->getUser()->getEmail();
        if ($curentUser === 'tabacbercy@gmail.com') {
          $entityManager = $this->getDoctrine()->getManager();


          $brand = new Brand();

          $form = $this->createFormBuilder($brand)
            ->add('name', TextType::class, array(
              'label'  => 'Nom : ',
            ))
            ->add('dispAccessoires', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Accessoires : ',
            ))
            ->add('dispAlcools', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Alcools : ',
            ))
            ->add('dispCigaretteElec', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Cigarette électronique : ',
            ))
            ->add('dispTabac', CheckboxType::class, array(
              'required' => false,
              'label'  => 'Tabac : ',
            ))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();




          if ($request->isMethod('POST')){
            $form->handleRequest($request);
            $data = $form->getData();

            $brand->setName($data->getName());
            $brand->setDispTabac($data->getDispTabac());
            $brand->setDispAlcools($data->getDispAlcools());
            $brand->setDispCigaretteElec($data->getDispCigaretteElec());
            $brand->setDispAccessoires($data->getDispAccessoires());

            $entityManager->persist($brand);
            $entityManager->flush();





            return $this->redirectToRoute('junior_isep_vitrine_admin_addbrand', array(
              'status' => "valid",
            ));

            }


          return $this->render('admin/addbrand.html.twig', array(
            'form' => $form->createView(),
            'status' => $request->query->get('status'),
          ));



        }
        else{
          throw $this->createNotFoundException('');
        }

      }



        public function addtabacAction(Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();

            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Section');

            $cigarettes = $repository->findOneBy(array(
              'name' => 'Cigarettes'
            ));
            $cigares = $repository->findOneBy(array(
              'name' => 'Cigares'
            ));
            $tabacpipe = $repository->findOneBy(array(
              'name' => 'Tabac à pipe'
            ));


            $article = new Article();

            $form = $this->createFormBuilder($article)
              ->add('name', TextType::class, array(
                'label'  => 'Nom : ',
              ))
              ->add('description', TextType::class, array(
                'label'  => 'Description : ',
                'required' => false,
              ))
              ->add('price', NumberType::class, array(
                'label'  => 'Prix : ',
              ))
              ->add('section', ChoiceType::class, array(
              'choices' => array(
                'Cigarettes' => $cigarettes,
                'Cigares' => $cigares,
                'Tabac à pipe' => $tabacpipe,
              ),
              'label' => 'Catégorie : ',
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
              ->add('pictureFile', FileType::class, array(
              'label' => 'Image : ',
              'required' => false,
              ))
              ->add('Enregistrer', SubmitType::class)
              ->getForm();




            if ($request->isMethod('POST')){
              $form->handleRequest($request);
              $data = $form->getData();


              $article->setName($data->getName());
              $article->setBrand($data->getBrand());
              $article->setSection($data->getSection());
              $article->setPrice($data->getPrice());
              $article->setBrand($data->getBrand());
              $now = new \DateTime();
              $article->setUpdatedAt($now);
              $article->setPictureFile($data->getPictureFile());



              $entityManager->persist($article);
              $entityManager->flush();





              return $this->redirectToRoute('junior_isep_vitrine_admin_addtabac', array(
                'status' => 'valid',
              ));

            }


            return $this->render('admin/addproduct.html.twig', array(
              'form' => $form->createView(),
              'status' => $request->query->get('status'),
            ));
          }
          else{
            throw $this->createNotFoundException('');
          }




        }

        public function addaccessoireAction(Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();

            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Section');

            $briquets = $repository->findOneBy(array(
              'name' => 'Briquets'
            ));
            $accessoiresCigares = $repository->findOneBy(array(
              'name' => 'Accessoires cigares'
            ));
            $pipes = $repository->findOneBy(array(
              'name' => 'Pipes'
            ));
            $autres = $repository->findOneBy(array(
              'name' => 'Autres'
            ));


            $article = new Article();

            $form = $this->createFormBuilder($article)
              ->add('name', TextType::class, array(
                'label'  => 'Nom : ',
              ))
              ->add('description', TextType::class, array(
                'label'  => 'Description : ',
                'required' => false,
              ))
              ->add('price', NumberType::class, array(
                'label'  => 'Prix : ',
              ))
              ->add('section', ChoiceType::class, array(
              'choices' => array(
                'Briquets' => $briquets,
                'Accessoires Cigares' => $accessoiresCigares,
                'Pipes' => $pipes,
                'Autres' => $autres,
              ),
              'label' => 'Catégorie : ',
              ))
              ->add('brand', EntityType::class, array(
              'class' => 'JuniorISEPVitrineBundle:Brand',
              'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('u')
                ->where('u.dispAccessoires = true');
                },
              'choice_label' => 'name',
              'label' => "Marque : "
              ))
              ->add('available', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Disponible : ',
              ))
              ->add('onOrder', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Sur commande : ',
              ))
              ->add('pictureFile', FileType::class, array(
                'label' => 'Image : ',
              ))
              ->add('Enregistrer', SubmitType::class)
              ->getForm();




            if ($request->isMethod('POST')){
              $form->handleRequest($request);
              $data = $form->getData();


              $article->setName($data->getName());
              $article->setBrand($data->getBrand());
              $article->setSection($data->getSection());
              $article->setPrice($data->getPrice());
              $article->setBrand($data->getBrand());
              $now = new \DateTime();
              $article->setUpdatedAt($now);
              $article->setPictureFile($data->getPictureFile());



              $entityManager->persist($article);
              $entityManager->flush();





              return $this->redirectToRoute('junior_isep_vitrine_admin_addaccessoire', array(
                'status' => 'valid',
              ));

            }


            return $this->render('admin/addproduct.html.twig', array(
              'form' => $form->createView(),
              'status' => $request->query->get('status'),
            ));



          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function addcigaretteelectroniqueAction(Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();

            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Section');

            $materiel = $repository->findOneBy(array(
              'name' => 'Matériel'
            ));
            $junior = $repository->findOneBy(array(
              'name' => 'Junior'
            ));
            $senior = $repository->findOneBy(array(
              'name' => 'Senior'
            ));
            $liquides = $repository->findOneBy(array(
              'name' => 'Liquides'
            ));


            $article = new Article();

            $form = $this->createFormBuilder($article)
              ->add('name', TextType::class, array(
                'label'  => 'Nom : ',
              ))
              ->add('description', TextType::class, array(
                'label'  => 'Description : ',
                'required' => false,
              ))
              ->add('price', NumberType::class, array(
                'label'  => 'Prix : ',
              ))
              ->add('section', ChoiceType::class, array(
              'choices' => array(
                'Matériel' => $materiel,
                'Junior' => $junior,
                'Senior' => $senior,
                'Liquides' => $liquides
              ),
              'label' => 'Catégorie',
              ))
              ->add('brand', EntityType::class, array(
              'class' => 'JuniorISEPVitrineBundle:Brand',
              'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('u')
                ->where('u.dispCigaretteElec = true');
                },
              'choice_label' => 'name',
              'label' => 'Marque : '
              ))
              ->add('available', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Disponible : ',
              ))
              ->add('onOrder', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Sur commande : ',
              ))
              ->add('pictureFile', FileType::class, array(
                'label' => 'Image : ',
                ))
              ->add('Enregistrer', SubmitType::class)
              ->getForm();




            if ($request->isMethod('POST')){
              $form->handleRequest($request);
              $data = $form->getData();


              $article->setName($data->getName());
              $article->setBrand($data->getBrand());
              $article->setSection($data->getSection());
              $article->setPrice($data->getPrice());
              $article->setBrand($data->getBrand());
              $now = new \DateTime();
              $article->setUpdatedAt($now);
              $article->setPictureFile($data->getPictureFile());



              $entityManager->persist($article);
              $entityManager->flush();





              return $this->redirectToRoute('junior_isep_vitrine_admin_addtabac', array(
                'status' => 'valid',
              ));

            }


            return $this->render('admin/addproduct.html.twig', array(
              'form' => $form->createView(),
              'status' => $request->query->get('status'),
            ));



          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function addalcoolsAction(Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();

            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Section');

            $champagnes = $repository->findOneBy(array(
              'name' => 'Champagnes'
            ));
            $vinsrouges = $repository->findOneBy(array(
              'name' => 'Vins rouges'
            ));
            $vinsblancs = $repository->findOneBy(array(
              'name' => 'Vins blancs'
            ));
            $curiosites = $repository->findOneBy(array(
              'name' => 'Curiosités'
            ));
            $spiritueux = $repository->findOneBy(array(
              'name' => 'Spiritueux et liqueurs'
            ));



            $article = new Article();

            $form = $this->createFormBuilder($article)
              ->add('name', TextType::class, array(
                'label'  => 'Nom : ',
              ))
              ->add('description', TextType::class, array(
                'label'  => 'Description : ',
                'required' => false,
              ))
              ->add('price', NumberType::class, array(
                'label'  => 'Prix : ',
              ))
              ->add('section', ChoiceType::class, array(
              'choices' => array(
                'Champagnes' => $champagnes,
                'Vins rouges' => $vinsrouges,
                'Vins blancs' => $vinsblancs,
                'Curiosités' => $curiosites,
                'Spiritueux et liqueurs' => $spiritueux,
              ),
              'label' => 'Catégorie : ',
              ))
              ->add('brand', EntityType::class, array(
              'class' => 'JuniorISEPVitrineBundle:Brand',
              'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('u')
                ->where('u.dispAlcools = true');
                },
              'choice_label' => 'name',
              'label' => 'Marque : '
              ))
              ->add('available', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Disponible : ',
              ))
              ->add('onOrder', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Sur commande : ',
              ))
              ->add('pictureFile', FileType::class, array(
                'label' => 'Image : '
              ))
              ->add('Enregistrer', SubmitType::class)
              ->getForm();




            if ($request->isMethod('POST')){
              $form->handleRequest($request);
              $data = $form->getData();


              $article->setName($data->getName());
              $article->setBrand($data->getBrand());
              $article->setSection($data->getSection());
              $article->setPrice($data->getPrice());
              $article->setBrand($data->getBrand());
              $now = new \DateTime();
              $article->setUpdatedAt($now);
              $article->setPictureFile($data->getPictureFile());



              $entityManager->persist($article);
              $entityManager->flush();





              return $this->redirectToRoute('junior_isep_vitrine_admin_addtabac', array(
                'status' => 'valid',
              ));

            }


            return $this->render('admin/addproduct.html.twig', array(
              'form' => $form->createView(),
              'status' => $request->query->get('status'),
            ));



          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function deleteArticleAction(Request $request, $id){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Article');

            $article = $repository->findOneBy(array(
              'id' => $id,
            ));

            $entityManager->remove($article);
            $entityManager->flush();

            $link = $request->server->get('HTTP_REFERER');
            if ($link[-1] == "e"){
              return $this->redirect($request->server->get('HTTP_REFERER'));
            }
            else{
              $link[-1] = "n";
              $link = $link."one";
              return $this->redirect($link);
            }
          }
          else{
            throw $this->createNotFoundException('');
          }



        }

        public function listbrandAction(){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $repositoryBrand = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Brand');

            $allBrands = $repositoryBrand->findAll();

            return $this->render('admin/brandlist.html.twig', array(
              'brands' => $allBrands,
            ));
          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function deletebrandAction($id, Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();

            $repositoryBrand = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Brand');

            $repositoryArticle = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Article');

            $brand = $repositoryBrand->find($id);

            $articlesToDelete = $repositoryArticle->findBy(array(
              'brand' => $id,
            ));

            foreach($articlesToDelete as $article){

              $entityManager->remove($article);

            }

            $entityManager->remove($brand);
            $entityManager->flush();


            return $this->redirect($request->server->get('HTTP_REFERER'));
          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function modifybrandAction($id, Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();
            $repositoryBrand = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPVitrineBundle:Brand');

            $brand = $repositoryBrand->find($id);

            $form = $this->createFormBuilder($brand)
              ->add('name', TextType::class, array(
                'label'  => 'Nom : ',
              ))
              ->add('dispAccessoires', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Accessoires : ',
              ))
              ->add('dispAlcools', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Alcools : ',
              ))
              ->add('dispCigaretteElec', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Cigarette électronique : ',
              ))
              ->add('dispTabac', CheckboxType::class, array(
                'required' => false,
                'label'  => 'Tabac : ',
              ))
              ->add('Enregistrer', SubmitType::class)
              ->getForm();




            if ($request->isMethod('POST')){
              $form->handleRequest($request);
              $data = $form->getData();

              $brand->setName($data->getName());
              $brand->setDispTabac($data->getDispTabac());
              $brand->setDispAlcools($data->getDispAlcools());
              $brand->setDispCigaretteElec($data->getDispCigaretteElec());
              $brand->setDispAccessoires($data->getDispAccessoires());

              $entityManager->persist($brand);
              $entityManager->flush();





              return $this->redirectToRoute('junior_isep_vitrine_admin_listbrand', array(
                'status' => 'valid',
              ));

            }


            return $this->render('admin/addproduct.html.twig', array(
              'form' => $form->createView(),
              'status' => $request->query->get('status'),
            ));
          }
          else{
            throw $this->createNotFoundException('');
          }


        }

        public function userlistAction(){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPUserBundle:User');

            $listUsers = $repository->findBy(array(
              'isActive' => '1'
            ));


            return $this->render('admin/userlist.html.twig', array(
              'listUsers'=>$listUsers
            ));
          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function acceslistAction(){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPUserBundle:User');
            $listUsers = $repository->findBy(array(
              'isActive' => '0'
            ));

            return $this->render('admin/acceslist.html.twig', array(
              'listUsers'=>$listUsers
            ));
          }
          else{
            throw $this->createNotFoundException('');
          }


        }

        public function deleteuserAction($nextpath, $id){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPUserBundle:User');
            $delUser = $repository->find($id);

            if ($id != 61){
              $entityManager->remove($delUser);
              $entityManager->flush();
            }


            if ($nextpath == 'acces') {
                return $this->redirectToRoute('junior_isep_vitrine_admin_acceslist');
            }

            elseif ($nextpath == 'list') {
              return $this->redirectToRoute('junior_isep_vitrine_admin_userlist');
            }
          }
          else{
            throw $this->createNotFoundException('');
          }


        }

        public function authorizeuserAction($id){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPUserBundle:User');
            $authorizeUser = $repository->find($id);
            $authorizeUser->setIsActive(true);
            $entityManager->flush();

            return $this->redirectToRoute('junior_isep_vitrine_admin_acceslist');
          }
          else{
            throw $this->createNotFoundException('');
          }


        }

        public function logsAction(){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPUserBundle:logs');

            $listLogs = $repository->findAll();


            return $this->render('admin/logs.html.twig', array(
              'listLogs'=>$listLogs
            ));
          }
          else{
            throw $this->createNotFoundException('');
          }

        }

        public function logscleanAction(Request $request){
          $curentUser = $this->getUser()->getEmail();
          if ($curentUser === 'tabacbercy@gmail.com') {
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('JuniorISEPUserBundle:logs');

            $entityManager= $this
            ->getDoctrine()
            ->getManager();

          $listLogs = $repository->findAll();

          foreach ($listLogs as $log){
            $entityManager->remove($log);


          }

          $entityManager->flush();

          return $this->redirect($request->server->get('HTTP_REFERER'));
          }
          else{
            throw $this->createNotFoundException('');
          }


      }



        public function modifycontactAction(Request $request){
          $entityManager = $this->getDoctrine()->getManager()->getRepository('JuniorISEPVitrineBundle:InfosContact');
          $infos = $entityManager->find(1);
          $form1 = $this->createFormBuilder($infos)



            ->add('text', textType::class, array(
              'label' => 'Texte',
            ))
            ->add('Save', SubmitType::class, array('label' => 'Modifier les informations' ))
            ->getForm();



          if ($request->isMethod('POST')) {
            $form1->handleRequest($request);


            if ($form1->isSubmitted() && $form1->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                $data1 = $form1->getData();

                
                $infos->setText($data1->getText());

                $entityManager->persist($infos);
                $entityManager->flush();
                return $this->redirectToRoute('junior_isep_vitrine_espaceadmin');

              }



            }

            return $this->render('admin/modifycontact.html.twig', array(
              'form1' => $form1->createView(),
            ));

        }

        public function modifysentenceAction(Request $request){
          $entityManager = $this->getDoctrine()->getManager()->getRepository('JuniorISEPVitrineBundle:Sentence');
          $text = $entityManager->find(1);
          $form1 = $this->createFormBuilder($text)


            ->add('sentence', textType::class, array(
              'label' => 'Phrase',
            ))

            ->add('Save', SubmitType::class, array(
              'label' => 'Modifier la phrase',
              'attr'  => array('class' => 'btn btn-default pull-right')
              ))
            ->getForm();



          if ($request->isMethod('POST')) {
            $form1->handleRequest($request);


            if ($form1->isSubmitted() && $form1->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                $data1 = $form1->getData();


                $text->setSentence($data1->getSentence());


                $entityManager->persist($text);
                $entityManager->flush();
                return $this->redirectToRoute('junior_isep_vitrine_espaceadmin');

              }



            }

            return $this->render('admin/modifysentence.html.twig', array(
              'form1' => $form1->createView(),
            ));

        }

}
