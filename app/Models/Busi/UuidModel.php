<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;
use Uuid;

class UuidModel extends Model
{
    public $incrementing = false;
    public $timestamps = true;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'fcreate_date';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'fmodify_date';

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
