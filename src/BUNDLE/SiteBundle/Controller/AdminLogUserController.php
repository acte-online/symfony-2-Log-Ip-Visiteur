<?php
namespace BUNDLE\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use BUNDLE\SiteBundle\Entity\Loguser;

class AdminLogUserController extends Controller
{
    public function AdminLogUserAction()
    {
  	
  	...
  	
	$em = $this->getDoctrine()->getManager();
	$logs = $em->getRepository('BIUNDLESiteBundle:Loguser')->findBy(array(), array('id' => 'DESC'));
	
	$em = $this->getDoctrine()->getManager();
	$pages = $em->getRepository('ACTESiteBundle:Page')->findAll();
	
	$em = $this->getDoctrine()->getManager();
	$articles = $em->getRepository('ACTESiteBundle:Article')->findAll();
	
  	//VUE DE LA PAGE
  	return $this->render('BUNDLESiteBundle:AdministrationPage:Log/loguser.html.twig', array(
  		'logs' => $logs,
		'pages' => $pages,
		'articles' => $articles,
  	));
  	...
    }
}
