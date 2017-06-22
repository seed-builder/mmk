<?php

namespace App\Models;

use App\Models\Busi\Message;
use App\Models\Busi\Position;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Class User
 * @package App
 *
 * @author xrs
 * @SWG\Model(id="User")
 * @SWG\Property(name="id", type="integer", description="pk")
 * @SWG\Property(name="name", type="string", description="name")
 * @SWG\Property(name="nick_name", type="string", description="name")
 * @SWG\Property(name="logo", type="string", description="logo")
 * @SWG\Property(name="email", type="string", description="email")
 * @SWG\Property(name="password", type="string", description="password")
 * @SWG\Property(name="reference_id", type="integer", description="reference_id")
 * @SWG\Property(name="reference_type", type="string", description="reference_type")
 * @SWG\Property(name="login_time", type="integer", description="登陆次数")
 */
class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $table = 'sys_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status','login_time','nick_name','logo'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guarded = ['id'];

    protected static function boot()
    {
	    parent::boot(); // TODO: Change the autogenerated stub
//	    static::creating(function ($user){
//	    	$user->password = bcrypt($user->password);
//	    });
        static::updated(function ($model){
            if ($model->reference_type=='customer'){
                $customer = $model->reference;
                $customer->ftel = $model->name;
                $customer->save();
            }
        });
    }

    public function hasPosition($positionId){
    	if($this->positions){
    		foreach ($this->positions as $position){
    			if($position->id == $positionId)
    				return true;
		    }
	    }
    	return false;
    }

	/**
	 * 职位
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
    public function positions(){
    	return $this->belongsToMany(Position::class, 'sys_user_position', 'user_id', 'position_id');
    }

	/**
	 * 是否管理员
	 * 不受数据隔离限制
	 * @return bool
	 */
    public function isAdmin(){
    	return $this->hasRole('admin');
    }

	/**
	 * 是否经理
	 * 不受数据隔离限制
	 * @return bool
	 */
	public function isManager(){
		return $this->hasRole('manager');
	}

	/**
	 * 实体（多态关联-Employee,Customer）
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
    public function reference(){
    	return $this->morphTo();
    }

	/**
	 * 获取上级
	 */
	public function getSeniors(){
		if($this->reference_type == 'employee'){
			$seniors = $this->reference->getAllSeniors();
			$users = $seniors->map(function ($senior){
				return $senior->user;
			});
			return $users;
		}
		return [];
	}

    public function sendMessages(){
        return $this->hasMany(Message::class,'from_id','id');
    }

    public function receiveMessages(){
        return $this->hasMany(Message::class,'to_id','id');
    }


    public function unreadMessages($limit=5){
        return $this->receiveMessages()->where('read',0)->orderBy('fcreate_date','desc')->limit($limit)->get();
    }

    public function unreadMessagesCount(){
        return $this->receiveMessages()->where('read',0)->count();
    }

    public function lastUnreadMessage(){
        return $this->receiveMessages()->where('read',0)->orderBy('fcreate_date','desc')->first();
    }
}
