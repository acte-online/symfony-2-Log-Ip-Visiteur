#symfony-2-Log-Ip-Visiteur
Enregistrement dans DB des infos visiteurs

<br />

<b>LogUser.php</b>
```php
<?php
// src/BUNDLE/SiteBundle/Entity/Loguser.php
namespace BUNDLE\SiteBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Table(name="loguser")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Loguser
{
	/**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="ip",type="string", length=255)
     * @Assert\NotBlank
     */
    private $ip;
    
    /**
     * @ORM\Column(name="dateinsert", type="datetime")
     * @Assert\NotBlank
     */
    private $dateinsert;
    
    /**
     * @ORM\Column(name="page",type="string", length=255, nullable=true)
     */
    private $page;
    
    /**
     * @ORM\Column(name="article",type="string", length=255, nullable=true)
     */
    private $article;
    
    /**
     * @ORM\Column(name="useragent",type="string", length=255, nullable=true)
     */
    private $useragent;
    
    /**
     * @ORM\Column(name="querystring",type="string", length=255, nullable=true)
     */
    private $querystring;
    
    /**
     * @ORM\Column(name="referer",type="string", length=255, nullable=true)
     */
    private $referer;
    
    /**
     * @ORM\Column(name="uri",type="string", length=255, nullable=true)
     */
    private $uri;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set ip
     *
     * @param string $ip
     * @return Loguser
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }
    /**
     * Set dateinsert
     *
     * @param \DateTime $dateinsert
     * @return Loguser
     */
    public function setDateinsert($dateinsert)
    {
        $this->dateinsert = $dateinsert;
        return $this;
    }
    /**
     * Get dateinsert
     *
     * @return \DateTime 
     */
    public function getDateinsert()
    {
        return $this->dateinsert;
    }
    /**
     * Set page
     *
     * @param string $page
     * @return Loguser
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }
    /**
     * Get page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }
    /**
     * Set article
     *
     * @param string $article
     * @return Loguser
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }
    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * Set useragent
     *
     * @param string $useragent
     * @return Loguser
     */
    public function setUseragent($useragent)
    {
        $this->useragent = $useragent;
        return $this;
    }
    /**
     * Get useragent
     *
     * @return string 
     */
    public function getUseragent()
    {
        return $this->useragent;
    }
    /**
     * Set querystring
     *
     * @param string $querystring
     * @return Loguser
     */
    public function setQuerystring($querystring)
    {
        $this->querystring = $querystring;
        return $this;
    }
    /**
     * Get querystring
     *
     * @return string 
     */
    public function getQuerystring()
    {
        return $this->querystring;
    }
    /**
     * Set referer
     *
     * @param string $referer
     * @return Loguser
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
        return $this;
    }
    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }
    /**
     * Set uri
     *
     * @param string $uri
     * @return Loguser
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }
}
```

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
  	return $this->render('BUNDLESiteBundle:BackOffice:AdminLogUser.html.twig', array(
  		'logs' => $logs,
		'pages' => $pages,
		'articles' => $articles,
  	));
  	
  	...
  	
    }
}
```

<br />

<b>AdminLogUser.html.twig</b>

![image](http://acte-online.com/images/AdminLogUser.html.twig.png)

```php
...

{% block body %}
	<div style="padding:0 0 30px 0;">
		<h3>Administration Log</h3>
	</div>
	{% for log in logs %}
		<div class="container-fluid">
			<div class="col-md-12" style="border-bottom:1px dotted #BABABA;padding:5px 0 10px 0;margin-bottom:10px;">
				<div style="float:right;">
					<a href="" style="color:#FF0000;"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a>
				</div>
				<div>
					<b>{{ log.id }}</b> - <b>{{ log.dateinsert|date("Y M d") }}</b> <small>à {{ log.dateinsert|date("H:m:s") }}</small> - <b>{{ log.ip }}</b> -> <small><a href="http://www.ip-tracker.org/locator/ip-lookup.php?ip={{ log.ip }}" target="_blank">Whois {{ log.ip }}</a></small>
				</div>
				<div style="padding:10px 0 10px 0;">
					{% for page in pages %}
						{% if log.page==page.id %}
						<div style="color:#58FA58"><b>Page :</b> {{ page.pagetitle }}</div>
						{% endif %}
					{% endfor %}
						{% if log.page=='0' %}
							<div style="color:#58FA58"><b>Page :</b> Accueil</div>
						{% endif %}
						{% if log.page=='error - 404' %}
							<div style="color:#FF0000"><b>Page :</b> Error 404</div>
						{% endif %}
						{% if log.page=='login' %}
							<div style="color:#FF8000"><b>Page :</b> Login</div>
						{% endif %}
					{% for article in articles %}
						{% if log.article==article.id %}
						<div style="color:#58ACFA"><b>Article :</b> {{ article.articletitle }}</div>
						{% endif %}
					{% endfor %}
				</div>
				<div style="padding:5px 0 10px 0;"><b>URL :</b> <small>{{ log.uri }}</small></div>
				<div style="padding:5px 0 10px 0;"><b>USER Agent :</b> <small>{{ log.useragent }}</small></div>
			</div>
		</div>
	{% endfor %}
{% endblock %}
```

<br />

<b>page.html.twig</b>

```php
...

{% block body %}

...

{% endblock %}
```

