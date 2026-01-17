<?php

namespace App\Contracts;

interface BaseRepositoryInterface
{
    /**
     * Get all records.
     */
    public function all();

    /**
     * Find a record by ID.
     */
    public function find(int $id);

    /**
     * Create a new record.
     */
    public function create(array $data);

    /**
     * Update an existing record.
     */
    public function update($model, array $data);

    /**
     * Delete a record.
     */
    public function delete($model): bool;
}
