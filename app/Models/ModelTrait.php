<?php

namespace App\Models;

/**
 * This trait provides common functionality for handling models.
 * @param uniqueColumn array
 */
trait ModelTrait
{
    public function getSelectOptions()
    {
        return $this->all()->pluck('name', 'id');
    }

    public function getRules($id = null)
    {
        $columns = $this->columns;

        if ($id !== null) {
            foreach ($columns as $key => $column) {
                if (!null == strpos($column['rule'], 'unique:')) {
                    $columns['rule'][$column] .= ',' . $id;
                }
            }
        }

        $columnsRule = array_map(function ($column) {
            return $column['rule'];
        }, $columns);

        return $columnsRule;
    }

    public function getColumnsInputAttribute()
    {
        $columns = $this->columns;

        $columnsAttribute = array_map(function ($column) {
            return $column['inputAttributes'];
        }, $columns);

        return $columnsAttribute;
    }
}
