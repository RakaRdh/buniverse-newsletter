<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Appwrite\Client;
use Appwrite\Services\Databases;

class Appwrite_client {
    protected $client;
    protected $databases;
    protected $databaseId;

    public function __construct()
    {
        $endpoint = $_ENV['APPWRITE_ENDPOINT'] ?? getenv('APPWRITE_ENDPOINT') ?: 'https://sgp.cloud.appwrite.io/v1';
        $projectId = $_ENV['APPWRITE_PROJECT_ID'] ?? getenv('APPWRITE_PROJECT_ID') ?: 'buniverse-newsletter';
        $apiKey = $_ENV['APPWRITE_API_KEY'] ?? getenv('APPWRITE_API_KEY') ?: '';
        $this->databaseId = $_ENV['APPWRITE_DATABASE_ID'] ?? getenv('APPWRITE_DATABASE_ID') ?: 'buniverse_newsletter';

        $this->client = new Client();
        $this->client
            ->setEndpoint($endpoint)
            ->setProject($projectId)
            ->setKey($apiKey)
            ->setSelfSigned(true); // Bypass SSL certificate issues in local development

        $this->databases = new Databases($this->client);
    }

    public function get_databases()
    {
        return $this->databases;
    }

    public function get_db_id()
    {
        return $this->databaseId;
    }
}
