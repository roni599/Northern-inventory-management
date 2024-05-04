<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\OrderreportController;
use App\Http\Controllers\UserAccountSettingsController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// User Routes
Route::get('/', [UserAuthController::class, 'login'])->name('user.login')->middleware('alreadyLoggedIn');
Route::post('/user/profile', [UserAuthController::class, 'profile'])->name('user.profile')->middleware('alreadyLoggedIn');
Route::get('/user/dashbord', [UserAuthController::class, 'dashbord'])->name('user.dashbord')->middleware('isLoggedIn');
Route::get('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout')->middleware('isLoggedIn');
Route::get('/user/place_order', [UserAuthController::class, 'place_order'])->name('user.place_order')->middleware('isLoggedIn');
Route::post('/user/add_order', [UserAuthController::class, 'add_order'])->name('user.add_order')->middleware('isLoggedIn');
Route::post('/user/complete_order', [UserAuthController::class, 'complete_order'])->name('user.complete_order')->middleware('isLoggedIn');
Route::get('/user/order_list', [UserAuthController::class, 'order_list'])->name('user.order_list')->middleware('isLoggedIn');
Route::get('/user/order_details', [UserAuthController::class, 'order_details'])->name('user.order_details')->middleware('isLoggedIn');
Route::delete('/user/delete-order', [UserAuthController::class, 'deleteOrder'])->name('user.delete_order')->middleware('isLoggedIn');
Route::get('/user/search/orders', [UserAuthController::class, 'searchOrdersByDesignation'])->name('search.orders')->middleware('isLoggedIn');
Route::put('/user/edit', [UserController::class, 'userEdit'])->name('user.edit')->middleware('isLoggedIn');

Route::get('/user/view_profile', [UserAccountSettingsController::class, 'view_profile'])->name('user.view_profile')->middleware('isLoggedIn');
Route::get('/user/edit_profile', [UserAccountSettingsController::class, 'edit_profile'])->name('user.edit_profile')->middleware('isLoggedIn');
Route::post('/user/store_profile', [UserAccountSettingsController::class, 'store_profile'])->name('user.store_profile')->middleware('isLoggedIn');
Route::post('/user/passchange', [UserAccountSettingsController::class, 'userPasschange'])->name('user.passchange')->middleware('isLoggedIn');

// Admin Routes 
Route::get('admin/login', [AuthController::class, 'login'])->name('admin.login')->middleware('adminAlreadyLoggedIn');
Route::post('/admin/profile', [AuthController::class, 'profile'])->name('admin.profile')->middleware('adminAlreadyLoggedIn');
Route::get('/admin/dashbord', [AuthController::class, 'dashbord'])->name('admin.dashbord')->middleware('adminIsLoggedIn');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('adminIsLoggedIn');
Route::get('/admin/viewprofile', [AuthController::class, 'viewProfile'])->name('admin.viewprofile')->middleware('adminIsLoggedIn');
Route::post('/admin/store_profile', [AuthController::class, 'Admin_store_profile'])->name('admin.store_profile')->middleware('adminIsLoggedIn');
Route::post('/admin/changepassword', [AuthController::class, 'admin_changepassword'])->name('admin.changepassword')->middleware('adminIsLoggedIn');
Route::put('/admin/userchangepassword', [AuthController::class, 'admin_user_changepassword'])->name('admin.user_changepassword')->middleware('adminIsLoggedIn');

Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store')->middleware('adminIsLoggedIn');
Route::get('/roles/index', [RoleController::class, 'index'])->name('roles.index')->middleware('adminIsLoggedIn');
Route::delete('/roles/destroy', [RoleController::class, 'roleDestroy'])->name('roles.destroy')->middleware('adminIsLoggedIn');
Route::get('/roles/pagination', [RoleController::class, 'rolePaginate']);
Route::put('/roles/edit', [RoleController::class, 'roleEdit'])->name('roles.edit')->middleware('adminIsLoggedIn');

Route::get('/organization/index', [OrganizationController::class, 'index'])->name('organization.index')->middleware('adminIsLoggedIn');
Route::post('/organization/store', [OrganizationController::class, 'store'])->name('organization.store')->middleware('adminIsLoggedIn');
Route::put('/organization/edit', [OrganizationController::class, 'organizationEdit'])->name('organization.edit')->middleware('adminIsLoggedIn');
Route::delete('/organization/destroy', [OrganizationController::class, 'organizationDestroy'])->name('organization.destroy')->middleware('adminIsLoggedIn');

Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index')->middleware('adminIsLoggedIn');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store')->middleware('adminIsLoggedIn');
Route::put('/category/edit', [CategoryController::class, 'categoryEdit'])->name('category.edit')->middleware('adminIsLoggedIn');
Route::delete('/category/destroy', [CategoryController::class, 'categoryDestroy'])->name('category.destroy')->middleware('adminIsLoggedIn');


Route::get('/product/index', [ProductController::class, 'index'])->name('product.index')->middleware('adminIsLoggedIn');
Route::get('/product/addproduct', [ProductController::class, 'addproduct'])->name('addproduct.product')->middleware('adminIsLoggedIn');
Route::post('/product/store', [ProductController::class, 'store'])->name('addproduct.store')->middleware('adminIsLoggedIn');
Route::put('/product/edit', [ProductController::class, 'productEdit'])->name('product.edit')->middleware('adminIsLoggedIn');
Route::delete('/product/destroy', [ProductController::class, 'productDestroy'])->name('product.destroy')->middleware('adminIsLoggedIn');
Route::get('/product/addprocurement', [ProductController::class, 'addprocurement'])->name('addprocurement.product')->middleware('adminIsLoggedIn');
Route::post('/product/storeprocurement', [ProductController::class, 'storeprocurement'])->name('storeprocurement.product')->middleware('adminIsLoggedIn');
Route::put('/product/procurementedit', [ProductController::class, 'procurementEdit'])->name('procurement.edit')->middleware('adminIsLoggedIn');
Route::delete('/product/procurementdestroy', [ProductController::class, 'procurementDestroy'])->name('procurement.destroy')->middleware('adminIsLoggedIn');
Route::get('/admin/product_searchlist', [ProductController::class, 'product_searchlist'])->name('orders.product_searchlist')->middleware('adminIsLoggedIn');
Route::get('/admin/user_searchlist', [ProductController::class, 'user_searchlist'])->name('orders.user_searchlist')->middleware('adminIsLoggedIn');
Route::get('/admin/exportProcurement', [ProductController::class, 'procurementExport'])->name('orders.procurementExport')->middleware('adminIsLoggedIn');

Route::get('/admin/create_user', [UserController::class, 'create'])->name('admin.create_user')->middleware('adminIsLoggedIn');
Route::post('/admin/store_user', [UserController::class, 'store'])->name('admin.store')->middleware('adminIsLoggedIn');
Route::get('/admin/user_list', [UserController::class, 'userList'])->name('admin.user_list')->middleware('adminIsLoggedIn');
Route::put('/user/edit', [UserController::class, 'userEdit'])->name('user.edit')->middleware('adminIsLoggedIn');
Route::delete('/user/destroy', [UserController::class, 'userDestroy'])->name('user.destroy')->middleware('adminIsLoggedIn');


Route::get('admin/order_place', [OrderController::class, 'Order_place'])->name('admin.order_place')->middleware('adminIsLoggedIn');
Route::post('admin/order_add', [OrderController::class, 'Order_add'])->name('admin.order_add')->middleware('adminIsLoggedIn');
Route::post('admin/complete_order', [OrderController::class, 'complete_Order'])->name('admin.order_complete')->middleware('adminIsLoggedIn');
Route::get('/orders', [OrderController::class, 'Orders'])->name('admin.orders')->middleware('adminIsLoggedIn');
Route::get('/admin/pending_order', [OrderController::class, 'Order_pending'])->name('pending.orders')->middleware('adminIsLoggedIn');
Route::get('/admin/order_details', [OrderController::class, 'order_details'])->name('orders.details')->middleware('adminIsLoggedIn');
Route::post('/admin/order_approve', [OrderController::class, 'order_approve'])->name('orders.approve')->middleware('adminIsLoggedIn');
Route::post('/admin/order_reject', [OrderController::class, 'order_reject'])->name('orders.reject')->middleware('adminIsLoggedIn');
Route::get('/admin/crendial_search', [OrderController::class, 'crendial_search'])->name('orders.crendial_search')->middleware('adminIsLoggedIn');
Route::get('/admin/initial_orderlist', [OrderController::class, 'initial_orderlist'])->name('orders.initial_orderlist')->middleware('adminIsLoggedIn');
Route::delete('/admin/delete-order', [OrderController::class, 'admindeleteOrder'])->name('admin.admin_delete_order')->middleware('adminIsLoggedIn');



Route::get('admin/report', [OrderreportController::class, 'report'])->name('order.report')->middleware('adminIsLoggedIn');
Route::get('/admin/search/users', [OrderreportController::class, 'searchUsers'])->name('search.users')->middleware('adminIsLoggedIn');
Route::get('/admin/search/product', [OrderreportController::class, 'searchProduct'])->name('search.product')->middleware('adminIsLoggedIn');
Route::get('/admin/search/category', [OrderreportController::class, 'searchCategory'])->name('search.category')->middleware('adminIsLoggedIn');
Route::get('/admin/search/designation', [OrderreportController::class, 'searchDesignation'])->name('search.designation')->middleware('adminIsLoggedIn');
Route::get('/admin/search/status', [OrderreportController::class, 'searchStatus'])->name('search.status')->middleware('adminIsLoggedIn');
Route::get('/admin/procurement_report', [OrderreportController::class, 'procurement_report'])->name('admin.procurement_report')->middleware('adminIsLoggedIn');
Route::get('/admin/search/procurement_report', [OrderreportController::class, 'search_procurement_report'])->name('admin.search_procurement_report')->middleware('adminIsLoggedIn');
Route::get('/admin/search/procurement_daysreport', [OrderreportController::class, 'daysprocurement_report'])->name('admin.daysprocurement_report')->middleware('adminIsLoggedIn');
Route::get('admin/export/', [OrderreportController::class, 'Orderexport'])->name('admin.Orderexport')->middleware('adminIsLoggedIn');
