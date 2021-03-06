<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use TheMarketingLab\Hg\ConfigurationInterface;
use TheMarketingLab\Hg\Views\View;
use TheMarketingLab\Hg\Views\ViewClient;

class UserPlugin
{

    private $client;
    private $dbh;
    private $session_id;
    private $user;

    public function __construct(ConfigurationInterface $config, $dbh)
    {
        $this->client = new ViewClient($config);
        $this->dbh = $dbh;
    }

    public function loadUser($id_guest, $id_customer)
    {
        $this->user = new User($this->getDBH(), $id_guest, $id_customer);
        $view = $this->getUser()->getView();
        // Mock View Atm
        if ($view === null) {
            $this->getUser()->isNewSession(true);
            $view = $this->getUser()->setView(new View('default'));
        }
        $view = $this->getClient()->update($view);
        $this->getUser()->setView($view);
        return $this->getUser();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getDBH()
    {
        return $this->dbh;
    }
}
