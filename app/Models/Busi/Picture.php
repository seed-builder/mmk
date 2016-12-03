<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Picture
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Picture")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="link", type="string", description="链接地址")
 * @SWG\Property(name="title", type="string", description="标题")
 * @SWG\Property(name="type", type="integer", description="类型，0-轮播图")
 * @SWG\Property(name="url", type="string", description="图片地址")
 */
class Picture extends BaseModel
{
    //
    protected $table = 'bd_pictures';

}
