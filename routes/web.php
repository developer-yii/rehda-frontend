<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\backend\CircularController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\MemberController;
use App\Http\Controllers\backend\MemberUserController;
use App\Http\Controllers\backend\MemberBranchApprovalController;
use App\Http\Controllers\backend\MemberBillingController;
use App\Http\Controllers\backend\MemberRejectedRegistrationController;
use App\Http\Controllers\backend\MemberActiveRegistrationController;
use App\Http\Controllers\backend\MemberInActiveRegistrationController;
use App\Http\Controllers\backend\MemberUploadCertController;
use App\Http\Controllers\backend\MemberInfoController;
use App\Http\Controllers\backend\MembershipNumberController;
use App\Http\Controllers\backend\MemberStatementAccountController;
use App\Http\Controllers\backend\NewsletterController;
use App\Http\Controllers\backend\OrdinaryUserController;
use App\Http\Controllers\backend\SubsidiaryUserController;
use App\Http\Controllers\backend\AffiliateUserController;
use App\Http\Controllers\backend\AssociateUserController;
use App\Http\Controllers\backend\YouthUserController;
use App\Http\Controllers\backend\NoticeController;
use App\Http\Controllers\backend\OfficialRepChangeRequestController;
use App\Http\Controllers\BranchAnnualreportController;
use App\Http\Controllers\BranchContactDetailsController;
use App\Http\Controllers\frontend\AnnualreportController;
use App\Http\Controllers\frontend\BranchCircularController;
use App\Http\Controllers\frontend\BranchNewsletterController;
use App\Http\Controllers\frontend\BulletinController;
use App\Http\Controllers\frontend\ChooseCompanyController;
use App\Http\Controllers\frontend\Circularcontroller as FrontendCircularcontroller;
use App\Http\Controllers\frontend\CompanyinfoController;
use App\Http\Controllers\frontend\InvoiceController;
use App\Http\Controllers\frontend\MembershipCertificateController;
use App\Http\Controllers\frontend\OfficialRepresentativeController;
use App\Http\Controllers\frontend\OthersController;
use App\Http\Controllers\frontend\StatementOfAccountController;
use App\Http\Controllers\frontend\UserprofileController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', [LoginController::class, 'viewLogin']);
Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');
Route::post('forgot-pwd', [LoginController::class, 'forgotpwd'])->name('forgot.pwd');

Route::post('invoice/paymentreturn', [InvoiceController::class, 'invoicePaymentreturn'])->name('invoice.paymentreturn');
Route::post('invoice/paymentreturncallback', [InvoiceController::class, 'invoicePaymentreturncallback'])->name('invoice.paymentreturncallback');
Route::get('invoice/paymentfpx/{order_no}/{auth}', [InvoiceController::class, 'invoicePaymentfpx'])->name('invoice.paymentfpx');
Route::get('invoice/paymentcard/{order_no}/{auth}', [InvoiceController::class, 'invoicePaymentcard'])->name('invoice.paymentcard');
Route::get('paymentcard/{order_no}/{auth}', [InvoiceController::class, 'invoicePaymentcard'])->name('invoice.paymentcard');
Route::get('paymentfpx/{order_no}/{auth}', [InvoiceController::class, 'invoicePaymentfpx'])->name('invoice.paymentfpx');
Route::get('payment/fail', [InvoiceController::class, 'paymentFail'])->name('payment.fail');
Route::get('payment/success', [InvoiceController::class, 'paymentSuccess'])->name('payment.success');
Route::get('payment/pending/{orderno}', [InvoiceController::class, 'PaymentPending'])->name('payment.pending');

Route::post('ordinary-register', [RegisterController::class, 'ordinaryRegister'])->name('ordinary.register');
Route::post('subsidiary-register', [RegisterController::class, 'subsidiaryRegister'])->name('subsidiary.register');
Route::post('affiliate-register', [RegisterController::class, 'affiliateRegister'])->name('affiliate.register');
Route::post('associate-register', [RegisterController::class, 'associateRegister'])->name('associate.register');
Route::post('rehdayouth-register', [RegisterController::class, 'rehdayouthRegister'])->name('rehdayouth.register');
Route::get('register-success', [RegisterController::class, 'registerSuccess'])->name('register-success');
Route::post('validate-company-name', [RegisterController::class, 'validateCompanyName'])->name('validateCompanyName');
Route::post('validate-company-reg-no', [RegisterController::class, 'validateCompanyRegNo'])->name('validateCompanyRegNo');

Route::middleware('auth')->group(function () {

    Route::prefix('circular')->as('circulars.')->group(function () {
        Route::get('/', [CircularController::class, 'index'])->name('index');
        Route::get('/create', [CircularController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [CircularController::class, 'edit'])->name('edit');
        Route::post('/store', [CircularController::class, 'store'])->name('store');
        Route::post('/update', [CircularController::class, 'update'])->name('update');
        Route::delete('/delete', [CircularController::class, 'delete'])->name('delete');
        Route::get('/membership', [CircularController::class, 'membership'])->name('membership');
        Route::delete('/membership-permission/delete', [CircularController::class, 'membershipPermisionDelete'])->name('membership.permision.delete');
        Route::post('/membership-permission/store', [CircularController::class, 'membershipPermissionStore'])->name('membership.permision.store');
        Route::get('/branch', [CircularController::class, 'branch'])->name('branch');
        Route::delete('/branch-permission/delete', [CircularController::class, 'branchPermisionDelete'])->name('branch.permision.delete');
        Route::post('/branch-permission/store', [CircularController::class, 'branchPermissionStore'])->name('branch.permision.store');
    });

    Route::prefix('newsletter')->as('newsletters.')->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('index');
        Route::get('/create', [NewsletterController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [NewsletterController::class, 'edit'])->name('edit');
        Route::post('/store', [NewsletterController::class, 'store'])->name('store');
        Route::post('/update', [NewsletterController::class, 'update'])->name('update');
        Route::delete('/delete', [NewsletterController::class, 'destroy'])->name('delete');
        Route::get('/membership', [NewsletterController::class, 'membership'])->name('membership');
        Route::delete('/membership-permission/delete', [NewsletterController::class, 'membershipPermisionDelete'])->name('membership.permision.delete');
        Route::post('/membership-permission/store', [NewsletterController::class, 'membershipPermissionStore'])->name('membership.permision.store');
        Route::get('/sort-table', [NewsletterController::class, 'sortTable'])->name('sortTable');
        Route::post('/sort/update', [NewsletterController::class, 'sortUpdate'])->name('sortUpdate');
        Route::get('/branch', [NewsletterController::class, 'branch'])->name('branch');
        Route::delete('/branch-permission/delete', [NewsletterController::class, 'branchPermisionDelete'])->name('branch.permision.delete');
        Route::post('/branch-permission/store', [NewsletterController::class, 'branchPermissionStore'])->name('branch.permision.store');
    });

    Route::prefix('notice')->as('notices.')->group(function () {
        Route::get('/', [NoticeController::class, 'index'])->name('index');
        Route::get('/create', [NoticeController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [NoticeController::class, 'edit'])->name('edit');
        Route::post('/store', [NoticeController::class, 'store'])->name('store');
        Route::post('/update', [NoticeController::class, 'update'])->name('update');
        Route::delete('/delete', [NoticeController::class, 'delete'])->name('delete');
        Route::get('/membership', [NoticeController::class, 'membership'])->name('membership');
        Route::delete('/membership-permission/delete', [NoticeController::class, 'membershipPermisionDelete'])->name('membership.permision.delete');
        Route::post('/membership-permission/store', [NoticeController::class, 'membershipPermissionStore'])->name('membership.permision.store');
        Route::get('/branch', [NoticeController::class, 'branch'])->name('branch');
        Route::delete('/branch-permission/delete', [NoticeController::class, 'branchPermisionDelete'])->name('branch.permision.delete');
        Route::post('/branch-permission/store', [NoticeController::class, 'branchPermissionStore'])->name('branch.permision.store');
    });

      Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
      Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/getUser', [UserController::class, 'getUser'])->name('getUser');
            Route::get('/getSingleUser', [UserController::class, 'getSingleUser'])->name('getSingleUser');
            Route::get('/deleteUser', [UserController::class, 'deleteUser'])->name('deleteUser');
            Route::post('/createUser', [UserController::class, 'saveOrUpdateUser'])->name('createUser');
      });
      Route::prefix('profile')->as('profile.')->group(function () {
            Route::get('edit-prfile/{id}', [ProfileController::class, 'editprofile'])->name('editprofile');
            Route::post('update-prfile', [ProfileController::class, 'updateprofile'])->name('update');
      });
      Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'addeditrole'])->name('create');
            Route::post('/create', [RoleController::class, 'saveOrUpdateRole'])->name('add');
            Route::get('/delete', [RoleController::class, 'delete'])->name('delete');
      });

      Route::prefix('members')->as('members.')->group(function () {
            Route::get('/newRegistration', [MemberController::class, 'newRegistration'])->name('newRegistration');
            Route::get('/newReg/{id}/edit', [MemberController::class, 'edit'])->name('edit');
            Route::post('/newReg/{id}/update', [MemberController::class, 'update'])->name('update');
            Route::post('/newReg/reject', [MemberController::class, 'reject'])->name('reject');
      });

      Route::prefix('members')->as('members.')->group(function () {
            Route::post('/branch/approve', [MemberBranchApprovalController::class, 'approve'])->name('branch.approve');
            Route::post('/branch/getSingle', [MemberBranchApprovalController::class, 'getSingle'])->name('branch.getSingle');
      });

      Route::prefix('members')->as('mm-registration-reject.')->group(function () {
            Route::get('/rejectedRegistration', [MemberRejectedRegistrationController::class, 'rejectedRegistration'])->name('index');
      });

      Route::prefix('members')->as('active-members.')->group(function () {
            Route::get('/active/', [MemberActiveRegistrationController::class, 'activeMembers'])->name('index');
            Route::get('/registration/{id}/edit', [MemberActiveRegistrationController::class, 'edit'])->name('edit');
            Route::post('/registration/{id}/update', [MemberActiveRegistrationController::class, 'update'])->name('update');
            Route::get('/profile/{id}/edit', [MemberActiveRegistrationController::class, 'profileEdit'])->name('profile.edit');
            Route::post('/profile/{id}/update', [MemberActiveRegistrationController::class, 'profileUpdate'])->name('profile.update');
      });

      Route::prefix('members')->as('active-members.')->group(function () {
            Route::get('/upload-cert/show', [MemberUploadCertController::class, 'showCert'])->name('uploadcert.show');
            Route::post('/upload-cert/delete', [MemberUploadCertController::class, 'deleteCert'])->name('uploadcert.delete');
            Route::post('/upload-cert/update', [MemberUploadCertController::class, 'updateCert'])->name('uploadcert.update');
      });

      Route::prefix('members')->as('active-members.')->group(function () {
            Route::get('/member-info', [MemberInfoController::class, 'index'])->name('member-info');
            Route::post('/change-password', [MemberInfoController::class, 'resetPassword'])->name('resetPassword');
            Route::get('/edit-mmuser', [MemberInfoController::class, 'editUser'])->name('editUser');
            Route::post('/update-mmuser', [MemberInfoController::class, 'updateUser'])->name('updateUser');
            Route::post('/delete-user', [MemberInfoController::class, 'deleteUser'])->name('deleteUser');
            Route::get('/add-mmoffuser', [MemberInfoController::class, 'addmmOffUser'])->name('addmmOffUser');
            Route::post('/post-add-mmoffuser', [MemberInfoController::class, 'postAddmmOffUser'])->name('post-addmmOffUser');
            Route::get('/add-mmadmuser', [MemberInfoController::class, 'addmmAdmUser'])->name('addmmAdmUser');
            Route::post('/post-add-mmadmuser', [MemberInfoController::class, 'postAddmmAdmUser'])->name('post-addmmAdmUser');
      });

      Route::prefix('members')->as('active-members.')->group(function () {
            Route::get('/getStatementOfAccount', [MemberStatementAccountController::class, 'getStatement'])->name('getStatementOfAccount');
            Route::get('/generateStatement', [MemberStatementAccountController::class, 'generateStatement'])->name('generateStatement');
      });

      Route::prefix('members')->as('active-members.')->group(function () {
            Route::get('/getStatementOfAccount', [MemberStatementAccountController::class, 'getStatement'])->name('getStatementOfAccount');
            Route::get('/generateStatement', [MemberStatementAccountController::class, 'generateStatement'])->name('generateStatement');
      });

      Route::prefix('members')->as('active-members.')->group(function () {
            Route::get('/getMembershipNoDetail', [MembershipNumberController::class, 'getMembershipNoDetail'])->name('getMembershipNoDetail');
            Route::post('/updateMembershipNo', [MembershipNumberController::class, 'updateMembershipNo'])->name('updateMembershipNo');
      });

      // inActive member registration
      Route::prefix('members/in-active')->as('in-active-members.')->group(function () {
            Route::get('/', [MemberInActiveRegistrationController::class, 'inActiveMembers'])->name('index');
      });
      // inActive member registration route ends

      // List of member users
      Route::prefix('members')->as('members.')->group(function () {
            Route::get('/ordinary-users', [OrdinaryUserController::class, 'ordinaryUsers'])->name('ordinaryUsers');
            Route::get('/subsidiary-users', [SubsidiaryUserController::class, 'subsidiaryUsers'])->name('subsidiaryUsers');
            Route::get('/affiliate-users', [AffiliateUserController::class, 'affiliateUsers'])->name('affiliateUsers');
            Route::get('/associate-users', [AssociateUserController::class, 'associateUsers'])->name('associateUsers');
            Route::get('/youth-users', [YouthUserController::class, 'youthUsers'])->name('youthUsers');
      });

      Route::prefix('official-rep')->as('official-rep.')->group(function () {
            Route::get('/change/requests', [OfficialRepChangeRequestController::class, 'index'])->name('change.requests');
            Route::post('/change/approve', [OfficialRepChangeRequestController::class, 'approve'])->name('change.approve');
            Route::post('/change/reject', [OfficialRepChangeRequestController::class, 'reject'])->name('change.reject');
      });

      Route::prefix('mm-userlists')->as('mm-userlists.')->group(function () {
            Route::get('/', [MemberUserController::class, 'userlists'])->name('userlists');
            Route::post('/change/status', [MemberUserController::class, 'changeStatus'])->name('change-status');
            Route::get('/billing', [MemberBillingController::class, 'billing'])->name('billing');
            Route::get('/inv-view', [MemberBillingController::class, 'invoiceView'])->name('invoice-view');
            Route::get('/send-inv', [MemberBillingController::class, 'sendInvoice'])->name('invoice-send');
      });

      Route::prefix('setting')->as('setting.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/update', [SettingController::class, 'uppdateSetting'])->name('update');
      });

      Route::prefix('dashboard')->as('dashboard.')->group(function () {

      });

      /* Comman Routes */
      Route::group(['prefix' => 'notification'], function () {
      Route::post('/get', [\App\Http\Controllers\backend\MyNotification::class, 'getNotification'])->name('notification.getNotification');
      Route::get('/', [\App\Http\Controllers\backend\MyNotification::class, 'index'])->name('notification.index');
  });

      Route::get('/bulletin', [BulletinController::class, 'index'])->name('bulletin.index');
      Route::get('/annualreport', [AnnualreportController::class, 'index'])->name('annualreport.index');
      Route::get('/choose-company', [ChooseCompanyController::class, 'index'])->name('choosecompant.index');
      Route::post('/save-account', [ChooseCompanyController::class, 'saveAccount'])->name('saveaccount');
      Route::get('user-profile', [ChooseCompanyController::class, 'index'])->name('userprofile');
      Route::get('/membership-certificate', [MembershipCertificateController::class, 'index'])->name('membership-certificate.index');
      Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
      Route::post('/invoice', [InvoiceController::class, 'index'])->name('invoice.indexget');
      Route::get('/invoice-pdf/{id}', [InvoiceController::class, 'invoicePdf'])->name('invoice.pdf');
      Route::get('/pr-invoice-pdf/{id}', [InvoiceController::class, 'prInvoicePdf'])->name('pr-invoice.pdf');
      Route::get('invoice-receipt/{id}', [InvoiceController::class, 'invoiceReceipt'])->name('invoice.receipt');
      Route::get('invoice-c-payment/{id}', [InvoiceController::class, 'invoiceCPayment'])->name('invoice.c-payment');
      Route::get('/branch-annualreport', [BranchAnnualreportController::class, 'index'])->name('branch-annualreport.index');





      Route::get('/statement-of-account', [StatementOfAccountController::class, 'index'])->name('statement-of-account.index');
      Route::get('/statement-of-account/view/{id}', [StatementOfAccountController::class, 'view'])->name('statement-of-account.view');
      Route::get('/statement-of-account/download/{id}', [StatementOfAccountController::class, 'download'])->name('statement-of-account.download');
      Route::get('/companyinfo', [CompanyinfoController::class, 'index'])->name('companyinfo.index');
      Route::post('/companyinfo/update', [CompanyinfoController::class, 'update'])->name('companyinfo.update');
      Route::get('user-profile', [UserprofileController::class, 'index'])->name('userprofile.index');
      Route::post('user-profile/updatemember', [UserprofileController::class, 'updateMember'])->name('userprofile.updatemember');
      Route::post('user-profile/updateadmin', [UserprofileController::class, 'updateadmin'])->name('userprofile.updateadmin');
      Route::get('official-representative', [OfficialRepresentativeController::class, 'index'])->name('official-representative.index');
      Route::post('official-representative/update', [OfficialRepresentativeController::class, 'update'])->name('official-representative.update');
      Route::post('official-representative/new1', [OfficialRepresentativeController::class, 'new1'])->name('official-representative.new1');
      Route::get('alternate-representative', [OfficialRepresentativeController::class, 'alternateIndex'])->name('alternate-representative.index');
      Route::get('/circular', [FrontendCircularcontroller::class, 'index'])->name('circular.index');
      Route::get('branch-newsletter', [BranchNewsletterController::class, 'index'])->name('branch-newsletter.index');
      Route::get('branch-circular', [BranchCircularController::class, 'index'])->name('branch-circular.index');
      Route::get('others', [OthersController::class, 'index'])->name('others.index');
      Route::get('branch-contact-details', [BranchContactDetailsController::class, 'index'])->name('branch.contact.details.index');

});

// Frontend Routes //
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/terms-and-conditions', [App\Http\Controllers\HomeController::class, 'termsAndConditions'])->name('termsAndConditions');

Route::get('/membership', [App\Http\Controllers\HomeController::class, 'membership'])->name('membership');

Route::get('/lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'lang']);

Route::any('/desk-webhook', [App\Http\Controllers\HomeController::class, 'deskLog'])->name('store.log');
