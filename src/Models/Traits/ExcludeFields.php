<?php

namespace Deflopian\EducationTests\Models\Traits;

trait ExcludeFields
{
    public function scopeExclude($query, $value = [])
    {
        $fields = \Schema::getColumnListing($this->table);
        return $query->select(array_diff($fields, (array)$value));
    }
}
