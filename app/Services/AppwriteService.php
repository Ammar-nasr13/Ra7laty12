<?php

namespace App\Services;

use Appwrite\Client;
use Appwrite\Services\Databases;
use Appwrite\Query;
use Illuminate\Support\Facades\Log;

class AppwriteService
{
    protected Client $client;
    protected ?Databases $databases = null;
    protected string $databaseId = '';

    public function __construct()
    {
        try {
            $endpoint = config('services.appwrite.endpoint') ?: 'https://cloud.appwrite.io/v1';
            $projectId = config('services.appwrite.project_id') ?: '';
            $apiKey = config('services.appwrite.api_key') ?: '';
            $this->databaseId = config('services.appwrite.database_id') ?: '';

            $this->client = new Client();
            $this->client->setEndpoint($endpoint);

            if (!empty($projectId) && $projectId !== 'your_appwrite_project_id_here') {
                $this->client->setProject($projectId);
            }

            if (!empty($apiKey) && $apiKey !== 'your_appwrite_api_key_here') {
                $this->client->setKey($apiKey);
            }

            $this->databases = new Databases($this->client);
        } catch (\Exception $e) {
            Log::error("Appwrite Client Initialization failed: " . $e->getMessage());
        }
    }

    /**
     * Resolve the Collection ID by short-name (e.g. 'trips')
     */
    public function getCollectionId(string $name): string
    {
        return config("services.appwrite.collections.{$name}", $name);
    }

    /**
     * Get Database ID
     */
    public function getDatabaseId(): string
    {
        return $this->databaseId;
    }

    /**
     * Fetch all documents from a collection
     */
    public function list(string $collectionName, array $queries = []): array
    {
        if (!$this->databases) {
            return [];
        }

        try {
            $collectionId = $this->getCollectionId($collectionName);
            $response = $this->databases->listDocuments($this->databaseId, $collectionId, $queries);
            return $response['documents'] ?? [];
        } catch (\Exception $e) {
            Log::error("Appwrite list error for {$collectionName}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Find a single document by ID
     */
    public function find(string $collectionName, string $documentId): ?array
    {
        if (!$this->databases) {
            return null;
        }

        try {
            $collectionId = $this->getCollectionId($collectionName);
            return $this->databases->getDocument($this->databaseId, $collectionId, $documentId);
        } catch (\Exception $e) {
            Log::error("Appwrite find error for {$collectionName} ({$documentId}): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new document
     */
    public function create(string $collectionName, array $data, ?string $documentId = null): array
    {
        if (!$this->databases) {
            throw new \Exception("Appwrite service is not initialized.");
        }

        try {
            $collectionId = $this->getCollectionId($collectionName);
            $id = $documentId ?: 'unique()';
            return $this->databases->createDocument($this->databaseId, $collectionId, $id, $data);
        } catch (\Exception $e) {
            Log::error("Appwrite create error in {$collectionName}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update an existing document
     */
    public function update(string $collectionName, string $documentId, array $data): array
    {
        if (!$this->databases) {
            throw new \Exception("Appwrite service is not initialized.");
        }

        try {
            $collectionId = $this->getCollectionId($collectionName);
            return $this->databases->updateDocument($this->databaseId, $collectionId, $documentId, $data);
        } catch (\Exception $e) {
            Log::error("Appwrite update error in {$collectionName} ({$documentId}): " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a document
     */
    public function delete(string $collectionName, string $documentId): bool
    {
        if (!$this->databases) {
            return false;
        }

        try {
            $collectionId = $this->getCollectionId($collectionName);
            $this->databases->deleteDocument($this->databaseId, $collectionId, $documentId);
            return true;
        } catch (\Exception $e) {
            Log::error("Appwrite delete error for {$collectionName} ({$documentId}): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Expose raw Databases service for complex queries
     */
    public function databases(): ?Databases
    {
        return $this->databases;
    }
}
