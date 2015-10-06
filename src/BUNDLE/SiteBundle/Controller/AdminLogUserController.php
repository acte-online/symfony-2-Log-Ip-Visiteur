<?php
namespace BUNDLE\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use BUNDLE\SiteBundle\Entity\Loguser;
use BUNDLE\SiteBundle\Entity\Page;
use BUNDLE\SiteBundle\Entity\Article;

class AdminLogUserController extends Controller
{
    public function AdminLogUserAction()
    {
  	
  	...
  	
	$em = $this->getDoctrine()->getManager();
	$logs = $em->getRepository('BUNDLESiteBundle:Loguser')->findBy(array(), array('id' => 'DESC'));
	
	$em = $this->getDoctrine()->getManager();
	$pages = $em->getRepository('BUNDLESiteBundle:Page')->findAll();
	
	$em = $this->getDoctrine()->getManager();
	$articles = $em->getRepository('BUNDLESiteBundle:Article')->findAll();
	
  	//VUE DE LA PAGE
  	return $this->render('BUNDLESiteBundle:BackOffice:AdminLogUser.html.twig', array(
  		'logs' => $logs,
		'pages' => $pages,
		'articles' => $articles,
  	));
  	
  	...
  	
    }
}
