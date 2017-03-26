<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = ['id'];

    public $filter = true;

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


	/**
	 *
	 */
	protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::created(function ($model){
            event(new \App\Events\ModelCreatedEvent($model));
        });
        static::deleted(function ($model){
            event(new \App\Events\ModelDeletedEvent($model));
        });
        static::updated(function ($model){
            event(new \App\Events\ModelUpdatedEvent($model));
        });
    }


    public function adminFilter($queryBuilder,$request){
	    $data = $request->all();
        if (!empty($data['filter'])){

            foreach ($data['filter'] as $f){
                $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
            }
        }
	    return $queryBuilder;
    }

    public function adminFilterQuery($queryBuilder,$data){
        if (!empty($data['value'])){
            $operator = !empty($data['operator'])?$data['operator']:'=';

            if ($operator=='like')
                $queryBuilder->where($data['name'],$operator,'%'.$data['value'].'%');
            else
                $queryBuilder->where($data['name'],$operator,$data['value']);
        }

        return $queryBuilder;
    }
}
