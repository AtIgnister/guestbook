<?php
namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Define which columns are searchable on the model:
     * protected array $searchable = ['name', 'description'];
     */

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (! $search || empty($this->searchable)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    }
}
