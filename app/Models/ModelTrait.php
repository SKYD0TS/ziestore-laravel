<?php

namespace App\Models;

/**
 * This trait provides common functionality for handling models.
 * @param uniqueColumn array
 */
trait ModelTrait
{
    public function getRules($id = null)
    {
        if ($id !== null) {
            foreach ($this->uniqueColumn as $key => $column) {
                $this->rules[$column] .= ',' . $id;
            }
        }
        return $this->rules;
    }
}
