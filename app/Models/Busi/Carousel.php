<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Carousel
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Carousel")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="fname", type="string", description="图片名称")
 * @SWG\Property(name="fpicture_id", type="integer", description="图片id")
 * @SWG\Property(name="fseq", type="integer", description="排序")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
  */
class Carousel extends BaseModel
{
	//
	protected $table = 'bd_carousels';
	protected $guarded = ['id'];
}
