<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
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

}
