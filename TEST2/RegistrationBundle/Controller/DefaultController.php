<?php

namespace TEST2\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TEST2\RegistrationBundle\Entity\Account;

class DefaultController extends Controller
{
    public function provinceAjaxCallAction(Request $request)
    {

        if (!$request->isXmlHttpRequest())
        {
            throw new NotFoundHttpException();
        }

        $id = $request->query->get('province_id');

        $cities = $this
                  ->getDoctrine()
                  ->getManager()
                  ->getRepository('TEST2RegistrationBundle:City')
                  ->findByProvinceId($id);

        $result = array();
        foreach($cities as $city){
            $result[$city->getId()] = $city->getName();
        }
        return new JsonResponse($result);
    }

    public function indexAction(Request $request)
    {
        $account = new Account();

        $form = $this->createForm('TEST2\RegistrationBundle\Form\AccountType', $account);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $this->getDoctrine()->getManager()->persist($account);
            $this->getDoctrine()->getManager()->flush();

            //return $this->redirectToRoute('test_registration_homepage');
        }

        return $this->render('TEST2RegistrationBundle:Default:index.html.twig', array('form_account' => $form->createView()));
    }
}
