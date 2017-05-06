<?php

namespace App\Models;

use App\Events\FlagChangedEvent;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

/**
 * model description
 * Class Permission
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Permission")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="description", type="string", description="")
 * @SWG\Property(name="display_name", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="name", type="string", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 */
class Permission extends EntrustPermission
{
    //
    protected $table = 'sys_permissions';
	protected $guarded = ['id'];

	public function children(){
		return $this->hasMany(Permission::class, 'pid')->orderBy('sort');
	}

	public function father(){
		return $this->belongsTo(Permission::class, 'pid');
	}

	public static function boot()
	{
		static::created(function ($entity){
			if(!empty($entity->father)){
				$entity->flag = $entity->father->flag . '-' . $entity->id;
			}else{
				$entity->flag = $entity->id;
			}
			$entity->save();
		});

		static::updating(function ($entity){
			$old = static::find($entity->id);
			if($old->pid != $entity->pid){
				$father = static::find($entity->pid);
				$entity->flag = $father->flag . '-' . $entity->id;
				event(new FlagChangedEvent($entity));
			}
		});

		static::deleted(function($entity){
			static::where('flag', 'like', $entity->flag . '%')->delete();
		});
	}

}
