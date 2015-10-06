#symfony-2-Log-Ip-Visiteur
Enregistrement dans DB des infos visiteurs

<br />

<b>PageController.php</b>
```php
<?php
namespace BUNDLE\SiteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BUNDLE\SiteBundle\Entity\Loguser;
use BUNDLE\SiteBundle\Entity\Page;
use BUNDLE\SiteBundle\Entity\Article;
class PageController extends Controller
{
  public function pageAction($id, Request $request)
  {
    	...
    	
    	// Liste des pages
	$em = $this->getDoctrine()->getManager();
	$pages = $em->getRepository('BUNDLESiteBundle:Page')->findAll();
  
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else {
		$ip=$_SERVER['REMOTE_ADDR'];
	}		
	// La chaîne qui décrit le client HTML utilisé pour voir la page courante. 
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	
	// La chaîne de requête, si elle existe, qui est utilisée pour accéder à la page.
	$querystring=$_SERVER['QUERY_STRING'];
	
	// L'adresse de la page (si elle existe) qui a conduit le client à la page courante.
	$uri=$_SERVER['REQUEST_URI'];
	
	// if pour ne pas enregistrer les du réseau local..
	if ($ip!='192.168.1.254'){
		//INSERTION DE L'IP DANS DB MYSQL
		$loguser = new Loguser();
	    $loguser->setIp($ip);
	    $loguser->setDateinsert(new \DateTime("now"));
	    $loguser->setPage($uri);
	    $loguser->setUseragent($useragent);
	    $loguser->setQuerystring($querystring);
	    $loguser->setUri($uri);
	
	    $em = $this->getDoctrine()->getManager();
	
	    $em->persist($loguser);
	    $em->flush();
	}
	
	return $this->render('BUNDLESiteBundle:Page:page.html.twig', array(
		'pages' => pages,
		'id' => $id,
		'ip' => $ip,
		'useragent' => $useragent,
		'querystring' => $querystring,
	));
  
    	...
    	
  }
}
```

<br />

<b>AdminLogUserController.php</b>

```php
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
  	return $this->render('BUNDLESiteBundle:AdministrationPage:Log/loguser.html.twig', array(
  		'logs' => $logs,
		'pages' => $pages,
		'articles' => $articles,
  	));
  	
  	...
  	
    }
}
```

