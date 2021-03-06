<?php

namespace Horus\BackendBundle\Email;

use Horus\BackendBundle\Configuration\Configuration;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Email Service
 */
class Emails {

    protected $container;
    protected $administrateur;
    protected $base_url;
    protected $base_img;
    protected $key;
    protected $route;
    protected $datas;
    protected $params;
    protected $configuration;

    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, Configuration $configuration) {
        $this->container = $container;
        $this->configuration = $configuration->getAllConfigure();
        $this->administrateur = $this->container->getParameter('email_administrateur');
        $this->base_url = $this->container->getParameter('url_base');
        $this->base_img = $this->base_url . '/bundles/membre/email/img/';
        $this->key = $this->container->getParameter('key_autoloading');
        $this->datas = array();
    }

    /**
     *  Send E-Mail
     * @param type $user
     * @param type $templating
     */
    public function send($user = null, $templating = null,$subject = "Bienvenue sur Horus", $to = null, $key = null, $datas = array(), $contentType = 'text/html', $base_url = 'http://www.horus-solution.com/', $sender = null,  $level = 0) {

        $this->base_url = $base_url;

        $etats = array("Bas", "Normal", "Haut", "Urgent", "Immédiat");
        // Initialisation
        if(empty($sender))
            $sender = array($this->container->getParameter('email_membre') => 'Horus');

        // Initialisation
        if(!empty($key))
        $this->key = $key;
         if(!empty($datas))
        $this->datas = $datas;

        // Sending Email
        $message = \Swift_Message::newInstance()
            ->setSubject("[".$this->configuration->getName()."] [Priorité = ".$etats[$level]."] ".$subject)
            ->setTo($to)
            ->setFrom($sender)
            ->setContentType('text/html')
            ->setBody($this->container->get('templating')->render($templating, array(
                'user' => $user,
                'datas' => $this->datas,
                'base_img' => $this->base_img,
                'base_url' => $this->base_url,
                'sujet' => $subject,
                'configuration' => $this->configuration,
            )));

        $this->container->get('mailer')->send($message);
        return true;
    }

}

?>
