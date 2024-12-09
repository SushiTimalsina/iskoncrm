<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\SewaController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\DevoteesController;
use App\Http\Controllers\Backend\AttendSewaController;
use App\Http\Controllers\Backend\CoursesController;
use App\Http\Controllers\Backend\ActivityLogController;
use App\Http\Controllers\Backend\YatraController;
use App\Http\Controllers\Backend\ImageController;
use App\Http\Controllers\Backend\AttendCourseController;
use App\Http\Controllers\Backend\DonationController;
use App\Http\Controllers\Backend\CourseRegController;
use App\Http\Controllers\Backend\InboxController;
use App\Http\Controllers\Backend\MentorController;
use App\Http\Controllers\Backend\InitiativeGuruController;
use App\Http\Controllers\Backend\CourseTakenController;
use App\Http\Controllers\Backend\InitiativeController;
use App\Http\Controllers\Backend\InitiationFilesController;
use App\Http\Controllers\Backend\OccupationController;
use App\Http\Controllers\Backend\SkillsController;
use App\Http\Controllers\Backend\DevoteeSkillsController;
use App\Http\Controllers\Backend\CourseFacilitatorController;
use App\Http\Controllers\Backend\CourseBatchController;
use App\Http\Controllers\Backend\CourseBatchDevoteeController;
use App\Http\Controllers\Backend\YatraChildAdultController;
use App\Http\Controllers\Backend\YatraCategoryController;
use App\Http\Controllers\Backend\YatraSeasonController;
use App\Http\Controllers\Backend\YatraDocumentsController;
use App\Http\Controllers\Backend\ChangelogController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Backend\Auth\AdminResetPasswordController;
use App\Http\Controllers\Backend\Auth\AdminLoginController;
use App\Http\Controllers\Backend\PasswordController;
use App\Http\Controllers\Backend\GuestTakeCareController;
use App\Http\Controllers\Backend\SewaSankalpaController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\UserDashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
  return view('welcome');
});
Auth::routes(['register' => false, 'reset' => true, 'login' => true]);
Route::get('/password/change/otp', [PasswordController::class, 'showOTPForm'])->name('password.change.otp');
Route::post('/password/change/otp', [PasswordController::class, 'verifyOTP'])->name('password.verify.otp');
Route::get('/password/change', [PasswordController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/password/change', [PasswordController::class, 'updatePassword'])->name('password.update');

Route::group(['middleware' => ['auth:user', 'password.change.otp']], function () {
  Route::get('user-dashboard', [UserDashboardController::class, 'userdashboard'])->name('userdashboard');
  Route::get('sewa-user-dashboard', [UserDashboardController::class, 'sewadashboard'])->name('sewadashboard');
  Route::get('course-user-dashboard', [UserDashboardController::class, 'coursedashboard'])->name('coursedashboard');
  Route::get('donation-user-dashboard', [UserDashboardController::class, 'donationdashboard'])->name('donationdashboard');

  Route::post('logout', [UserDashboardController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->group(function () {
  //Route::get('/', function () { return view('backend.welcome');});
  Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
  Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
  Route::post('login', [AdminAuthController::class, 'login']);
  Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
  // Admin Forgot Password Routes...
  Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
  Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

  // Admin Reset Password Routes...
  Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
  Route::post('password/reset', [AdminResetPasswordController::class, 'reset'])->name('admin.password.update');

  Route::middleware('auth:admin')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resources([
      'roles' => RoleController::class,
      'users' => UserController::class,
      'admins' => AdminController::class,
      'department' => DepartmentController::class,
      'sewa' => SewaController::class,
      'branch' => BranchController::class,
      'devotees' => DevoteesController::class,
      'yatra' => YatraController::class,
      'yatra-category' => YatraCategoryController::class,
      'yatra-child-adult' => YatraChildAdultController::class,
      'yatra-season' => YatraSeasonController::class,
      'yatra-documents' => YatraDocumentsController::class,
      'course-attend' => AttendCourseController::class,
      'sewa-attend' => AttendSewaController::class,
      'courses' => CoursesController::class,
      'course-facilitator' => CourseFacilitatorController::class,
      'course-batch' => CourseBatchController::class,
      'course-batch-devotee' => CourseBatchDevoteeController::class,
      'activity-logs' => ActivityLogController::class,
      'initiation-files' => InitiationFilesController::class,
      'skills' => SkillsController::class,
      'devotee-skills' => DevoteeSkillsController::class,
      'occupations' => OccupationController::class,
      'initiative-guru' => InitiativeGuruController::class,
      'course-taken' => CourseTakenController::class,
      'mentor' => MentorController::class,
      'course-register' => CourseRegController::class,
      'donation' => DonationController::class,
      'initiation' => InitiativeController::class,
      'changelog' => ChangelogController::class,
      'guest-take-care' => GuestTakeCareController::class,
      'sewa-sankalpa' => SewaSankalpaController::class,
    ]);

    Route::get('/user-search', [UserController::class, 'searchfilter'])->name('usersearch');
    Route::get('/changelog-view', [ChangelogController::class, 'viewpage'])->name('changelogview');
    Route::get('/admin-search', [AdminController::class, 'searchfilter'])->name('adminsearch');
    Route::post('users/{id}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
    Route::post('admins/{id}/update-password', [AdminController::class, 'updatePassword'])->name('admins.updatePassword');
    Route::post('devotees/stepone', [DevoteesController::class, 'posdevoteesearch'])->name('posdevoteesearch');
    Route::get('/devotee-create-step-two', [DevoteesController::class, 'createStepTwo'])->name('devotee.create.step.two');
    Route::get('devotees-csv-import', [DevoteesController::class, 'devoteeimportget'])->name('devoteesimportget');
    //Route::get('/enc', [DevoteesController::class, 'encryptdata']);
    //Route::get('/adminenc', [AdminController::class, 'encryptdata']);
    //Route::get('/userenc', [UserController::class, 'encryptdata']);
    Route::post('devotees-csv-import-submit', [DevoteesController::class, 'devoteeimport'])->name('devoteesimport');
    Route::get('/devotee-profile-image/{id}', [DevoteesController::class, 'profileimage'])->name('profileimage');
    Route::post('/devotee-profile-image-upload/{id}', [DevoteesController::class, 'profileimageupdate'])->name('profileimageupdate');
    Route::get('/devotee-qr-scan', [DevoteesController::class, 'devoteeqrscan'])->name('devoteeqrscan');
    Route::post('devotees/inititaion/{id}', [DevoteesController::class, 'initiationadd'])->name('devotees.initiationadd');
    Route::post('devotees/initiation/{id}', [DevoteesController::class, 'initiationupdate'])->name('devotees.initiationupdate');
    Route::post('devotees/initiation/{id}', [DevoteesController::class, 'initiationdelete'])->name('devotees.initiationdelete');
    Route::get('/devotee-search', [DevoteesController::class, 'searchfilter'])->name('devoteesearch');
    Route::get('/devotee-user-sync', [DevoteesController::class, 'usersync'])->name('devoteeusersync');
    Route::post('/searchbyid', [DevoteesController::class, 'searchbyid'])->name('searchbyid');
    Route::post('/searchbyqrid', [DevoteesController::class, 'searchbyqrid'])->name('searchbyqrid');
    Route::get('devotee_excel_export', [DevoteesController::class, 'devotee_excel_export'])->name('devotee.excel.export');
    Route::post('/mentorupdate/{id}', [DevoteesController::class, 'mentorupdate'])->name('mentorupdate');
    Route::post('/devotee-relation-store', [DevoteesController::class, 'devoteerelationstore'])->name('devoteerelationstore');
    Route::get('/devotee-relation/{id}', [DevoteesController::class, 'createrelation'])->name('devotee.relation');
    Route::get('/service-attendence-search', [AttendSewaController::class, 'searchfilter'])->name('attendsewasearch');
    Route::post('/getattendance', [AttendCourseController::class, 'getattendance'])->name('getattendancepost');
    Route::post('/attendmarks', [AttendCourseController::class, 'attendmarks'])->name('attendmarks');
    Route::get('/course-facilitator-serach', [CourseFacilitatorController::class, 'searchfilter'])->name('coursefacilitatorsearch');
    Route::get('activity-logs-delete',  [ActivityLogController::class, 'destroyall'])->name('activity-logs-delete');
    Route::get('/activity-search', [ActivityLogController::class, 'searchfilter'])->name('activitysearch');
    Route::get('/initiationfile/{imageName}', [ImageController::class, 'initiationfile'])->name('initiationfile.show');
    Route::get('/devoteephotos/{imageName}', [ImageController::class, 'devoteephoto'])->name('devoteephoto.show');
    Route::get('/devoteeid/{imageName}', [ImageController::class, 'devoteeid'])->name('devoteeid.show');
    Route::get('/coursephoto/{imageName}', [ImageController::class, 'coursephoto'])->name('coursephoto.show');
    Route::get('/certificate/{imageName}', [ImageController::class, 'certificate'])->name('certificate.show');
    Route::get('/devoteeimport/{imageName}', [ImageController::class, 'devoteeimport'])->name('devoteeimport.show');
    Route::get('/yatraimport/{imageName}', [ImageController::class, 'yatrafile'])->name('yatraimport.show');
    Route::get('certificate-pdf/{id}', [CourseBatchController::class, 'generatePDF'])->name('certificatepdf');
    Route::post('initiation/stepone', [InitiativeController::class, 'postfirstform'])->name('postfirstform');
    Route::get('initiation-create-step-two', [InitiativeController::class, 'createStepTwo'])->name('initiation.create.step.two');
    Route::get('/initiation-search', [InitiativeController::class, 'searchfilter'])->name('initiationsearch');
    Route::post('course-donation', [DonationController::class, 'coursedonationstore'])->name('coursedonationstore');
    Route::get('/donation-search', [DonationController::class, 'searchfilter'])->name('donationsearch');
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');
    Route::get('/mentor-search', [MentorController::class, 'searchfilter'])->name('mentorsearch');
    Route::get('/course-taken-search', [CourseTakenController::class, 'searchfilter'])->name('coursetakensearch');

    Route::get('/branch-move-to-trash/{id}', [BranchController::class, 'movetotrash'])->name('branchmovetotrash');
    Route::get('/branch-restore/{id}', [BranchController::class, 'restore'])->name('branchrestore');
    Route::get('/branch-trash', [BranchController::class, 'trash'])->name('branchtrash');
    Route::get('/skill-move-to-trash/{id}', [SkillsController::class, 'movetotrash'])->name('skillmovetotrash');
    Route::get('/skill-restore/{id}', [SkillsController::class, 'restore'])->name('skillrestore');
    Route::get('/skill-trash', [SkillsController::class, 'trash'])->name('skilltrash');
    Route::get('/skills-search', [SkillsController::class, 'searchfilter'])->name('skillssearch');
    Route::get('/occupation-move-to-trash/{id}', [OccupationController::class, 'movetotrash'])->name('occupationmovetotrash');
    Route::get('/occupation-restore/{id}', [OccupationController::class, 'restore'])->name('occupationrestore');
    Route::get('/occupation-trash', [OccupationController::class, 'trash'])->name('occupationtrash');
    Route::get('/occupation-search', [OccupationController::class, 'searchfilter'])->name('occupationsearch');
    Route::get('/course-move-to-trash/{id}', [CoursesController::class, 'movetotrash'])->name('coursemovetotrash');
    Route::get('/course-restore/{id}', [CoursesController::class, 'restore'])->name('courserestore');
    Route::get('/course-trash', [CoursesController::class, 'trash'])->name('coursetrash');
    Route::get('/department-move-to-trash/{id}', [DepartmentController::class, 'movetotrash'])->name('departmentmovetotrash');
    Route::get('/department-restore/{id}', [DepartmentController::class, 'restore'])->name('departmentrestore');
    Route::get('/department-trash', [DepartmentController::class, 'trash'])->name('departmenttrash');
    Route::get('/course-facilitator-move-to-trash/{id}', [CourseFacilitatorController::class, 'movetotrash'])->name('coursefacilitatormovetotrash');
    Route::get('/course-facilitator-restore/{id}', [CourseFacilitatorController::class, 'restore'])->name('coursefacilitatorrestore');
    Route::get('/course-facilitator-trash', [CourseFacilitatorController::class, 'trash'])->name('coursefacilitatortrash');
    Route::get('/course-batch-move-to-trash/{id}', [CourseBatchController::class, 'movetotrash'])->name('coursebatchmovetotrash');
    Route::get('/course-batch-restore/{id}', [CourseBatchController::class, 'restore'])->name('coursebatchrestore');
    Route::get('/course-batch-trash', [CourseBatchController::class, 'trash'])->name('coursebatchtrash');
    Route::get('/mentor-move-to-trash/{id}', [MentorController::class, 'movetotrash'])->name('mentormovetotrash');
    Route::get('/mentor-restore/{id}', [MentorController::class, 'restore'])->name('mentorrestore');
    Route::get('/mentor-trash', [MentorController::class, 'trash'])->name('mentortrash');
    Route::get('/initiative-guru-move-to-trash/{id}', [InitiativeGuruController::class, 'movetotrash'])->name('initiativegurumovetotrash');
    Route::get('/initiative-guru-restore/{id}', [InitiativeGuruController::class, 'restore'])->name('initiativegururestore');
    Route::get('/initiative-guru-trash', [InitiativeGuruController::class, 'trash'])->name('initiativegurutrash');
    Route::get('/initiation-move-to-trash/{id}', [InitiativeController::class, 'movetotrash'])->name('initiationmovetotrash');
    Route::get('/initiation-restore/{id}', [InitiativeController::class, 'restore'])->name('initiationrestore');
    Route::get('/initiation-trash', [InitiativeController::class, 'trash'])->name('initiationtrash');
    Route::post('/activity-logs-destroy-selected', [ActivityLogController::class, 'destroyselected'])->name('activitylogsdestroyselected');
    Route::get('/sewa-move-to-trash/{id}', [SewaController::class, 'movetotrash'])->name('sewamovetotrash');
    Route::get('/sewa-restore/{id}', [SewaController::class, 'restore'])->name('sewarestore');
    Route::get('/sewa-trash', [SewaController::class, 'trash'])->name('sewatrash');
    Route::get('/donation-move-to-trash/{id}', [DonationController::class, 'movetotrash'])->name('donationmovetotrash');
    Route::get('/donation-restore/{id}', [DonationController::class, 'restore'])->name('donationrestore');
    Route::get('/donation-trash', [DonationController::class, 'trash'])->name('donationtrash');
    Route::get('/sewa-attend-move-to-trash/{id}', [AttendSewaController::class, 'movetotrash'])->name('sewaattendmovetotrash');
    Route::get('/sewa-attend-restore/{id}', [AttendSewaController::class, 'restore'])->name('sewaattendrestore');
    Route::get('/sewa-attend-trash', [AttendSewaController::class, 'trash'])->name('sewaattendtrash');
    Route::get('/devotee-move-to-trash/{id}', [DevoteesController::class, 'movetotrash'])->name('devoteemovetotrash');
    Route::get('/devotee-restore/{id}', [DevoteesController::class, 'restore'])->name('devoteerestore');
    Route::get('/devotee-trash', [DevoteesController::class, 'trash'])->name('devoteetrash');
    Route::get('/guest-take-care-move-to-trash/{id}', [GuestTakeCareController::class, 'movetotrash'])->name('guesttakecaremovetotrash');
    Route::get('/guest-take-care-restore/{id}', [GuestTakeCareController::class, 'restore'])->name('guesttakecarerestore');
    Route::get('/guest-take-care-trash', [GuestTakeCareController::class, 'trash'])->name('guesttakecaretrash');
    Route::get('/guest-take-care-search', [GuestTakeCareController::class, 'searchfilter'])->name('guesttakecaresearch');
    Route::get('/sewasankalpa-move-to-trash/{id}', [SewaSankalpaController::class, 'movetotrash'])->name('sewasankalpamovetotrash');
    Route::get('/sewasankalpa-restore/{id}', [SewaSankalpaController::class, 'restore'])->name('sewasankalparestore');
    Route::get('/sewasankalpa-trash', [SewaSankalpaController::class, 'trash'])->name('sewasankalpatrash');

    Route::get('/course-cateogry-move-to-trash/{id}', [CoursesController::class, 'movetotrash'])->name('coursecategorymovetotrash');
    Route::get('/course-category-restore/{id}', [CoursesController::class, 'restore'])->name('coursecategoryrestore');
  });
});
