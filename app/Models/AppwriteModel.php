<?php

namespace App\Models;

use App\Services\AppwriteService;
use Appwrite\Query;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AppwriteModel implements UrlRoutable
{
    protected string $collectionName;
    protected array $attributes = [];
    public bool $exists = false;
    protected static array $resolvingAccessors = [];

    public function __construct(array $attributes = [], bool $exists = false)
    {
        $this->attributes = $attributes;
        $this->exists = $exists;
    }

    /**
     * Get the AppwriteService instance
     */
    protected static function getAppwriteService(): AppwriteService
    {
        return app(AppwriteService::class);
    }

    /**
     * Get the primary key for the model.
     */
    public function getKey()
    {
        return $this->id;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKey()
    {
        return $this->id;
    }

    /**
     * Get the route key name for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Resolve the route binding for a given value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field) {
            return static::where($field, $value)->first();
        }
        return static::find($value);
    }

    /**
     * Resolve the child route binding for a given value.
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return null;
    }

    /**
     * Dynamically get attributes or relations
     */
    public function __get($key)
    {
        if ($key === 'created_at') {
            $key = '$createdAt';
        }
        if ($key === 'updated_at') {
            $key = '$updatedAt';
        }

        if ($key === 'id') {
            return $this->attributes['$id'] ?? null;
        }

        if ($key === 'is_active') {
            return $this->attributes['is_active'] ?? true;
        }

        // Handle Laravel accessor: getXXXAttribute with recursion guard
        $accessor = 'get' . \Illuminate\Support\Str::studly($key) . 'Attribute';
        if (method_exists($this, $accessor) && !isset(self::$resolvingAccessors[static::class][$key])) {
            self::$resolvingAccessors[static::class][$key] = true;
            try {
                $value = $this->$accessor();
            } finally {
                unset(self::$resolvingAccessors[static::class][$key]);
            }
            return $value;
        }

        // Handle Laravel translatable model logic
        if (isset($this->translatable) && in_array($key, $this->translatable)) {
            return $this->getTranslation($key, app()->getLocale());
        }

        // If the key exists in attributes, return it
        if (array_key_exists($key, $this->attributes)) {
            $val = $this->attributes[$key];
            if (is_string($val) && (in_array($key, ['travel_date', 'created_at', 'updated_at', '$createdAt', '$updatedAt']) || str_ends_with($key, '_date') || str_ends_with($key, '_at'))) {
                try {
                    return \Illuminate\Support\Carbon::parse($val);
                } catch (\Exception $e) {
                    return $val;
                }
            }
            return $val;
        }

        // Check if there is a relation/method with this name
        if (method_exists($this, $key)) {
            $relation = $this->$key();
            // If it returns a query builder, evaluate it
            if ($relation instanceof AppwriteQueryBuilder) {
                $relation = $relation->get();
            }
            $this->attributes[$key] = $relation;
            return $relation;
        }

        return $this->attributes[$key] ?? null;
    }

    /**
     * Dynamically set attributes
     */
    public function __set($key, $value)
    {
        if ($key === 'created_at') {
            $key = '$createdAt';
        }
        if ($key === 'updated_at') {
            $key = '$updatedAt';
        }

        if ($key === 'id') {
            $this->attributes['$id'] = $value;
        } else {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Check if attribute is set
     */
    public function __isset($key)
    {
        if ($key === 'created_at') {
            $key = '$createdAt';
        }
        if ($key === 'updated_at') {
            $key = '$updatedAt';
        }
        return isset($this->attributes[$key]) || method_exists($this, $key);
    }

    /**
     * Get translatable fields
     */
    public function getTranslation(string $key, string $locale)
    {
        // Appwrite flat fields format: key_ar or key_en
        $flatKey = "{$key}_{$locale}";
        if (isset($this->attributes[$flatKey])) {
            return $this->attributes[$flatKey];
        }

        // Fallback to English if translation is missing
        $fallbackKey = "{$key}_en";
        return $this->attributes[$fallbackKey] ?? ($this->attributes[$key] ?? null);
    }

    /**
     * Save the document (create or update)
     */
    public function save(): bool
    {
        try {
            $service = self::getAppwriteService();
            
            // Filter out system attributes before saving
            $data = array_filter($this->attributes, function ($key) {
                return strpos($key, '$') !== 0;
            }, ARRAY_FILTER_USE_KEY);

            // Flatten translatable fields (e.g. name => ['ar' => 'X', 'en' => 'Y'] becomes name_ar => 'X', name_en => 'Y')
            if (isset($this->translatable)) {
                foreach ($this->translatable as $transKey) {
                    if (isset($data[$transKey]) && is_array($data[$transKey])) {
                        foreach ($data[$transKey] as $locale => $val) {
                            $data["{$transKey}_{$locale}"] = $val;
                            $this->attributes["{$transKey}_{$locale}"] = $val;
                        }
                        unset($data[$transKey]);
                        unset($this->attributes[$transKey]);
                    }
                }
            }

            // Normalize array attributes
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $data[$k] = array_values($v);
                }
            }

            if ($this->exists && isset($this->attributes['$id'])) {
                $response = $service->update($this->collectionName, $this->attributes['$id'], $data);
                $this->attributes = $response;
                return true;
            } else {
                $id = $this->attributes['$id'] ?? null;
                $response = $service->create($this->collectionName, $data, $id);
                $this->attributes = $response;
                $this->exists = true;
                return true;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Appwrite save error in {$this->collectionName}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the model with attributes
     */
    public function update(array $attributes = []): bool
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
        return $this->save();
    }

    /**
     * Eager load relation placeholder
     */
    public function load($relations): self
    {
        return $this;
    }

    /**
     * Increment a column's value by a given amount.
     */
    public function increment(string $column, int $amount = 1): bool
    {
        $this->$column = ($this->$column ?? 0) + $amount;
        return $this->save();
    }

    /**
     * Decrement a column's value by a given amount.
     */
    public function decrement(string $column, int $amount = 1): bool
    {
        $this->$column = ($this->$column ?? 0) - $amount;
        return $this->save();
    }

    /**
     * Delete the document
     */
    public function delete(): bool
    {
        if ($this->exists && isset($this->attributes['$id'])) {
            $service = self::getAppwriteService();
            return $service->delete($this->collectionName, $this->attributes['$id']);
        }
        return false;
    }

    /**
     * Convert model to array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Start an Appwrite Query Builder
     */
    public static function query(): AppwriteQueryBuilder
    {
        $instance = new static();
        return new AppwriteQueryBuilder($instance->collectionName, get_class($instance));
    }

    /**
     * Get all documents
     */
    public static function all(): Collection
    {
        return static::query()->get();
    }

    /**
     * Handle static calls
     */
    public static function __callStatic($method, $parameters)
    {
        return static::query()->$method(...$parameters);
    }
}

class AppwriteQueryBuilder
{
    protected string $collectionName;
    protected string $modelClass;
    protected array $queries = [];
    protected array $filterGroups = [[]]; // Array of groups, each group is an array of closures (AND conditions)
    protected array $withCountRelations = [];
    protected bool $distinct = false;
    protected array $orders = [];

    public function __construct(string $collectionName, string $modelClass)
    {
        $this->collectionName = $collectionName;
        $this->modelClass = $modelClass;
    }

    /**
     * Eager loading placeholder (ignored since relations are loaded dynamically)
     */
    public function with($relations): self
    {
        return $this;
    }

    /**
     * Set relations to count
     */
    public function withCount($relations): self
    {
        if (is_array($relations)) {
            $this->withCountRelations = array_merge($this->withCountRelations, $relations);
        } else {
            $this->withCountRelations[] = $relations;
        }
        return $this;
    }

    /**
     * Add a where condition
     */
    public function where($column, $operator = null, $value = null): self
    {
        if ($column instanceof \Closure) {
            $column($this);
            return $this;
        }

        if ($value === null && $operator !== null) {
            $value = $operator;
            $operator = '=';
        }

        // Try to add to Appwrite queries if it's a simple equality or comparison
        $appwriteOperatorMap = [
            '=' => 'equal',
            '==' => 'equal',
            '!=' => 'notEqual',
            '<>' => 'notEqual',
            '>' => 'greaterThan',
            '>=' => 'greaterThanEqual',
            '<' => 'lessThan',
            '<=' => 'lessThanEqual',
        ];

        $op = $appwriteOperatorMap[$operator] ?? null;
        if ($op) {
            $col = $column === 'id' ? '$id' : $column;
            try {
                $this->queries[] = Query::$op($col, $value);
            } catch (\Exception $e) {
                // ignore
            }
        }

        // Always add to the current AND group for in-memory filtering (fallback)
        $currentGroupIndex = count($this->filterGroups) - 1;
        $this->filterGroups[$currentGroupIndex][] = function ($model) use ($column, $operator, $value) {
            $modelVal = $model->$column;
            
            if (strtolower($operator) === 'like') {
                $pattern = str_replace('%', '', $value);
                return stripos((string)$modelVal, $pattern) !== false;
            }

            switch ($operator) {
                case '=':
                case '==': return $modelVal == $value;
                case '!=':
                case '<>': return $modelVal != $value;
                case '>':  return $modelVal > $value;
                case '>=': return $modelVal >= $value;
                case '<':  return $modelVal < $value;
                case '<=': return $modelVal <= $value;
            }
            return false;
        };

        return $this;
    }

    /**
     * Add an OR where condition
     */
    public function orWhere($column, $operator = null, $value = null): self
    {
        if ($column instanceof \Closure) {
            $this->filterGroups[] = [];
            $column($this);
            return $this;
        }

        if ($value === null && $operator !== null) {
            $value = $operator;
            $operator = '=';
        }

        // Start a new OR group
        $this->filterGroups[] = [];
        $currentGroupIndex = count($this->filterGroups) - 1;
        
        $this->filterGroups[$currentGroupIndex][] = function ($model) use ($column, $operator, $value) {
            $modelVal = $model->$column;
            
            if (strtolower($operator) === 'like') {
                $pattern = str_replace('%', '', $value);
                return stripos((string)$modelVal, $pattern) !== false;
            }

            switch ($operator) {
                case '=':
                case '==': return $modelVal == $value;
                case '!=':
                case '<>': return $modelVal != $value;
                case '>':  return $modelVal > $value;
                case '>=': return $modelVal >= $value;
                case '<':  return $modelVal < $value;
                case '<=': return $modelVal <= $value;
            }
            return false;
        };

        return $this;
    }

    /**
     * Add a raw where condition for fulltext/search
     */
    public function whereRaw(string $sql, array $bindings = []): self
    {
        $currentGroupIndex = count($this->filterGroups) - 1;
        $this->filterGroups[$currentGroupIndex][] = function ($model) use ($bindings) {
            if (empty($bindings)) return true;
            $searchTerm = trim($bindings[0], '%');
            foreach ($model->toArray() as $key => $value) {
                if (is_string($value) && stripos($value, $searchTerm) !== false) {
                    return true;
                }
            }
            return false;
        };
        return $this;
    }

    /**
     * Add an OR raw where condition
     */
    public function orWhereRaw(string $sql, array $bindings = []): self
    {
        $this->filterGroups[] = [];
        $currentGroupIndex = count($this->filterGroups) - 1;
        $this->filterGroups[$currentGroupIndex][] = function ($model) use ($bindings) {
            if (empty($bindings)) return true;
            $searchTerm = trim($bindings[0], '%');
            foreach ($model->toArray() as $key => $value) {
                if (is_string($value) && stripos($value, $searchTerm) !== false) {
                    return true;
                }
            }
            return false;
        };
        return $this;
    }

    /**
     * Add a where condition for dates
     */
    public function whereDate(string $column, $operator, $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $currentGroupIndex = count($this->filterGroups) - 1;
        $this->filterGroups[$currentGroupIndex][] = function ($model) use ($column, $operator, $value) {
            $modelVal = $model->$column;
            if (!$modelVal) return false;
            
            $modelDate = $modelVal instanceof \Carbon\Carbon ? $modelVal->format('Y-m-d') : date('Y-m-d', strtotime($modelVal));
            $targetDate = $value instanceof \Carbon\Carbon ? $value->format('Y-m-d') : date('Y-m-d', strtotime($value));

            switch ($operator) {
                case '=':
                case '==': return $modelDate == $targetDate;
                case '!=':
                case '<>': return $modelDate != $targetDate;
                case '>':  return $modelDate > $targetDate;
                case '>=': return $modelDate >= $targetDate;
                case '<':  return $modelDate < $targetDate;
                case '<=': return $modelDate <= $targetDate;
            }
            return false;
        };

        return $this;
    }

    /**
     * Order results
     */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        if ($column === 'id') {
            $column = '$id';
        }
        $this->orders[] = [
            'column' => $column,
            'direction' => strtolower($direction) === 'desc' ? 'desc' : 'asc'
        ];
        return $this;
    }

    /**
     * Order by newest
     */
    public function latest(string $column = '$createdAt'): self
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Order by oldest
     */
    public function oldest(string $column = '$createdAt'): self
    {
        return $this->orderBy($column, 'asc');
    }

    /**
     * Limit results
     */
    public function limit(int $value): self
    {
        $this->queries[] = Query::limit($value);
        return $this;
    }

    /**
     * Alias for limit
     */
    public function take(int $value): self
    {
        return $this->limit($value);
    }

    /**
     * Fetch documents and return collection
     */
    public function get(): Collection
    {
        $service = app(AppwriteService::class);
        
        // Build the queries list for Appwrite.
        // We only send queries to Appwrite if there are NO OR groups (i.e. count($filterGroups) === 1)
        // because Appwrite queries are implicitly ANDed.
        $queries = [];
        if (count($this->filterGroups) <= 1) {
            $queries = $this->queries;
        }

        $hasLimit = false;
        foreach ($queries as $q) {
            if (str_contains(json_encode($q), 'limit')) {
                $hasLimit = true;
            }
        }
        if (!$hasLimit) {
            $queries[] = Query::limit(1000);
        }

        try {
            $documents = $service->list($this->collectionName, $queries);
        } catch (\Exception $e) {
            // Fallback: fetch without filters/queries (except limit)
            \Illuminate\Support\Facades\Log::warning("Appwrite list query failed for {$this->collectionName}: " . $e->getMessage() . ". Falling back to in-memory filtering.");
            
            $fallbackQueries = [Query::limit(1000)];
            $documents = $service->list($this->collectionName, $fallbackQueries);
        }
        
        $models = [];
        foreach ($documents as $doc) {
            $model = new $this->modelClass($doc, true);
            
            // Evaluate filterGroups in memory: (Group1 ANDs) OR (Group2 ANDs) OR ...
            $match = true;
            if (count($this->filterGroups) > 1 || !empty($this->filterGroups[0])) {
                $match = false;
                foreach ($this->filterGroups as $group) {
                    $groupMatch = true;
                    foreach ($group as $closure) {
                        if (!$closure($model)) {
                            $groupMatch = false;
                            break;
                        }
                    }
                    if ($groupMatch) {
                        $match = true;
                        break;
                    }
                }
            }
            
            if ($match) {
                // Resolve withCount relations
                foreach ($this->withCountRelations as $relation) {
                    if (method_exists($model, $relation)) {
                        $related = $model->$relation();
                        if ($related instanceof AppwriteQueryBuilder) {
                            $count = $related->count();
                        } else if ($related instanceof Collection) {
                            $count = $related->count();
                        } else if (is_array($related)) {
                            $count = count($related);
                        } else {
                            $count = 0;
                        }
                        $model->{"{$relation}_count"} = $count;
                    }
                }
                
                $models[] = $model;
            }
        }

        $collection = collect($models);

        if (!empty($this->orders)) {
            $collection = $collection->sort(function ($a, $b) {
                foreach ($this->orders as $order) {
                    $col = $order['column'];
                    $desc = $order['direction'] === 'desc';
                    
                    $valA = $a->$col;
                    $valB = $b->$col;

                    if ($valA === null && $valB !== null) {
                        return $desc ? 1 : -1;
                    }
                    if ($valB === null && $valA !== null) {
                        return $desc ? -1 : 1;
                    }
                    if ($valA == $valB) {
                        continue;
                    }

                    if (is_string($valA) && is_string($valB)) {
                        $cmp = strcasecmp($valA, $valB);
                        return $desc ? -$cmp : $cmp;
                    }

                    $cmp = ($valA < $valB) ? -1 : 1;
                    return $desc ? -$cmp : $cmp;
                }
                return 0;
            })->values();
        }

        return $collection;
    }

    /**
     * Fetch first item
     */
    public function first(): ?AppwriteModel
    {
        $this->limit(1);
        return $this->get()->first();
    }

    /**
     * Fetch first or fail
     */
    public function firstOrFail(): AppwriteModel
    {
        $model = $this->first();
        if (!$model) {
            throw (new ModelNotFoundException())->setModel($this->modelClass);
        }
        return $model;
    }

    /**
     * Get document by ID
     */
    public function find(string $id): ?AppwriteModel
    {
        $service = app(AppwriteService::class);
        $doc = $service->find($this->collectionName, $id);
        if (!$doc) return null;
        return new $this->modelClass($doc, true);
    }

    /**
     * Get document by ID or fail
     */
    public function findOrFail(string $id): AppwriteModel
    {
        $model = $this->find($id);
        if (!$model) {
            throw (new ModelNotFoundException())->setModel($this->modelClass)->setIds([$id]);
        }
        return $model;
    }

    /**
     * Create a new document directly
     */
    public function create(array $attributes): AppwriteModel
    {
        $model = new $this->modelClass($attributes, false);
        $model->save();
        return $model;
    }

    /**
     * Mark the query as distinct.
     */
    public function distinct(): self
    {
        $this->distinct = true;
        return $this;
    }

    /**
     * Pluck a column's values.
     */
    public function pluck(string $column): Collection
    {
        $collection = $this->get()->pluck($column);
        if ($this->distinct) {
            $collection = $collection->unique();
        }
        return $collection;
    }

    /**
     * Chunk results of the query.
     */
    public function chunk(int $count, callable $callback): bool
    {
        $results = $this->get();
        if ($results->isEmpty()) {
            return false;
        }

        foreach ($results->chunk($count) as $chunk) {
            if ($callback($chunk) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Sum a column's values.
     */
    public function sum(string $column): float
    {
        return $this->get()->sum($column);
    }

    /**
     * Check if matches query count exists
     */
    public function exists(): bool
    {
        return $this->count() > 0;
    }

    /**
     * Count documents matching query
     */
    public function count(string $column = '*'): int
    {
        if ($this->distinct && $column !== '*') {
            return $this->pluck($column)->count();
        }

        // If there are in-memory filterGroups, we must evaluate them by fetching and counting
        if (count($this->filterGroups) > 1 || !empty($this->filterGroups[0])) {
            return $this->get()->count();
        }

        $service = app(AppwriteService::class);
        $databases = $service->databases();
        if (!$databases) {
            return 0;
        }

        try {
            $collectionId = $service->getCollectionId($this->collectionName);
            $response = $databases->listDocuments(
                $service->getDatabaseId(),
                $collectionId,
                $this->queries
            );
            return $response['total'] ?? 0;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Appwrite count error for {$this->collectionName}: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Support pagination
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        
        // If we have in-memory filterGroups or sorting, we must evaluate the whole query, and then paginate manually
        if (count($this->filterGroups) > 1 || !empty($this->filterGroups[0]) || !empty($this->orders)) {
            $allResults = $this->get();
            $total = $allResults->count();
            $slice = $allResults->slice(($page - 1) * $perPage, $perPage)->values();
            
            return new LengthAwarePaginator(
                $slice,
                $total,
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        }

        $offset = ($page - 1) * $perPage;
        
        $service = app(AppwriteService::class);
        $databases = $service->databases();
        if (!$databases) {
            return new LengthAwarePaginator(
                collect(),
                0,
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        }

        $collectionId = $service->getCollectionId($this->collectionName);
        
        try {
            // Get total count first
            $response = $databases->listDocuments(
                $service->getDatabaseId(),
                $collectionId,
                $this->queries
            );
            $total = $response['total'] ?? 0;

            // Apply offset and limit
            $this->queries[] = Query::limit($perPage);
            $this->queries[] = Query::offset($offset);

            $results = $this->get();

            return new LengthAwarePaginator(
                $results,
                $total,
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Appwrite paginate error for {$this->collectionName}: " . $e->getMessage());
            return new LengthAwarePaginator(
                collect(),
                0,
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        }
    }

    /**
     * Handle dynamic scopes or builder calls
     */
    public function __call($method, $parameters)
    {
        $scopeMethod = 'scope' . ucfirst($method);
        if (method_exists($this->modelClass, $scopeMethod)) {
            $this->modelClass::$scopeMethod($this, ...$parameters);
            return $this;
        }
        throw new \BadMethodCallException("Method {$method} does not exist on " . get_class($this));
    }
}
