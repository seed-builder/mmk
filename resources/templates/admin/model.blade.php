<?php
if(!function_exists('dataTypeFilter')){
function dataTypeFilter($data_type){
	return $data_type == 'datetime' ? 'string' : $data_type;
}
}
?>
{!! $BEGIN_PHP !!}

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class {{$model}}
 * @package App\Models
 *
 * @author xrs
 * @SWG\Model(id="{{$model}}")
 @forelse($columns as $c)
* @SWG\Property(name="{{$c->name}}", type="<?=dataTypeFilter($c->data_type)?>", description="{{ $c->comment }}")
 @empty
 @endforelse
 */
class {{$model}} extends BaseModel
{
	//
	protected $table = '{{$table}}';
	protected $guarded = ['id'];
}
