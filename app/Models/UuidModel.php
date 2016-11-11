<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Uuid;

class UuidModel extends Model
{
    //
    /**
     * Insert the given attributes and set the ID on the model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $attributes
     * @return void
     */
    protected function insertAndSetId(Builder $query, $attributes)
    {
        $keyName = $this->getKeyName();
        $id = $attributes[$keyName] = Uuid::generate(); //$query->insertGetId($attributes, $keyName = $this->getKeyName());
        $query->insert($attributes);
        $this->setAttribute($keyName, $id);
    }
}
