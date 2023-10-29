<?php

namespace App\Repositories\Contracts;

interface PaginationInterface {
    public function items(): array;
    public function total(): int;
    public function isFirstPage(): bool;
    public function isLastPage(): bool;
    public function currentPage(): int;
    public function getNumerNextPage(): int;
    public function getNumerPreviousPage(): int;
}
