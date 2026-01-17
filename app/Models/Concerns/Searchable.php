<?php
namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Str;

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

        return $query->where(function (Builder $q) use ($search) {
            foreach ($this->searchable as $column) {
                // Relation search: user.username
                if (Str::contains($column, '.')) {
                    [$relation, $field] = explode('.', $column, 2);

                    $q->orWhereHas($relation, function (Builder $relQuery) use ($field, $search) {
                        $relQuery->where($field, 'like', "%{$search}%");
                    });
                } else {
                    // Direct column
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            }
        });
    }
}
