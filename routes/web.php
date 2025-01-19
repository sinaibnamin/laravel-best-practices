<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\WebsiteController;

use App\Http\Controllers\AdminuserController;
use App\Http\Controllers\ManagementSiteSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\MemberAttendanceController;

use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\ExpenseController;

use App\Http\Controllers\SiteInfoController;

use App\Http\Middleware\Checkadminlogin;
use App\Http\Middleware\Checkmemberlogin;
use App\Http\Middleware\Checktrainerlogin;
use App\Http\Middleware\Checklogout;
use App\Http\Middleware\OnlyAdmin;


use App\Http\Controllers\UtilityController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\CronJobReportController;

use App\Http\Controllers\BkashController;
use App\Http\Controllers\MemberOnlinePayController;
use App\Http\Controllers\DeveloperController;




Route::get('/csrf-token', function () {
    return Response::json(['token' => csrf_token()]);
});


Route::get('/', [WebsiteController::class, 'index'])->name('website.index');


Route::get('/logout', [AdminuserController::class, 'logout'])->name('logout');

Route::middleware([Checklogout::class])->group(function () {
    Route::get('/admin_panel/login', [AdminuserController::class, 'index'])->name('admin_panel.login');
    Route::post('/admin_panel/login/check', [AdminuserController::class, 'check'])->name('admin_panel.login.check');

    Route::get('/member_panel/login', [MemberController::class, 'member_panel_login'])->name('member_panel.login');
    Route::post('/member_panel/login/check', [MemberController::class, 'member_panel_login_check'])->name('member_panel.login.check');

    Route::get('/trainer_panel/login', [TrainerController::class, 'trainer_panel_login'])->name('trainer_panel.login');
    Route::post('/trainer_panel/login/check', [TrainerController::class, 'trainer_panel_login_check'])->name('trainer_panel.login.check');


});


Route::middleware([Checkadminlogin::class])->prefix('admin_panel')->name('admin_panel.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // member routes     
    Route::get('/member/list', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/show/{id}', [MemberController::class, 'show'])->name('member.show');
    Route::get('/member/quickshow/{id}', [MemberController::class, 'quickshow'])->name('member.quickshow');
    Route::get('/member/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::post('/member/update/{id}', [MemberController::class, 'update'])->name('member.update');

    Route::get('/member/change_status/{status}/{id}', [MemberController::class, 'change_status'])->name('member.change_status');


    Route::get('/member/archivelist', [MemberController::class, 'index'])->name('member.archivelist');
    Route::get('/member/delete/{id}', [MemberController::class, 'delete'])->name('member.delete')->middleware(OnlyAdmin::class);


    // trainer routes     
    Route::get('/trainer/list', [TrainerController::class, 'index'])->name('trainer.index');
    Route::get('/trainer/create', [TrainerController::class, 'create'])->name('trainer.create');
    Route::post('/trainer/store', [TrainerController::class, 'store'])->name('trainer.store');
    Route::get('/trainer/show/{id}', [TrainerController::class, 'show'])->name('trainer.show');
    Route::get('/trainer/quickshow/{id}', [TrainerController::class, 'quickshow'])->name('trainer.quickshow');
    Route::get('/trainer/edit/{id}', [TrainerController::class, 'edit'])->name('trainer.edit');
    Route::post('/trainer/update/{id}', [TrainerController::class, 'update'])->name('trainer.update');
  
    Route::get('/trainer/change_status/{status}/{id}', [TrainerController::class, 'change_status'])->name('trainer.change_status');

    Route::get('/trainer/trashlist', [TrainerController::class, 'index'])->name('trainer.trashlist');


    Route::get('/trainer/delete/{id}', [TrainerController::class, 'delete'])->name('trainer.delete')->middleware(OnlyAdmin::class);

   

    // payment routes  
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');   
    Route::get('/payment/list', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/show/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('/payment/ajax_member_history/{id}', [PaymentController::class, 'ajax_member_history'])->name('payment.ajax_member_history');
    Route::get('/payment/print', [PaymentController::class, 'index'])->name('payment.print');
    Route::get('/payment/fail', [PaymentController::class, 'index'])->name('payment.fail');
  
    Route::get('/payment/edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit')->middleware(OnlyAdmin::class);
    Route::post('/payment/update/{id}', [PaymentController::class, 'update'])->name('payment.update')->middleware(OnlyAdmin::class);
    Route::get('/payment/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete')->middleware(OnlyAdmin::class);


    // instruction routes     
    Route::get('/instruction/list', [InstructionController::class, 'list'])->name('instruction.list');
    Route::get('/instruction/create', [InstructionController::class, 'create'])->name('instruction.create')->middleware(OnlyAdmin::class);
    Route::post('/instruction/store', [InstructionController::class, 'store'])->name('instruction.store')->middleware(OnlyAdmin::class);
    Route::get('/instruction/edit/{id}', [InstructionController::class, 'edit'])->name('instruction.edit')->middleware(OnlyAdmin::class);
    Route::post('/instruction/update/{id}', [InstructionController::class, 'update'])->name('instruction.update')->middleware(OnlyAdmin::class);
    Route::get('/instruction/delete/{id}', [InstructionController::class, 'delete'])->name('instruction.delete')->middleware(OnlyAdmin::class);


    // payment_type routes     
    Route::get('/payment_type/list', [PaymentTypeController::class, 'index'])->name('payment_type.index');
    Route::get('/payment_type/create', [PaymentTypeController::class, 'create'])->name('payment_type.create');
    Route::post('/payment_type/store', [PaymentTypeController::class, 'store'])->name('payment_type.store');
    Route::get('/payment_type/show/{id}', [PaymentTypeController::class, 'show'])->name('payment_type.show');
    Route::get('/payment_type/change_status/{status}/{id}', [PaymentTypeController::class, 'change_status'])->name('payment_type.change_status')->middleware(OnlyAdmin::class);
    Route::get('/payment_type/delete/{id}', [PaymentTypeController::class, 'delete'])->name('payment_type.delete');
    Route::get('/payment_type/edit/{id}', [PaymentTypeController::class, 'edit'])->name('payment_type.edit');
    Route::post('/payment_type/update/{id}', [PaymentTypeController::class, 'update'])->name('payment_type.update');




    // package routes     
    Route::get('/package/list', [PackageController::class, 'index'])->name('package.index');
    Route::get('/package/create', [PackageController::class, 'create'])->name('package.create')->middleware(OnlyAdmin::class);
    Route::post('/package/store', [PackageController::class, 'store'])->name('package.store')->middleware(OnlyAdmin::class);
    Route::get('/package/show/{id}', [PackageController::class, 'show'])->name('package.show')->middleware(OnlyAdmin::class);
    Route::get('/package/change_status/{status}/{id}', [PackageController::class, 'change_status'])->name('package.change_status')->middleware(OnlyAdmin::class);
    Route::get('/package/delete/{id}', [PackageController::class, 'delete'])->name('package.delete')->middleware(OnlyAdmin::class);
    Route::get('/package/edit/{id}', [PackageController::class, 'edit'])->name('package.edit')->middleware(OnlyAdmin::class);
    Route::post('/package/update/{id}', [PackageController::class, 'update'])->name('package.update')->middleware(OnlyAdmin::class);

    // expense_type routes     
    Route::get('/expense_type/list', [ExpenseTypeController::class, 'index'])->name('expense_type.index');
    Route::get('/expense_type/create', [ExpenseTypeController::class, 'create'])->name('expense_type.create');
    Route::post('/expense_type/store', [ExpenseTypeController::class, 'store'])->name('expense_type.store');
    Route::get('/expense_type/show/{id}', [ExpenseTypeController::class, 'show'])->name('expense_type.show');
    Route::get('/expense_type/change_status/{status}/{id}', [ExpenseTypeController::class, 'change_status'])->name('expense_type.change_status')->middleware(OnlyAdmin::class);
    Route::get('/expense_type/delete/{id}', [ExpenseTypeController::class, 'delete'])->name('expense_type.delete')->middleware(OnlyAdmin::class);
    Route::get('/expense_type/edit/{id}', [ExpenseTypeController::class, 'edit'])->name('expense_type.edit');
    Route::post('/expense_type/update/{id}', [ExpenseTypeController::class, 'update'])->name('expense_type.update');


    // expense routes     
    Route::get('/expense/list', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('/expense/print', [ExpenseController::class, 'index'])->name('expense.print');
    Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/expense/store', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/expense/show/{id}', [ExpenseController::class, 'show'])->name('expense.show');
  
    Route::get('/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit')->middleware(OnlyAdmin::class);
    Route::post('/expense/update/{id}', [ExpenseController::class, 'update'])->name('expense.update')->middleware(OnlyAdmin::class);
    Route::get('/expense/delete/{id}', [ExpenseController::class, 'delete'])->name('expense.delete')->middleware(OnlyAdmin::class);





    
    // announcement routes     
    Route::get('/announcement/list', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('/announcement/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/show/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
    Route::get('/announcement/delete/{id}', [AnnouncementController::class, 'delete'])->name('announcement.delete')->middleware(OnlyAdmin::class);
   
    Route::get('/announcement/change_status/{status}/{id}', [AnnouncementController::class, 'change_status'])->name('announcement.change_status')->middleware(OnlyAdmin::class);

    Route::get('/announcement/edit/{id}', [AnnouncementController::class, 'edit'])->name('announcement.edit');
    Route::post('/announcement/update/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');


    // member_attendance routes     
    Route::get('/member_attendance/daily_track', [MemberAttendanceController::class, 'daily_track'])->name('member_attendance.daily_track');
    Route::get('/member_attendance/monthly_report', [MemberAttendanceController::class, 'monthly_report'])->name('member_attendance.monthly_report');

    Route::post('/member_attendance/input', [MemberAttendanceController::class, 'input'])->name('member_attendance.input');

    Route::get('/member_attendance/create', [MemberAttendanceController::class, 'create'])->name('member_attendance.create');
    Route::post('/member_attendance/store', [MemberAttendanceController::class, 'store'])->name('member_attendance.store');
    Route::get('/member_attendance/show/{id}', [MemberAttendanceController::class, 'show'])->name('member_attendance.show');
    Route::get('/member_attendance/delete/{id}', [MemberAttendanceController::class, 'delete'])->name('member_attendance.delete')->middleware(OnlyAdmin::class);

    Route::get('/member_attendance/change_status/{status}/{id}', [MemberAttendanceController::class, 'change_status'])->name('member_attendance.change_status')->middleware(OnlyAdmin::class);

    Route::get('/member_attendance/edit/{id}', [MemberAttendanceController::class, 'edit'])->name('member_attendance.edit');
    Route::post('/member_attendance/update/{id}', [MemberAttendanceController::class, 'update'])->name('member_attendance.update');


    // setting route 
    Route::get('/setting/changepassword', [AdminuserController::class, 'changepassword'])->name('setting.changepassword');
    Route::post('/setting/updatepassword', [AdminuserController::class, 'updatepassword'])->name('setting.updatepassword');
 
    Route::get('/setting/system_info', [ManagementSiteSettingsController::class, 'system_info'])->name('setting.system_info');
    Route::post('/setting/system_info/update', [ManagementSiteSettingsController::class, 'system_info_update'])->name('setting.system_info.update');
 
    Route::get('/setting/system_schedule', [ManagementSiteSettingsController::class, 'edit_gym_schedule'])->name('setting.system_schedule');
    Route::post('/setting/system_schedule/update', [ManagementSiteSettingsController::class, 'gym_schedule_update'])->name('setting.system_schedule.update');


    // automation route 
    Route::get('/automation/task_scheduler', [CronJobReportController::class, 'task_scheduler'])->name('automation.task_scheduler');


    // siteinfo route 
    Route::get('/site_info/edit', [SiteInfoController::class, 'edit'])->name('site_info.edit');
    Route::post('/site_info/update', [SiteInfoController::class, 'update'])->name('site_info.update');


   

});

Route::middleware([Checkadminlogin::class])->prefix('developer_panel')->name('developer_panel.')->group(function () {
  
    // developer routes 
    Route::get('/sms/count/form', [DeveloperController::class, 'showSmsCountForm']);
   
    // Route::get('/sms/alert/status/form', [DeveloperController::class, 'showSmsCountForm']);
   
    Route::get('/system-setting', [DeveloperController::class, 'systemSetting']);

    Route::post('/system-setting/update', [DeveloperController::class, 'updateSystemSetting'])->name('system-setting-update');


});



Route::middleware([Checkmemberlogin::class])->prefix('member_panel')->name('member_panel.')->group(function () {

    Route::get('/', [DashboardController::class, 'member_dashboard'])->name('dashboard');

    Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
    Route::get('/payment_history', [MemberController::class, 'single_member_payment_history'])->name('payment_history');
    Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    Route::get('/trainer_instructions', [MemberController::class, 'single_member_trainer_instructions'])->name('trainer_instructions');
    Route::get('/editprofile', [MemberController::class, 'editprofile'])->name('editprofile');
    Route::post('/profile/update', [MemberController::class, 'update'])->name('profile.update');
    Route::get('/changepassword', [MemberController::class, 'changepassword'])->name('changepassword');
    Route::post('/updatepassword', [MemberController::class, 'updatepassword'])->name('updatepassword');

    Route::get('/pay/form', [MemberController::class, 'payform'])->name('payform');

    Route::post('/bkash/pay', [MemberOnlinePayController::class, 'createPayment'])->name('bkash.pay');


});



Route::middleware([Checktrainerlogin::class])->prefix('trainer_panel')->name('trainer_panel.')->group(function () {
    
    Route::get('/', [DashboardController::class, 'trainer_dashboard'])->name('dashboard');
    
    Route::get('/profile', [TrainerController::class, 'profile'])->name('profile');
    Route::get('/editprofile', [TrainerController::class, 'editprofile'])->name('editprofile');
    Route::post('/updateprofile', [TrainerController::class, 'update'])->name('profile.update');
    Route::get('/changepassword', [TrainerController::class, 'changepassword'])->name('changepassword');
    Route::post('/updatepassword', [TrainerController::class, 'updatepassword'])->name('updatepassword');

    Route::get('/instruction/list', [InstructionController::class, 'list'])->name('instruction.list');
    Route::get('/instruction/create', [InstructionController::class, 'create'])->name('instruction.create');
    Route::post('/instruction/store', [InstructionController::class, 'store'])->name('instruction.store');
    Route::get('/instruction/edit/{id}', [InstructionController::class, 'edit'])->name('instruction.edit');
    Route::post('/instruction/update/{id}', [InstructionController::class, 'update'])->name('instruction.update');
    Route::get('/instruction/delete/{id}', [InstructionController::class, 'delete'])->name('instruction.delete');
    
});


Route::get('/member/bkash/pay/callback', [MemberOnlinePayController::class, 'handleCallback'])->name('member.bkash.pay.callback');







// cronjobroutes
Route::get('/cron/update_member_status_943', [CronJobController::class, 'updatememberstatus'])->name('cron.updatememberstatus');
Route::get('/cron/delete_failed_payments_943', [CronJobController::class, 'deleteFailedPayments'])->name('cron.deletefailedpayments');
Route::get('/cron/send_expire_alert_sms_943', [CronJobController::class, 'sendExpireAlertSms'])->name('cron.sendexpirealertsms');

// cron commands  0 2 * * * 
// curl -s "https://gymforest.stringleap.com/cron/update_member_status_943" > /dev/null

Route::get('/download_daily_backup', [CronJobController::class, 'downloadDailyBackup'])->name('cron.download_daily_backup');


// Route::get('/download-random-images', [UtilityController::class, 'downloadRandomImages'])->name('downloadRandomImages');

Route::get('/tabledatatojson', [UtilityController::class, 'tableDataToJson'])->name('tableDataToJson');


