<?php

use App\Models\Order;
use App\Models\Prouduct;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::redirect('/', 'customer/createPage')->name('post#home');
// Route::get('/', [PostController::class, 'createpage'])->name('post#home');
Route::get('customer/createPage', [PostController::class, 'createpage'])->name('post#createPage');
Route::post('post/create',[PostController::class,'postCreate'])->name('post#create');

//delete
Route::get('post/delete/{id}', [PostController::class, 'postDelete'])->name('post#delete');

//update
Route::get('post/update/{id}',[PostCOntroller::class, 'postUpdate'])->name('post#update');

//edit
Route::get('post/edit/{id}',[PostController::class, 'postEdit'])->name('post#edit');

//edit -> data update
Route::post('post/update',[PostController::class,'postDataUpdate'])->name('post#dataupdate');


//db relation condidtion..
Route::get('product/list',function(){
    $data = Prouduct::select('prouducts.*', 'categories.name as categories_name','categories.description')
            ->rightJoin('categories','prouducts.category_id','categories.id')
            ->get();
    dd($data->toArray());
});

Route::get('order/list',function(){
    $data = Order::select('customers.name as customer_name','prouducts.name as product_name')
            ->join('customers','orders.coustomer_id','customers.id')
            ->join('prouducts','orders.product_id','prouducts.id')
            ->get();
    dd($data->toArray());
});
