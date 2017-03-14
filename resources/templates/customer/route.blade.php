{!! $BEGIN_PHP !!}
Route::get('{{snake_case($model,'-')}}/pagination', ['uses' => '{{$model}}Controller@pagination']);
Route::resource('{{snake_case($model,'-')}}', '{{$model}}Controller');