<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-05-09
 * Time: 13:41
 */

namespace App\Http\Controllers\Customer;

use App\Models\Busi\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class MessageController extends BaseController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Message($attributes);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		return view('customer.message.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('customer.message.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$entity = Message::find($id);
		return view('customer.message.edit', ['entity' => $entity]);
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
		$searchCols = ["from_type", "to_type"];
		$with = ['from', 'to', 'content'];
		return parent::pagination($request, $searchCols, $with, function ($query) use ($request) {
			$query->where('from_id', Auth::user()->id);
		});
	}

	public function receiveMessages()
	{
		return view('customer.message.receive');

	}

	public function receivePagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
	{
		$searchCols = ["from_type", "to_type"];
		$with = ['from', 'to', 'content'];
		return parent::pagination($request, $searchCols, $with, function ($query) use ($request) {
			$query->where('to_id', Auth::user()->id);
		});
	}

	public function unreadMessagesData(){
		$user = Auth::user();

		return response()->json([
			'count' => $user->unreadMessagesCount(),
			'last_id' => !empty($user->lastUnreadMessage())?$user->lastUnreadMessage()->id:0,
			'unread_list' => $user->unreadMessages(),
		]);
	}
}