<?php

namespace SensioLabs\JobBoardBundle\Controller;

use SensioLabs\JobBoardBundle\Entity\Announcement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return $this->render('SensioLabsJobBoardBundle:Includes:job_container.html.twig');
        }

        return array();
    }

    /**
     * @Route("/post", name="job_post")
     * @Template()
     */
    public function postAction(Request $request)
    {
        $announcement = new Announcement();
        $form = $this->createForm('sensiolabs_jobboardbundle_announcement', $announcement, [
            'action' => $this->generateUrl('job_post'),
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('session')->set('announcement_preview', $announcement);

            return $this->redirect($this->generateUrl('job_preview', [
                'country' => $announcement->getCountry(),
                'contractType' => $announcement->getContractType(),
                'slug' => $announcement->getSlug(),//,
            ]));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/manage", name="manage")
     * @Template()
     */
    public function manageAction()
    {
        return array();
    }
}
