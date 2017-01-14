{!! $BEGIN_PHP !!}

namespace App\Http\Controllers\Admin;

use App\Models\{{$model}};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SysTableController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('{{snake_case($model,'-')}}.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
		return view('{{snake_case($model,'-')}}.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
		$data = $request->all();
		unset($data['_token']);
		$entity = {{$model}}::create($data);
		$this->flash_success('store success!');
		return redirect(route('{{snake_case($model,'-')}}.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
		$entity = {{$model}}::find($id);
		return view('{{snake_case($model,'-')}}.edit', ['entity' => $entity]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
		$entity = {{$model}}::find($id);
		$data = $request->all();
		unset($data['_token']);
		$entity->fill($data);
		$re = $entity->save();
		$this->flash_success('update success!');
		return redirect(route('{{snake_case($model,'-')}}.index'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
		$entity = {{$model}}::find($id);
		$re = $entity->delete();
		$this->flash_success('destroy success!');
		return redirect(route('{{snake_case($model,'-')}}.index'));

	}


	public function pagination(Request $request){
		//$data = $request->all();
		$start =  $request->input('start', 0);
		$length = $request->input('length', 10);
		$columns = $request->input('columns',[]);
		$order = $request->input('order', []);
		$search = $request->input('search', []);
		$draw = $request->input('draw', 0);

		$queryBuilder = {{$model}}::query();
		$fields = [];
		$conditions = [];
		foreach ($columns as $column){
			$fields[] = $column['data'];
			if(!empty($column['search']['value'])){
				$conditions[$column['data']] = $column['search']['value'];
			}
		}
		$total = $queryBuilder->count();

		foreach ($conditions as $col => $val) {
			$queryBuilder->where($col, $val);
		}
		foreach ($order as $o){
			$index = $o['column'];
			$dir = $o['dir'];
			$queryBuilder->orderBy($columns[$index]['data'], $dir);
		}
		$entities = $queryBuilder->select($fields)->skip($start)->take($length)->get();
		$result = [
			'draw' => $draw,
			'recordsTotal' => $total,
			'recordsFiltered' => $total,
			'data' => $entities
		];
		return response()->json($result);
	}

}
