<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Apis
Route::group(['namespace' => '\App\Http\Controllers\Api','middleware'=>'cors'], function(){

    Route::post('/login','LoginController@login');
    Route::post('/logout','LoginController@logout');
    //Route::post('/register','LoginController@register');

    
    Route::middleware(['isUserAuthenticated'])->group(function(){
        Route::post('/calender','CalenderController@list');
    });


    Route::prefix('role')->group(function(){
        Route::get('/list','RoleController@list');
        Route::post('/add','RoleController@add');
        Route::post('/edit/{id}','RoleController@edit');
        Route::get('/delete/{id}','RoleController@delete');
    });


    Route::prefix('user')->group(function(){
        Route::get('/data','UserController@getAllUserData');  
        Route::get('/list','UserController@list');
        Route::post('/add','UserController@add');
        Route::post('/edit/{id}','UserController@edit');

        Route::post('/forgot-password','UserController@forgot_password'); 
        Route::post('/reset-password','UserController@reset_password'); 

        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/access-modules','UserController@access_modules');
            Route::get('/activites','UserController@activities');
            Route::post('/change-password','UserController@change_password');

        });
    });


    Route::prefix('work')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','WorkController@list');
            Route::post('/add','WorkController@add');
            Route::post('/edit/{id}','WorkController@edit');
        });
    });

    Route::prefix('service')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','ServiceController@list');
        });
    });





    Route::prefix('project')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','ProjectController@list');
            Route::post('/add','ProjectController@add');
            Route::post('/edit/{id}','ProjectController@edit');
            Route::get('/detail/{id}','ProjectController@detail');
        });
    });


    Route::prefix('milestone')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','MilestoneController@list');
            Route::get('/list/{projectId}','MilestoneController@projectwise_milestone');
            Route::post('/add','MilestoneController@add');
            Route::post('/edit/{id}','MilestoneController@edit');
            Route::post('/add-comment/{id}','MilestoneController@add_comment');
            Route::get('/comments/{id}','MilestoneController@show_comments'); 
        });
    });


    Route::prefix('main-task')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','MainTaskController@list');
            Route::get('/list/{projectId}/{milestoneId}','MainTaskController@milestonewise_list'); 
            Route::post('/add','MainTaskController@add');
            Route::post('/edit/{id}','MainTaskController@edit');
            Route::post('/add-comment/{id}','MainTaskController@add_comment');
            Route::get('/comments/{id}','MainTaskController@show_comments'); 
        });
    });


    Route::prefix('task')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','TaskController@list');
            Route::get('/list/{projectId}/{milestoneId}/{maintaskId}','TaskController@maintaskwise_list'); 
            Route::post('/add','TaskController@add');
            Route::post('/edit/{id}','TaskController@edit');
            Route::post('/change-status/{id}','TaskController@change_task_status');
            Route::get('/comments/{id}','TaskController@show_comments'); 
            Route::post('/productivity-wise-task-end-date','TaskController@getProductivityWiseTaskEndDate');
        });
    });


    Route::prefix('sub-task')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','SubTaskController@list');
            Route::get('/list/{projectId}/{milestoneId}/{maintaskId}/{taskId}','SubTaskController@taskwise_list'); 
            Route::post('/add','SubTaskController@add');
            Route::post('/edit/{id}','SubTaskController@edit');
            Route::post('/add-comment/{id}','SubTaskController@add_comment');
            Route::get('/comments/{id}','SubTaskController@show_comments'); 
        });
    });


    Route::prefix('handover')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','HandoverController@list');
            Route::get('/completed-list','HandoverController@completed_list');
            Route::post('/approve','HandoverController@approve');
            Route::post('/reject','HandoverController@reject');
        });
    });
















    Route::prefix('product')->group(function(){
        Route::middleware(['isUserAuthenticated'])->group(function(){
            Route::get('/list','ProductController@list');
            Route::post('/add','ProductController@add');
            Route::post('/edit/{id}','ProductController@edit');
        });
    });


    /*Route::prefix('stores')->group(function(){
        Route::post('/signup','StoreController@signup');
        Route::post('/login','StoreController@login');
        Route::post('/forgot-password','StoreController@forgotPassword');
        Route::middleware(['isStoreAuthenticated'])->group(function(){
            Route::post('/doc-upload','StoreController@docUpload');
            Route::get('/docs','StoreController@docs');
            Route::post('/resent-otp','StoreController@resentOtp');
            Route::post('/reset-password','StoreController@resetPassword');
            Route::post('/otp-verified','StoreController@getOtpVeified');
            Route::get('/product-categories','ProductCategoryController@list');
            Route::post('/product-categories','ProductCategoryController@add');
            Route::post('/product-categories/{id}','ProductCategoryController@edit');
            Route::delete('/product-categories/{id}','ProductCategoryController@delete');
            Route::get('/products','ProductController@list');
            Route::post('/products','ProductController@add');
            Route::post('/products/{id}','ProductController@edit');
            Route::delete('/products/{id}','ProductController@delete');

            Route::get('/orders','OrderController@list');
            Route::post('/order-detail','OrderController@orderDetail');

            Route::post('/logout','StoreController@logout');
        });
        
    });

    Route::prefix('customers')->group(function(){
        Route::post('/signup','CustomerController@signup');
        Route::post('/login','CustomerController@login');
        Route::post('/forgot-password','CustomerController@forgotPassword');
        Route::middleware(['isCustomerAuthenticated'])->group(function(){
            Route::post('/reset-password','CustomerController@resetPassword');
            Route::post('/otp-verified','CustomerController@getOtpVeified');
            Route::post('/resent-otp','CustomerController@resentOtp');

            Route::get('/carts','CartController@list');
            Route::post('/carts','CartController@add');
            Route::post('/carts/{id}','CartController@edit');
            Route::delete('/carts/{id}','CartController@delete');


            Route::get('/address','UserAddressController@list');
            Route::post('/address','UserAddressController@add');
            Route::delete('/address/{id}','UserAddressController@delete');

            Route::get('/products','ProductController@list');

            Route::post('/orders','OrderController@create');
            Route::get('/my-orders','CustomerController@my_orders');
            Route::post('/my-favourite','CustomerController@my_favourites');
            Route::post('/delete-my-favourite','CustomerController@delete_my_favourites');
            Route::get('/my-favourite-list','CustomerController@my_favourite_list');


            Route::post('/logout','CustomerController@logout');
        });
        Route::get('/stores','StoreController@getStores');
    });

    Route::prefix('agents')->group(function(){
        Route::post('/signup','AgentController@signup');
        Route::post('/login','AgentController@login');
        Route::post('/forgot-password','AgentController@forgotPassword');
        Route::middleware(['isAgentAuthenticated'])->group(function(){
            Route::post('/reset-password','AgentController@resetPassword');
            Route::post('/otp-verified','AgentController@getOtpVeified');
            Route::post('/resent-otp','AgentController@resentOtp');

            Route::post('/logout','AgentController@logout');
        });
    });
    Route::get('/categories','CategoryController@list');
    Route::get('/docs','DocsController@list');
    Route::get('/changePhoneStatus','TestController@mobileVerifyStatusChange');*/
});
