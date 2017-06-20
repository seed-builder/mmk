<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Models\Busi\Department;
use App\Models\Busi\Message;
use App\Models\Busi\Resources;
use App\Models\User;
use App\Services\MessageService;
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

        return view('admin.message-content.index', compact('customers', 'admins', 'departments'));
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

        if (!empty($entity->files)) {
            $files_arr = explode(',', $entity->files);
            $files = [];
            foreach ($files_arr as $f)
                $files[] = Resources::find($f);
            $entity->files = $files;
        } else {
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

        $with = ['creator', 'modifyer'];
        return parent::pagination($request, $searchCols, $with, function ($query) {
            $query->whereIn('type',[1,2]);
        });
    }

    public function store(Request $request, $extraFields = [])
    {
        $data = $request->only(['files', 'title', 'subtitle', 'content', 'type']);

        if (!empty($data['files']))
            $data['files'] = implode(',', $data['files']);
        $data['fcreator_id'] = Auth::user()->id;
        $data['fmodify_id'] = Auth::user()->id;

        $entity = $this->newEntity($data);
        $entity->save();

        return redirect(url('admin/message-content'));

    }

    public function update(Request $request, $id, $extraFields = [])
    {
        $data = $request->only(['files', 'title', 'subtitle', 'content', 'type']);

        if (!empty($data['files']))
            $data['files'] = implode(',', $data['files']);
        $data['fmodify_id'] = Auth::user()->id;

        $entity = $this->newEntity()->newQuery()->find($id);
        $entity->fill($data);
        $entity->save();

        return redirect(url('admin/message-content'));
    }

    public function send(Request $request)
    {
        $data = $request->all();
        if ($data['scope'] == 1) {//所有人
            $users = User::all();

            $users_ids = $users->pluck('id')->toArray();
            $emp_ids = $users->where('reference_type', 'employee')->pluck('id')->toArray();

            $this->sendMessage($users_ids, $data['message_content_id']);
            $this->sendApp($users_ids, $data['message_content_id']);
        } else {
            $users = [];
            if (!empty($data['fcust_ids'])) {
                $customers = User::query()->where('reference_type', 'customer')->whereIn('reference_id', $data['fcust_ids'])->pluck('id')->toArray();
                $users = array_merge($users, $customers);
            }
            if (!empty($data['fadmin_ids'])) {
                $admins = User::query()->whereIn('id', $data['fadmin_ids'])->pluck('id')->toArray();
                $users = array_merge($users, $admins);
            }
            if (!empty($data['fdept_ids'])) {
                $departments = Department::query()->whereIn('id', $data['fdept_ids'])->get();
                foreach ($departments as $department) {
                    $emp_ids = $department->getAllEmployeeByDept()->pluck('id');
                    $employees = User::query()->where('reference_type', 'employee')->whereIn('reference_id', $emp_ids)->pluck('id')->toArray();
                    $users = array_merge($users, $employees);

                    $this->sendApp($users, $data['message_content_id']);
                }
            }
            $users = array_unique($users);

            $this->sendMessage($users, $data['message_content_id']);
        }


        return response()->json([
            'code' => 200,
            'result' => '发送成功！'
        ]);
    }

    protected function sendApp($emp_ids, $content_id)
    {
        $appSend = new MessageService();
        $appSend->sendMessage($emp_ids, $content_id);
    }

    protected function sendMessage($users, $content_id)
    {
        foreach ($users as $user) {
            $datas[] = [
                'from_id' => Auth::user()->id,
                'to_id' => $user,
                'message_content_id' => $content_id,
                'fcreate_date' => date('Y-m-d H:i:s'),
                'fmodify_date' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('bd_messages')->insert($datas);
    }


    public function info($message_id)
    {

        $message = Message::find($message_id);
        $message->read = 1;
        $message->save();

        $entity = $this->newEntity()->newQuery()->find($message->message_content_id);
        $files = [];
        if (!empty($entity->files)) {
            $files_arr = explode(',', $entity->files);
            foreach ($files_arr as $f)
                $files[] = '/admin/download-file?id=' . $f;
        }
        $entity->files = $files;

        return view('admin.message-content.info', ['entity' => $entity]);
    }
}
