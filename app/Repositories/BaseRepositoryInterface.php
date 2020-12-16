<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function all() : array;

    public function find(string $id) : ?array;

    public function store(array $data) : ?array;

    public function update(string $id, array $data) : ?array;
    
    public function delete(string $id) : bool;
}