<?php

namespace App\Services;

use Appwrite\Client;
use Appwrite\Services\Databases;
use Appwrite\Query;

class AppwriteService
{
    protected Client $client;
    protected Databases $databases;
    protected string $databaseId;

    public function __construct()
    {
        $endpoint = config('services.appwrite.endpoint');
        $projectId = config('services.appwrite.project_id');
        $apiKey = config('services.appwrite.api_key');
        $this->databaseId = config('services.appwrite.database_id') ?? '';

        $this->client = new Client();
        $this->client
            ->setEndpoint($endpoint)
            ->setProject($projectId);

        if (!empty($apiKey)) {
            $this->client->setKey($apiKey);
        }

        $this->databases = new Databases($this->client);
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
        $collectionId = $this->getCollectionId($collectionName);
        $response = $this->databases->listDocuments($this->databaseId, $collectionId, $queries);
        return $response['documents'] ?? [];
    }

    /**
     * Find a single document by ID
     */
    public function find(string $collectionName, string $documentId): ?array
    {
        try {
            $collectionId = $this->getCollectionId($collectionName);
            return $this->databases->getDocument($this->databaseId, $collectionId, $documentId);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Create a new document
     */
    public function create(string $collectionName, array $data, ?string $documentId = null): array
    {
        $collectionId = $this->getCollectionId($collectionName);
        $id = $documentId ?: 'unique()';
        return $this->databases->createDocument($this->databaseId, $collectionId, $id, $data);
    }

    /**
     * Update an existing document
     */
    public function update(string $collectionName, string $documentId, array $data): array
    {
        $collectionId = $this->getCollectionId($collectionName);
        return $this->databases->updateDocument($this->databaseId, $collectionId, $documentId, $data);
    }

    /**
     * Delete a document
     */
    public function delete(string $collectionName, string $documentId): bool
    {
        try {
            $collectionId = $this->getCollectionId($collectionName);
            $this->databases->deleteDocument($this->databaseId, $collectionId, $documentId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Expose raw Databases service for complex queries
     */
    public function databases(): Databases
    {
        return $this->databases;
    }
}
