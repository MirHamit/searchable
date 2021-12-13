<?php
/**
 * @author Həmid Musəvi <w1w@yahoo.com>
 * 12/13/21
 */

namespace MirHamit\Searchable;

use Illuminate\Support\Facades\Schema;

trait Searchable
{
    /**
     * @param $query
     * @param $searchFields
     * @param  boolean  $filterFields
     * @return mixed
     */
    public static function scopeSearch($query, $searchFields, $filterFields = false)
    {
        !$filterFields ?? $filterFields = false;
        $searchKeywords = [];
        $tableFields = static::getSearchableFields();
        if (is_string($searchFields)) {
            $searchKeywords[] = $searchFields;
        } else {
            foreach ($searchFields as $key => $value) {
                if (in_array($key, $tableFields)) {
                    $searchKeywords[$key] = $value;
                }
            }
        }
        if (empty($searchKeywords)) {
            return $query;
        }
        return static::where(function ($query) use ($searchKeywords, $filterFields) {
            foreach ($searchKeywords as $searchKey => $searchValue) {
                self::searchForEach($query, $searchKeywords, $filterFields);
            }
        });
    }

    private static function searchForEach($query, $searchKeywords, $filter = false)
    {
        foreach ($searchKeywords as $searchKey => $searchValue) {
            if (!is_string($searchKey)) {
                foreach (self::getSearchableFields() as $searchableField) {

                    //                    $query->orWhere($searchableField, 'LIKE', "%$searchValue%");
                    $filter ? $query->where($searchableField, 'LIKE', "%$searchValue%") :
                        $query->orWhere($searchableField, 'LIKE', "%$searchValue%");
                }
            } else {
                $filter ? $query->where($searchKey, 'LIKE', "%$searchValue%") :
                    $query->orWhere($searchKey, 'LIKE', "%$searchValue%");
            }
        }
    }

    /**
     * Get all searchable fields
     *
     * @return array
     */
    public static function getSearchableFields(): array
    {
        $model = new static;

        $fields = $model->search;

        if (empty($fields)) {
            $fields = Schema::getColumnListing($model->getTable());

            $ignoredColumns = [
                $model->getKeyName(),
                //                $model->getUpdatedAtColumn(),
                //                $model->getCreatedAtColumn(),
            ];

            if (method_exists($model, 'getDeletedAtColumn')) {
                $ignoredColumns[] = $model->getDeletedAtColumn();
            }

            $fields = array_diff($fields, $model->getHidden(), $ignoredColumns);
        }

        return $fields;
    }
}
