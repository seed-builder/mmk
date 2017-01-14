<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class ChannelGroup
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ChannelGroup")
 * @SWG\Property(name="fcreate_date", type="datetime", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="datetime", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="分组名称")
 * @SWG\Property(name="fnumber", type="string", description="分组编码")
 * @SWG\Property(name="fparent_id", type="integer", description="分组上级")
 * @SWG\Property(name="fsort", type="integer", description="排序")
 * @SWG\Property(name="ftype", type="string", description="分组类型")
 * @SWG\Property(name="id", type="integer", description="")
  */
class ChannelGroup extends Model
{
	//
	protected $table = 'bd_channel_groups';
	protected $guarded = ['id'];
}
