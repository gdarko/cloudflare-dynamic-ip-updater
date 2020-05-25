<?php

namespace gdarko\CDU;

use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Endpoints\DNS;
use Cloudflare\API\Endpoints\User;
use Cloudflare\API\Endpoints\Zones;

/**
 * Class App
 *
 * @package gdarko\CDU
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class App
{

    /**
     * The config variable
     * @var Config
     */
    private $config;

    /**
     * The logger
     * @var Logger
     */
    private $logger;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->logger = new Logger();
    }


    /**
     * Login to cloudflare
     *
     * @param $email
     * @param $apikey
     *
     * @return string
     */
    public function login($email, $apikey)
    {
        $key     = new APIKey($email, $apikey);
        $adapter = new Guzzle($key);
        try {
            $user = new User($adapter);

            return $user->getUserID();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public function checkLogin()
    {
        $creds = $this->getCredentials();
        if ( ! isset($creds['apikey']) || ! isset($creds['email'])) {
            return false;
        }

        return false !== $this->login($creds['email'], $creds['apikey']);
    }

    /**
     * Return adapter
     * @return Guzzle
     */
    private function getAdapter()
    {
        $creds = $this->getCredentials();
        if ( ! isset($creds['email']) || ! isset($creds['apikey'])) {
            return null;
        }
        if ( ! $this->checkLogin()) {
            return null;
        }
        $key = new APIKey($creds['email'], $creds['apikey']);

        return new Guzzle($key);
    }

    /**
     * Save credentials
     *
     * @param $email
     * @param $apiKey
     */
    public function storeCredentials($email, $apiKey)
    {
        $this->config->set('creds', ['email' => $email, 'apikey' => $apiKey]);
        $this->config->save();
    }

    /**
     * Return credentials
     * @return array
     */
    public function getCredentials()
    {
        return $this->config->get('creds', array());
    }


    /**
     * Add record
     *
     * @param $name
     * @param $domain
     *
     * @param  string  $type
     *
     * @return bool
     * @throws \Cloudflare\API\Endpoints\EndpointException
     */
    public function addRecord($name, $domain, $type = 'A')
    {

        $adapter = $this->getAdapter();

        if (is_null($adapter)) {
            $this->logger->write('Add Record -> Unable to login, invalid credentials.');

            return false;
        }

        $zones  = new Zones($adapter);
        $zoneID = $zones->getZoneID($domain);

        if (is_null($zoneID)) {
            $this->logger->write('Add Record -> Invalid zone.');

            return false;
        }

        $records       = $this->config->get('records', array());
        $key           = sha1($name.$domain.$type);
        $records[$key] = array(
            'name'   => $name,
            'domain' => $domain,
            'type'   => 'A',
            'zoneID' => $zoneID,
        );
        $this->config->set('records', $records);
        $this->config->save();

        return true;
    }

    /**
     * Remove record
     *
     * @param $name
     * @param $domain
     * @param  string  $type
     */
    public function removeRecord($name, $domain, $type = 'A')
    {
        $key     = sha1($name.$domain.$type);
        $records = $this->config->get('records', array());
        if (isset($records[$key])) {
            unset($records[$key]);
            $this->config->set('records', $records);
            $this->config->save();
        }

        return true;
    }


    /**
     * Sync records with cloudflare
     *
     * @return bool
     */
    public function sync()
    {

        $totalSynced = 0;

        $publicIp = $this->getPublicIp();
        if ( ! $publicIp) {
            $this->logger->write('Sync -> Invalid ip address');

            return false;
        }

        $adapter = $this->getAdapter();
        if (is_null($adapter)) {
            $this->logger->write('Sync -> Unable to login, invalid credentials.');


            return false;
        }

        $records = $this->config->get('records', array());
        if (empty($records)) {
            $this->logger->write('Sync -> Nothing to sync.');

            return false;
        }

        $dns = new DNS($adapter);

        foreach ($records as $record) {

            $name   = isset($record['name']) ? $record['name'] : '';
            $zoneID = isset($record['zoneID']) ? $record['zoneID'] : '';
            $type   = isset($record['type']) ? $record['type'] : '';
            $domain = isset($record['domain']) ? $record['domain'] : '';

            if (empty($name) || empty($zoneID) || empty($type)) {
                continue;
            }

            $fullname = $name.'.'.$domain;

            $recordID = $dns->getRecordID($zoneID, $type, $fullname);

            try {
                if ( ! empty($recordID)) {
                    $dns->deleteRecord($zoneID, $recordID);
                }

                $result = $dns->addRecord($zoneID, $type, $fullname, $publicIp, 0, 0);
                if ($result) {
                    $totalSynced++;
                }
            } catch (\Exception $e) {
                $this->logger->write('Sync -> Error: '.$e->getMessage());
            }

            sleep(1);
        }

        return $totalSynced;
    }


    /**
     * Return the public ip (ipv4) address
     * @return bool
     */
    private function getPublicIp()
    {
        $ip = file_get_contents('https://api.ipify.org/');
        if ( ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        return $ip;
    }
}