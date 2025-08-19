<?php

use App\Http\Controllers\CallDataController;
use App\Http\Controllers\DataBankController;
use App\Http\Controllers\LeadsDashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientChatController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\LogoFormController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\WebFormController;
use App\Http\Controllers\SmmFormController;
use App\Http\Controllers\ContentWritingFormController;
use App\Http\Controllers\SeoFormController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\BookFormattingController;
use App\Http\Controllers\BookWritingController;
use App\Http\Controllers\AuthorWebsiteController;
use App\Http\Controllers\ProofreadingController;
use App\Http\Controllers\BookCoverController;
use App\Http\Controllers\BookMarketingController;
use App\Http\Controllers\InvoiceAPIController;
use App\Http\Controllers\IssueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
0 for seller, 1 for production, 2 for admin
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Client Links
Route::any('pay-now/{id}', [InvoiceController::class, 'payNow'])->name('client.paynow');
Route::post('/payment', [InvoiceController::class, 'paymentProcess'])->name('client.payment');
Route::any('thank-you/{id}', [InvoiceController::class, 'thankYou'])->name('thankYou');
Route::any('failed/{id}', [InvoiceController::class, 'failed'])->name('failed');

// TELNYX API
// Route::get('/call-data', [CallDataController::class, 'fetchCallData'])->name('call-data.index');
// RINGCENTRAL API
// Route::get('/ring-central', [CallDataController::class, 'fetchRCCallData'])->name('ring.index');
// Authorize.net API
// Route::get('/fetch-transactions', [TransactionController::class, 'fetchAndStoreTransactions']);

Route::group(['middleware' => 'auth'], function () {
    Route::post('change/mode', function(){
        if(Session::has('darkMode')){
            $get_dark = Session::get('darkMode');
            if($get_dark == 0){
                Session::put('darkMode', 1);
            }else{
                Session::put('darkMode', 0);
            }
        }
        return response()->json(['ok' => $get_dark]);
    });
    Route::post('/keep-alive', function () {
        if(auth()->user()->status == 0){
            return response()->json(['ok' => false]);
        }else{
            return response()->json(['ok' => true]);
        }
    });
});
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('auth');

Auth::routes(['register' => false]);
Route::get('/send-notification/{task_id}/{role}', [TaskController::class, 'sendTaskNotification']);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_client'], function(){
        Route::get('client/profile', [ClientController::class, 'clientProfile'])->name('client.profile');
        Route::patch('client/update-profile/{id}', [ClientController::class, 'updateProfile'])->name('client.update.profile');
        Route::get('client/home', [ClientController::class, 'clientDashboard'])->name('client.home');
        Route::get('client/message/{notify?}', [ClientController::class, 'clientTaskshow'])->name('client.message');
        Route::get('client/chat', [ClientChatController::class, 'clientChat'])->name('client.chat');
        Route::get('client/messages', [ClientController::class, 'clientTaskshow'])->name('client.fetch.messages');
        Route::post('client/messages', [ClientChatController::class, 'sendMessage'])->name('client.send.messages');
        Route::get('client/logo/{id}', [LogoFormController::class, 'index'])->name('client.logo.form');
        Route::get('client/web/{id}', [WebFormController::class, 'index'])->name('client.web.form');
        Route::get('client/smm/{id}', [SmmFormController::class, 'index'])->name('client.smm.form');
        Route::get('client/content/{id}', [ContentWritingFormController::class, 'index'])->name('client.content.form');
        Route::get('client/seo/{id}', [SeoFormController::class, 'index'])->name('client.seo.form');
        Route::post('client/logo/{id}', [LogoFormController::class, 'update'])->name('client.logo.form.update');
        Route::post('client/web/{id}', [WebFormController::class, 'update'])->name('client.web.form.update');
        Route::post('client/smm/{id}', [SmmFormController::class, 'update'])->name('client.smm.form.update');
        Route::post('client/content/{id}', [ContentWritingFormController::class, 'update'])->name('client.content.form.update');
        Route::post('client/seo/{id}', [SeoFormController::class, 'update'])->name('client.seo.form.update');
        Route::post('client/bookformatting/{id}', [BookFormattingController::class, 'update'])->name('client.bookformatting.form.update');
        Route::post('client/bookwriting/{id}', [BookWritingController::class, 'update'])->name('client.bookwriting.form.update');
        Route::post('client/authorwebsite/{id}', [AuthorWebsiteController::class, 'update'])->name('client.authorwebsite.form.update');
        Route::post('client/proofreading/{id}', [ProofreadingController::class, 'update'])->name('client.proofreading.form.update');
        Route::post('client/bookcover/{id}', [BookCoverController::class, 'update'])->name('client.bookcover.form.update');
        Route::post('client/bookmarketing/{id}', [BookMarketingController::class, 'update'])->name('client.bookmarketing.form.update');
        Route::post('client/logo', [LogoFormController::class, 'destroy'])->name('client.logo.form.file.delete');
        Route::get('client/projects', [ClientController::class, 'clientProject'])->name('client.project');
        Route::get('client/projects/view/{id}', [ClientController::class, 'clientProjectView'])->name('client.project.view');
        Route::get('client/task/show/{id}/{notify?}', [ClientController::class, 'clientTaskshow'])->name('client.task.show');
        Route::post('client/message/', [SupportController::class, 'sendMessageClient'])->name('client.message.send');
        Route::get('client/brief', [ClientController::class, 'getClientBrief'])->name('client.brief');
        Route::get('client/read/notification', [ClientController::class, 'markAsRead'])->name('client.read.notification');
        Route::post('client/message/seen', [ClientController::class, 'messageSeen'])->name('message.seen');
        Route::post('client/message/chunks', [SupportController::class, 'sendMessageChunks'])->name('client.message.send.chunks');

    });
});
Route::group(['middleware' => 'auth'], function () {
    Route::post('verify/code',  [AdminController::class, 'verifyCode'])->name('verify.code');
});
// Admin Routes
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin',  'middleware' => 'is_admin'], function(){
        Route::any('/autoStoreAPI', [InvoiceAPIController::class, 'managerStoreAPI'])->name('auto.store.api');
        Route::get('home', [AdminController::class, 'dashboard'])->name('admin.home');
        Route::get('edit-profile', [AdminController::class, 'editProfile'])->name('admin.edit.profile');
        Route::patch('update-profile/{id}', [AdminController::class, 'updateProfile'])->name('admin.update.profile');
        Route::get('change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');
        Route::post('change-password', [AdminController::class, 'updatePassword'])->name('admin.update.password');
        Route::get('user/production/create', [AdminUserController::class, 'getProductionUser'])->name('admin.user.production.create');
        Route::get('user/production', [AdminUserController::class, 'getUserProduction'])->name('admin.user.production');
        Route::post('user/status', [AdminUserController::class, 'updateStatus'])->name('update.user.status');
        Route::post('user/sale/password', [AdminUserController::class, 'updateSalePassword'])->name('update.user.update.password');
        Route::get('user/sales', [AdminUserController::class, 'getUserSale'])->name('admin.user.sales');
        Route::post('user/sales', [AdminUserController::class, 'storeUserSale'])->name('admin.user.sales.store');
        Route::post('user/production', [AdminUserController::class, 'storeUserSale'])->name('admin.user.production.store');
        Route::post('user/sales/password', [AdminUserController::class, 'passwordUserSale'])->name('admin.user.password');
        Route::get('user/create', [AdminUserController::class, 'createUserSale'])->name('admin.user.sales.create');
        Route::get('user/sale/edit/{id}', [AdminUserController::class, 'editUserSale'])->name('admin.user.sales.edit');
        Route::get('user/production/edit/{id}', [AdminUserController::class, 'editUserProduction'])->name('admin.user.production.edit');
        Route::post('user/sale/update/{id}', [AdminUserController::class, 'updateUserSale'])->name('admin.user.sales.update');
        Route::resource('category', CategoryController::class);
        Route::resource('brand', BrandController::class);
        Route::resource('service', ServiceController::class);
        Route::resource('package', PackageController::class);
        Route::resource('currency', CurrencyController::class);
        Route::get('/service-list/{id}', [HomeController::class, 'serviceList'])->name('admin.service.list');
        Route::resource('client', AdminClientController::class, ['names' => 'admin.client']);
        Route::resource('merchant', MerchantController::class, ['names' => 'admin.merchant']);
        Route::post('client/create_auth/', [AdminClientController::class, 'createAuth'])->name('admin.client.createauth');
        Route::post('client/update_auth/', [AdminClientController::class, 'updateAuth'])->name('admin.client.updateauth');
        Route::get('client/agent/{brand_id?}', [AdminClientController::class, 'getAgent'])->name('admin.client.agent');
        Route::post('assign/support/', [AdminClientController::class, 'assignSupport'])->name('admin.assign.support');
        Route::post('client/agent/update', [AdminClientController::class, 'updateAgent'])->name('admin.client.update.agent');
        Route::resource('project', AdminProjectController::class, ['names' => 'admin.project']);
        Route::resource('task', AdminTaskController::class, ['names' => 'admin.task']);
        Route::post('admin/subtask/store', [AdminTaskController::class, 'adminSubtaskStore'])->name('admin.subtask.store');
        Route::get('client/{client}/{id}', [AdminClientController::class, 'showNotification'])->name('admin.client.shownotification');
        Route::get('create-invoice/{id}', [InvoiceController::class, 'index'])->name('admin.invoice.index');
        // Route::post('invoice', [InvoiceAPIController::class, 'managerStore'])->name('admin.invoice.create');
        Route::post('invoice', [InvoiceController::class, 'store'])->name('admin.invoice.create');
        Route::post('update/invoice/{id}', [InvoiceController::class, 'updateInvoice'])->name('admin.invoice.update');
        Route::delete('invoice/{id}', [InvoiceController::class, 'destroy'])->name('admin.invoice.delete');
        Route::any('invoice/generated/{id}', [InvoiceController::class, 'linkPage'])->name('admin.link');
        Route::get('invoice', [InvoiceController::class, 'invoiceAll'])->name('admin.invoice');
        Route::get('invoice/{id}/edit', [InvoiceController::class, 'invoiceEdit'])->name('admin.invoice.edit');
        Route::get('invoice/{id}', [InvoiceController::class, 'getInvoice'])->name('admin.single.invoice');
        Route::get('brief-pending', [LogoFormController::class, 'getBriefPending'])->name('admin.brief.pending');
        Route::get('pending/projects', [LogoFormController::class, 'getPendingProject'])->name('admin.pending.project');
        Route::get('pending/projects/{id}/{form}', [LogoFormController::class, 'getPendingProjectbyId'])->name('admin.pending.project.details');
        Route::post('invoice/paid/{id}', [InvoiceController::class, 'invoicePaidById'])->name('admin.invoice.paid');
        Route::get('message/edit/{id}', [SupportController::class, 'editMessageByAdminClientId'])->name('admin.message.edit');
        Route::post('message/update', [SupportController::class, 'updateAdminMessage'])->name('admin.message.update');
        Route::get('message', [SupportController::class, 'getMessageByAdmin'])->name('admin.message');
        Route::get('message/{id}/{name}/show', [SupportController::class, 'getMessageByAdminClientId'])->name('admin.message.show');
        // OBJECTION ROUTES
        Route::post('get-objection-data',[SupportController::class, 'ObjectionData'])->name('admin.objections');
        Route::post('post-objection-data',[SupportController::class, 'CreateObjectionData'])->name('admin.objections.create');
        Route::post('update-objection-status',[SupportController::class, 'updateObjectionStatus'])->name('admin.objections.status');
        Route::post('get-objection-details', [SupportController::class, 'getObjectionDetails'])->name('admin.objections.details');

        Route::get('/tickets', [IssueController::class, 'getTickets'])->name('admin.tickets');
        Route::post('/generate/ticket', [IssueController::class, 'generateTicket'])->name('admin.ticket.generate');
        Route::get('/issue/{id}/edit', [IssueController::class, 'edit'])->name('admin.issue.edit');
        Route::post('/update/ticket/{id}', [IssueController::class, 'update'])->name('admin.issue.update');
        Route::get('/issue/{id}', [IssueController::class, 'show'])->name('admin.issue.show');
        Route::delete('/issue/{id}', [IssueController::class, 'destroy'])->name('admin.issue.destroy');

        Route::get('/get/brand/users', [IssueController::class, 'getUserBrands'])->name('admin.user.brand');
        Route::post('/ticket/chunks', [IssueController::class, 'sendTicketChunks'])->name('admin.send.chunks');


        // LEADS DASHBOARD ROUTES
        Route::get('leads-dashboard', [LeadsDashboardController::class, 'dashboard'])->name('admin.leads.dashboard');
        // Route::get('/leads', [LeadsDashboardController::class, 'index'])->name('admin.leads.index');
        Route::post('/leads', [LeadsDashboardController::class, 'store'])->name('admin.leads.store');


        Route::get('/dataBank' , [DataBankController::class, 'index'])->name('data-bank.index');
        Route::get('/dataBank/details/{contact}', [DataBankController::class, 'detailView'])->name('data-bank.details');

        Route::get('/data-bank/merchant-log', [DataBankController::class, 'merchant_data'])->name('data-bank.merchant-log');
        Route::get('/data-bank/refund-log', [DataBankController::class, 'refund_merchant_data'])->name('data-bank.refund-log');
        Route::get('/data-bank/telnyx-call-log', [DataBankController::class, 'telnyx_call_log'])->name('data-bank.telnyx-call-log');
        Route::get('/data-bank/ringCentral-call-log', [DataBankController::class, 'ringCentral_call_log'])->name('data-bank.ringCentral-call-log');
        Route::get('/data-bank/designnes-chat', [DataBankController::class, 'designnes_chat'])->name('data-bank.designnes-chat');
        Route::get('/data-bank/marketingNotch-chat', [DataBankController::class, 'marketingNotch_chat'])->name('data-bank.marketingNotch-chat');
        Route::get('/data-bank/web-forms', [DataBankController::class, 'webForms'])->name('data-bank.web-forms');

        Route::get('/transactions', [TransactionController::class, 'index']);

        Route::get('/databank/search', [LeadsDashboardController::class, 'search'])->name('databank.search');

    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_support'], function(){
        // TICKET ROUTES
        Route::get('support/tickets', [IssueController::class, 'getTicketsSupport'])->name('support.tickets');
        Route::get('support/issue/{id}', [IssueController::class, 'showTicketSupport'])->name('support.issue.show');
        Route::post('support/issue/status', [IssueController::class, 'updateTicketStatus'])->name('support.issue.status.update');
        // TICKET ROUTES

        Route::post('support/assign/form', [SupportController::class, 'assignServices'])->name('support.assign.form');
        Route::get('support/serives', [SupportController::class, 'getServices'])->name('support.get.services');
        Route::get('profile', [SupportController::class, 'editProfile'])->name('support.edit.profile');
        Route::patch('support/update-profile/{id}', [SupportController::class, 'updateProfile'])->name('support.update.profile');
        Route::get('password', [SupportController::class, 'changePassword'])->name('support.change.password');
        Route::post('support/change-password', [SupportController::class, 'updatePassword'])->name('support.update.password');
        Route::get('support/home', [SupportController::class, 'index'])->name('support.home');
        Route::get('support/projects', [SupportController::class, 'projects'])->name('support.project');
        // Route::get('support/all-projects', [SupportController::class, 'allProjects'])->name('support.all-projects');
        Route::get('support/message/', [SupportController::class, 'getMessageBySupport'])->name('support.message.get.by.support');
        Route::get('support/{form_id}/projects/{check}/form/{id}', [SupportController::class, 'getForm'])->name('support.form');
        Route::get('support/{form_id}/form/douwnload/{check}', [SupportController::class, 'downloadForm'])->name('support.form.download');
        Route::get('support/message/{id}/show', [SupportController::class, 'showMessage'])->name('support.message.show');
        Route::post('support/message/', [SupportController::class, 'sendMessage'])->name('support.message.send');
        Route::post('support/message/chunks', [SupportController::class, 'sendMessageChunks'])->name('support.message.send.chunks');
        Route::get('create/task/{id}/{name}/{notify?}', [TaskController::class, 'createTaskByProjectId'])->name('create.task.by.project.id');
        Route::post('support/task/store', [TaskController::class, 'storeTaskBySupport'])->name('store.task.by.support');
        Route::post('support/task/notes', [TaskController::class, 'storeoNotesBySupport'])->name('store.notes.by.support');
        Route::get('support/task/list', [TaskController::class, 'supportTaskList'])->name('support.task');
        Route::get('support/task/show/{id}/{notify?}', [TaskController::class, 'supportTaskShow'])->name('support.task.show');
        Route::post('support/subtask/store', [TaskController::class, 'supportTaskStore'])->name('support.subtask.store');
        Route::post('support/files/{id}', [TaskController::class, 'insertFiles'])->name('support.insert.sale.files');
        Route::post('support/files/show/client', [TaskController::class, 'showFilesToClient'])->name('support.client.file.show');
        Route::get('support/message/{id}/{name}/show/{notify?}', [SupportController::class, 'getMessageBySupportClientId'])->name('support.message.show.id');
        Route::get('/support/message/edit/{id}', [SupportController::class, 'editMessageBySupportClientId'])->name('support.message.edit');
        Route::post('/support/message/update', [SupportController::class, 'updateSupportMessage'])->name('support.message.update');
        Route::get('support/read/notification', [SupportController::class, 'markAsRead'])->name('support.read.notification');
         // OBJECTION ROUTES
        Route::post('get-objection-data',[SupportController::class, 'ObjectionData'])->name('support.objections');
        Route::post('update-objection-status',[SupportController::class, 'updateObjectionStatus'])->name('support.objections.status');
        Route::post('get-objection-details', [SupportController::class, 'getObjectionDetails'])->name('support.objections.details');
        Route::post('reply-objection', [SupportController::class, 'supportReplyObjection'])->name('support.objections.reply');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_sale'], function(){
        // TICKET ROUTES
        Route::get('/tickets', [IssueController::class, 'getTicketsSale'])->name('sale.tickets');
        Route::get('/issue/{id}', [IssueController::class, 'showTicketSale'])->name('sale.issue.show');
        // TICKET ROUTES

        Route::get('/projects', [HomeController::class, 'getProjectBySale'])->name('sale.project');
        Route::get('task/show/{id}', [TaskController::class, 'saleTaskShow'])->name('sale.task.show');
        Route::get('/home', [HomeController::class, 'index'])->name('sale.home');
        Route::get('sale/edit-profile', [HomeController::class, 'editProfile'])->name('sale.edit.profile');
        Route::patch('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('sale.update.profile');
        Route::get('/change-password', [HomeController::class, 'changePassword'])->name('sale.change.password');
        Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('sale.update.password');
        Route::resource('/project', ProjectController::class);
        Route::resource('/client', ClientController::class);
        Route::get('/payment-link/{id}', [ClientController::class, 'paymentLink'])->name('client.generate.payment');
        Route::resource('/task', TaskController::class);
        Route::resource('/subtask', SubTaskController::class);
        Route::post('/sale/files/{id}', [TaskController::class, 'insertFiles'])->name('insert.sale.files');
        Route::get('/service-list/{id}', [HomeController::class, 'serviceList'])->name('service.list');
        Route::get('/package-list/{service_id}/{brand_id}', [HomeController::class, 'packageList'])->name('package.list');
        Route::get('/assigned/client', [ClientController::class, 'getAssignedClient'])->name('assigned.client');
        Route::get('/client-chat/{id}', [HomeController::class, 'saleChat'])->name('sale.chat');
        Route::get('sale/messages/{id}', [HomeController::class, 'fetchMessages'])->name('sale.fetch.messages');
        Route::post('sale/messages/{id}', [HomeController::class, 'sendMessage'])->name('sale.send.messages');
        Route::post('invoice', [InvoiceController::class, 'saleStore'])->name('sale.invoice.create');
        Route::post('invoice/update', [InvoiceController::class, 'saleUpdate'])->name('sale.invoice.update');
        Route::any('invoice/generated/{id}', [InvoiceController::class, 'linkPageSale'])->name('sale.link');
        Route::get('invoice', [InvoiceController::class, 'getInvoiceByUserId'])->name('sale.invoice');
        Route::get('invoice/{id}', [InvoiceController::class, 'getSingleInvoice'])->name('sale.single.invoice');
        Route::get('invoice/edit/{id}', [InvoiceController::class, 'editInvoice'])->name('sale.invoice.edit');
        Route::post('client/create_auth/', [AdminClientController::class, 'createAuth'])->name('sale.client.createauth');
        Route::post('client/update_auth/', [AdminClientController::class, 'updateAuth'])->name('sale.client.updateauth');
        Route::get('brief/pending', [LogoFormController::class, 'getBriefPendingById'])->name('sale.brief.pending');
        Route::get('sale/{form_id}/projects/{check}/form/{id}', [SupportController::class, 'getFormSale'])->name('sale.form');
    });
});
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_production'], function(){
        Route::get('/production/dashboard', [HomeController::class, 'productionDashboard'])->name('production.dashboard');
        Route::get('/production/home', [HomeController::class, 'productionHome'])->name('production.home');
        Route::get('/production/profile/edit', [HomeController::class, 'productionProfile'])->name('production.profile');
        Route::get('/production/task/{id}/{notify?}', [TaskController::class, 'productionShow'])->name('production.task.show');
        Route::get('/production/subtask/{id}/{notify?}', [TaskController::class, 'productionSubtaskShow'])->name('production.subtask.show');
        Route::post('/production/subtask', [SubTaskController::class, 'producionSubtask'])->name('production.subtask.store');
        Route::get('/production/subtask', [SubTaskController::class, 'producionSubtaskAssigned'])->name('production.subtask.assigned');
        Route::post('/production/files/{id}', [TaskController::class, 'insertFiles'])->name('insert.files');
        Route::post('/production/file/delete', [TaskController::class, 'deleteFiles'])->name('delete.files');
        Route::post('/production/updatetask/{id}', [TaskController::class, 'updateTask'])->name('update.task');
        Route::post('/production/subtask/assign', [SubTaskController::class, 'producionSubtaskAssign'])->name('production.subtask.assign');
        Route::post('/production/files/show/agent', [TaskController::class, 'showFilesToAgent'])->name('production.agent.file.show');
        Route::get('production/{form_id}/projects/{check}/form/{id}', [SupportController::class, 'getFormByProduction'])->name('production.form');
        Route::get('production/download/{form_id}/projects/{check}/form/{id}', [SupportController::class, 'getPdfFormByProduction'])->name('production.download.form');
        Route::patch('production/update-profile/{id}', [HomeController::class, 'updateProfileProduction'])->name('production.update.profile');
        Route::get('notification/all/read', [HomeController::class, 'readNotification'])->name('notification.all.read');
        Route::get('notification', [HomeController::class, 'allNotification'])->name('production.notification');
        Route::post('change/duedate', [SubTaskController::class, 'productionChangeDuedate'])->name('production.change.duadate');
        Route::post('production/member/message', [SubTaskController::class, 'productionMemberSubtaskStore'])->name('production.member.subtask.store');
        Route::post('/production/member/files/{id}/{subtask_id?}', [TaskController::class, 'insertFilesMember'])->name('production.member.insert.files');
        Route::post('production/member/category', [TaskController::class, 'categoryMemberList'])->name('category.member.list');
        Route::post('production/member/category/add', [TaskController::class, 'categoryMemberListAdd'])->name('category.member.list.add');
        Route::post('production/member/category/remove', [TaskController::class, 'categoryMemberListRemove'])->name('category.member.list.remove');
    });
});
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_member'], function(){
        Route::get('/member/dashboard', [HomeController::class, 'memberDashboard'])->name('member.dashboard');
        Route::get('/member/task', [TaskController::class, 'memberTask'])->name('member.home');
        Route::get('/member/task/{id}/{notify?}', [SubTaskController::class, 'memberSubTask'])->name('member.subtask.show');
        Route::post('/member/files/{id}/{subtask_id?}', [TaskController::class, 'insertFilesMember'])->name('member.insert.files');
        Route::post('/member/subtask', [SubTaskController::class, 'memberSubtaskStore'])->name('member.subtask.store');
        Route::post('/member/subtask/update/{id}', [SubTaskController::class, 'memberSubtaskUpdate'])->name('member.update.task');
        Route::get('member/{form_id}/projects/{check}/form/{id}', [SupportController::class, 'getFormByMember'])->name('member.form');
    });
});

Route::get('/verify', [VerifyController::class, 'index'])->name('salemanager.verify');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_sale_manager'], function(){
        // TICKET ROUTES
        Route::get('/manager/tickets', [IssueController::class, 'getTicketsManager'])->name('manager.tickets');
        Route::get('/manager/issue/{id}', [IssueController::class, 'showTicketManager'])->name('manager.issue.show');
        // TICKET ROUTES

        Route::get('/manager/dashboard', [HomeController::class, 'managerDashboard'])->name('salemanager.dashboard');
        Route::get('/manager/clients', [ClientController::class, 'managerClient'])->name('salemanager.client.index');
        Route::get('/manager/clients/create', [ClientController::class, 'managerClientCreate'])->name('salemanager.client.create');
        Route::post('/manager/clients/create', [ClientController::class, 'managerClientStore'])->name('salemanager.client.store');
        Route::get('/manager/payment-link/{id}', [ClientController::class, 'managerPaymentLink'])->name('manager.generate.payment');
        Route::post('/manager/invoice', [InvoiceController::class, 'managerStore'])->name('manager.invoice.create');
        Route::any('/manager/invoice/generated/{id}', [InvoiceController::class, 'linkPageManager'])->name('manager.link');
        Route::patch('/manager/clients/update/{id}', [ClientController::class, 'managerClientUpdate'])->name('manager.client.update');
        Route::get('/manager/clients/edit/{id}', [ClientController::class, 'managerClientEdit'])->name('manager.client.edit');
        Route::get('/manager/invoice', [InvoiceController::class, 'getInvoiceBySaleManager'])->name('manager.invoice');
        Route::post('/manager/create_auth/', [AdminClientController::class, 'createAuthManager'])->name('manager.client.createauth');
        Route::post('/manager/update_auth/', [AdminClientController::class, 'updateAuthManager'])->name('manager.client.updateauth');
        Route::post('/manager/invoice/paid/{id}', [InvoiceController::class, 'invoicePaidByIdManager'])->name('manager.invoice.paid');
        Route::get('/manager/brief/pending', [LogoFormController::class, 'getBriefPendingByIdManager'])->name('manager.brief.pending');
        Route::get('/manager/invoice/edit/{id}', [InvoiceController::class, 'editInvoiceManager'])->name('manager.invoice.edit');
        Route::post('/manager/invoice/update', [InvoiceController::class, 'saleUpdateManager'])->name('manager.invoice.update');
        Route::get('/manager/pending/projects', [LogoFormController::class, 'getPendingProjectManager'])->name('manager.pending.project');
        Route::get('/manager/pending/projects/{id}/{form}', [LogoFormController::class, 'getPendingProjectbyIdManager'])->name('manager.pending.project.details');
        Route::post('/manager/assign/support/', [AdminClientController::class, 'assignSupportManager'])->name('manager.assign.support');
        Route::post('/manager/reassign/support/', [AdminClientController::class, 'reassignSupportManager'])->name('manager.reassign.support');
        Route::get('/manager/client/agent/{brand_id?}', [AdminClientController::class, 'getAgentManager'])->name('manager.client.agent');
        Route::get('/manager/project', [AdminProjectController::class, 'indexManager'])->name('manager.project.index');
        Route::get('/manager/project/edit/{id}', [AdminProjectController::class, 'indexEdit'])->name('manager.project.edit');
        Route::get('/manager/task', [AdminTaskController::class, 'indexManager'])->name('manager.task.index');
        Route::get('/manager/task/show/{id}', [TaskController::class, 'managerTaskShow'])->name('manager.task.show');
        Route::post('/manager/task/production', [TaskController::class, 'managerTaskProduction'])->name('manager.task.production');
        Route::post('manager/subtask/store', [TaskController::class, 'managerTaskStore'])->name('manager.subtask.store');
        Route::post('/manager/files/{id}', [TaskController::class, 'managerInsertFiles'])->name('manager.insert.sale.files');
        Route::post('/manager/message/', [SupportController::class, 'managerSendMessage'])->name('manager.message.send');
        Route::post('/manager/task/notes', [TaskController::class, 'storeoNotesByManager'])->name('store.notes.by.manager');
        Route::get('/manager/message', [SupportController::class, 'getMessageByManager'])->name('manager.message');
        Route::get('/manager/message/{id}/{name}/show', [SupportController::class, 'getMessageByManagerClientId'])->name('manager.message.show');
        Route::get('/manager/message/edit/{id}', [SupportController::class, 'editMessageByManagerClientId'])->name('manager.message.edit');
        Route::post('/manager/message/update', [SupportController::class, 'updateManagerMessage'])->name('manager.message.update');
        Route::get('/manager/clients/details/{id}/{name}', [ClientController::class, 'managerClientById'])->name('manager.client.details');
        Route::get('/manager/edit-profile', [HomeController::class, 'editProfileManager'])->name('manager.edit.profile');
        Route::patch('/manager/update-profile/{id}', [HomeController::class, 'updateProfileManager'])->name('manager.update.profile');
        Route::get('/manager/change-password', [HomeController::class, 'changePasswordManager'])->name('manager.change.password');
        Route::post('/manager/change-password', [HomeController::class, 'updatePasswordManager'])->name('manager.update.password');
        Route::get('manager/{form_id}/projects/{check}/form/{id}', [SupportController::class, 'getFormManager'])->name('manager.form');
        Route::post('manager/mark/notification', [HomeController::class, 'markNotification'])->name('mark.notification');
        Route::get('manager/notification', [HomeController::class, 'managerNotification'])->name('manager.notification');
        Route::post('manager/payment/auto', [InvoiceController::class, 'managerPaymentAuto'])->name('manager.payment.auto');
        Route::post('manager/payment/paybynmi', [InvoiceController::class, 'managerPaymentPaybynmi'])->name('manager.payment.paybynmi');
        Route::post('brands/merchant', [BrandController::class, 'brandMerchant'])->name('manager.brands.merchant');
    });
});
