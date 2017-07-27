<?php
Route::get('visit-todo-group/pagination', ['uses' => 'VisitTodoGroupController@pagination']);
Route::get('visit-todo-group/todoGroupTree', ['uses' => 'VisitTodoGroupController@todoGroupTree']);
Route::get('visit-todo-group/config', ['uses' => 'VisitTodoGroupController@config']);
Route::get('visit-todo-group/todoGroupTree', ['uses' => 'VisitTodoGroupController@todoGroupTree']);
Route::get('visit-todo-group/addTodo', ['uses' => 'VisitTodoGroupController@addTodo']);
Route::get('visit-todo-group/removeTodo', ['uses' => 'VisitTodoGroupController@removeTodo']);
Route::get('visit-todo-group/makeTodoByGroup', ['uses' => 'VisitTodoGroupController@makeTodoByGroup']);
Route::post('visit-todo-group/makeCalendar', ['uses' => 'VisitTodoGroupController@makeCalendar']);

Route::get('visit-todo-group/test', function (){
    $store = \App\Models\Busi\Store::find(3);
    $group = $store->todo_groups()
        ->where('fstart_date','<=',date('Y-m-d'))
        ->where('fend_date','>=',date('Y-m-d'))
        ->orderBy('fcreate_date','desc')
        ->first();
    $todo_ids = $group->todos->pluck('id')->toArray();
    $todos = \App\Models\Busi\VisitStoreTodo::query()->where('fparent_id',0)->whereIn('id',$todo_ids)->get();

    foreach ($todos as $t){
        foreach ($t->children->whereIn('id',$todo_ids) as $child){
            dump($child->fname);
        }
    }

    dd($todos);
});
Route::get('visit-todo-group/revisit', ['uses' => 'VisitTodoGroupController@revisit']);
Route::resource('visit-todo-group', 'VisitTodoGroupController');
