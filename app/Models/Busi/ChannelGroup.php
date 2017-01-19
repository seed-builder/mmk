<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;
use App\Models\Busi\Channel;

/**
 * model description
 * Class ChannelGroup
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ChannelGroup")
 * @SWG\Property(name="fname", type="string", description="分组名称")
 * @SWG\Property(name="fnumber", type="string", description="分组编码")
 * @SWG\Property(name="fparent_id", type="integer", description="分组上级")
 * @SWG\Property(name="fsort", type="integer", description="排序")
 * @SWG\Property(name="ftype", type="string", description="分组类型")
 * @SWG\Property(name="children_count", type="integer", description="子分组数量")
 * @SWG\Property(name="channel_count", type="integer", description="渠道数量")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
  */
class ChannelGroup extends BaseModel
{
	//
	protected $table = 'bd_channel_groups';
	protected $guarded = ['id'];
	protected $casts = [
		'children_count' => 'integer',
		'channel_count' => 'integer',
	];
	protected $visible = ['id', 'fnumber', 'fname', 'fparent_id', 'fsort', 'children_count', 'channel_count'];
	protected $appends = ['children_count', 'channel_count'];
	

	public function getChildrenCountAttribute(){
		$c = static::where('fparent_id', $this->id)->count();
		return $c;
	}

	public function getChannelCountAttribute(){
		$c = Channel::where('fgroup_id', $this->id)->count();
		return $c;
	}
	
	public function childrenGroup(){
		return ChannelGroup::query()->where('fparent_id',$this->id)->get();
	}
	
	public function parentGroup(){
// 		return ChannelGroup::query()->where('id',$this->fparent_id)->first();
// 		return $this->hasOne(self::class, 'id', 'fparent_id');
	}
	
}
