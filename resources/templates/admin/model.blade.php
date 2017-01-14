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
* @SWG\Property(name="{{$c->name}}", type="{{$c->data_type}}", description="{{ $c->comment }}")
 @empty
 @endforelse
 */
class {{$model}} extends Model
{
	//
	protected $table = '{{$table}}';
	protected $guarded = ['id'];
}
