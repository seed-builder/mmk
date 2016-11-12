<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 资源（文件,图片..）
 * @package App
 *
 * @author xrs
 * @SWG\Model(id="Resources")
 * @SWG\Property(name="id", type="integer", description="pk")
 * @SWG\Property(name="name", type="string", description="name")
 * @SWG\Property(name="email", type="string", description="email")
 * @SWG\Property(name="password", type="string", description="password")
 */
class Resources extends UuidModel
{
    //
}
