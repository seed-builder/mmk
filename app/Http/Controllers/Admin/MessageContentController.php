<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Models\Busi\Department;
use App\Models\Busi\Message;
use App\Models\Busi\Resources;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\MessageContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageContentController extends AdminController
{
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new MessageContent($attributes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        $admins = User::query()->whereNull('reference_id')->get();
        $topDepts = Department::where('fpardept_id', 0)->get();
        $departments = [];
        foreach ($topDepts as $dept) {
            $this->toSelectOption($dept, ['label' => 'fname', 'value' => 'id'], $departments);
        }

        return view('admin.message-content.index',compact('customers','admins','departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.message-content.create');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = MessageContent::find($id);

        if (!empty($entity->files)){
            $files_arr = explode(',',$entity->files);
            $files = [];
            foreach ($files_arr as $f)
                $files[] = Resources::find($f);
            $entity->files = $files;
        }else{
            $entity->files = [];
        }

//        dd($entity);
        return view('admin.message-content.edit', ['entity' => $entity]);
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param  Request $request
     * @param  array $searchCols
     * @param  array $with
     * @param  null $conditionCall
     * @param  bool $all_columns
     * @return  \Illuminate\Http\JsonResponse
     */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ["content", "fdocument_status", "files", "title"];

        $with = ['creator','modifyer'];
        return parent::pagination($request, $searchCols, $with);
    }

    public function store(Request $request, $extraFields = [])
    {
        $data = $request->only(['files','title','content']);

        if (!empty($data['files']))
            $data['files'] = implode(',',$data['files']);
        $data['fcreator_id'] = Auth::user()->id;
        $data['fmodify_id'] = Auth::user()->id;

        $entity = $this->newEntity($data);
        $entity->save();

        return redirect(url('admin/message-content'));

    }

    public function update(Request $request, $id, $extraFields = [])
    {
        $data = $request->only(['files','title','content']);

        if (!empty($data['files']))
            $data['files'] = implode(',',$data['files']);
        $data['fmodify_id'] = Auth::user()->id;

        $entity = $this->newEntity()->newQuery()->find($id);
        $entity->fill($data);
        $entity->save();

        return redirect(url('admin/message-content'));
    }

    public function send(Request $request){
        $data = $request->all();
        if ($data['scope']==1){//所有人
            $users = User::all();
            $this->sendMessage($users,$data['message_content_id']);
        }else{
            $users = collect();
            if (!empty($data['fcust_ids'])){
                $customers = User::query()->where('reference_type','customer')->whereIn('reference_id',$data['fcust_ids'])->get();
                $users = $users->merge($customers);
            }
            if (!empty($data['fadmin_ids'])){
                $admins = User::query()->whereIn('id',$data['fadmin_ids'])->get();
                $users = $users->merge($admins);
            }
            if (!empty($data['fdept_ids'])){
                $departments = Department::query()->whereIn('id',$data['fdept_ids'])->get();
                foreach ($departments as $department){
                    $emp_ids = $department->getAllEmployeeByDept()->pluck('id');
                    $employees = User::query()->where('reference_type','employee')->whereIn('reference_id',$emp_ids)->get();
                    $users = $users->merge($employees);
                }
            }

            $this->sendMessage($users,$data['message_content_id']);
        }


        return response()->json([
            'code' => 200,
            'result' => '发送成功！'
        ]);
    }

    protected function sendMessage($users,$content_id){
        foreach ($users as $user){
            $datas[] =[
                'from_id' => Auth::user()->id,
                'from_type' => 'App\Models\User',
                'to_id' => $user->id,
                'to_type' => 'App\Models\User',
                'message_content_id' => $content_id,
                'fcreate_date' => date('Y-m-d H:i:s'),
                'fmodify_date' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('bd_messages')->insert($datas);
    }


}
