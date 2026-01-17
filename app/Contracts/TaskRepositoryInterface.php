<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
}
