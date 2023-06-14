<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
class ProductFilteringService
{
    protected array $validFilters = [
        'category',
        'name',
        'description',
        'price',
    ];

    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $filter => $value) {
            if (in_array($filter, $this->validFilters)) {
                $methodName = 'filterBy' . ucfirst($filter);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($query, $value);
                }
            }
        }

        return $query;
    }

    protected function filterByCategory(Builder $query, $value): void
    {
        $categories = is_array($value) ? $value : [$value];
        $query->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('name', $categories);
        });
    }

    protected function filterByName(Builder $query, $value): void
    {
        $query->where('name', 'LIKE', "%$value%");
    }

    protected function filterByDescription(Builder $query, $value): void
    {
        $query->where('description', 'LIKE', "%$value%");
    }

    protected function filterByPrice(Builder $query, $value): void
    {
        if ($value === 'under100') {
            $query->where('price', '<', 100);
        } elseif ($value === 'under500') {
            $query->whereBetween('price', [100, 500]);
        } elseif ($value === 'more500') {
            $query->where('price', '>', 500);
        }
    }
}
