<?php

namespace App\MLS;

use Illuminate\Support\Facades\Log;


abstract class Connector
{
    protected $config;
    protected $session;
    protected $connection;

    /**
     * Constructor for MLS Connector
     *
     * @param $config
     * @throws \Exception
     */
    public function __construct($config) {
        $this->config = (new \PHRETS\Configuration)
            ->setLoginUrl($config['loginUrl'])
            ->setUsername($config['username'])
            ->setPassword($config['password'])
            ->setRetsVersion(array_key_exists('version', $config) ? $config['version'] : '1.7.2');

        $this->session = new \PHRETS\Session($this->config);
        $this->connection = $this->session->Login();
    }

    /**
     * Get properties
     *
     * @param $type
     * @param $dmlQuery
     * @return mixed
     */
    public abstract function getProperties();
}