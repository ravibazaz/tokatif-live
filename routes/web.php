<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// for admin url



Route::namespace('Admin')->prefix('admin')->group(function () { 
    Route::get('/', 'AuthController@login')->name('admin');
    Route::post('/login', 'AuthController@verify_login')->name('admin-login');
    Route::get('/signin', 'AuthController@log')->name('signin');

    Route::get('/forgotpassword', 'AuthController@forgotPassword')->name('admin-forgot-password');
    Route::post('/forgotpassword','AuthController@sendForgotPassword')->name('admin-send-forgot-password');
    Route::get('/reset-password','AuthController@resetPassword')->name('admin-reset-password');
    
    
    
    
    Route::middleware(['isAdminAuthenticated', 'cors'])->group(function(){
        
        Route::get('/dashboard', 'HomeController@index')->name('admin-dashboard');
        
        Route::get('/teachers', 'TeacherController@index')->name('admin-teacher-list');
        Route::post('/teachers', 'TeacherController@index')->name('admin-teacher-search');
        Route::get('/teacher/{id}', 'TeacherController@details')->name('admin-teacher-details');
        Route::get('/teacher/delete/{id}', 'TeacherController@delete')->name('admin-teacher-delete');
        Route::get('/teacher/approve/{id}', 'TeacherController@approve_teacher')->name('admin-teacher-approve');
        
        
        Route::get('/students', 'StudentController@index')->name('admin-student-list');
        Route::post('/students', 'StudentController@index')->name('admin-student-search');
        Route::get('/student/{id}', 'StudentController@details')->name('admin-student-details');
        Route::get('/student/delete/{id}', 'StudentController@delete')->name('admin-student-delete');
        
        
        
        
        Route::get('/website-setting/{id}', 'WebsiteSettingController@edit')->name('admin-website-setting-edit');
        Route::post('/website-setting/{id}', 'WebsiteSettingController@edit')->name('admin-website-setting-update');
        Route::get('/website-setting', 'WebsiteSettingController@index')->name('admin-website-setting-list');;
        
        
        
        Route::get('/home-banner/add', 'HomeBannerController@add')->name('admin-home-banner-add');
        Route::post('/home-banner/add', 'HomeBannerController@add')->name('admin-home-banner-insert'); 
        Route::get('/home-banner/{id}', 'HomeBannerController@edit')->name('admin-home-banner-edit');
        Route::post('/home-banner/{id}', 'HomeBannerController@edit')->name('admin-home-banner-update');
        Route::get('/home-banner/delete/{id}', 'HomeBannerController@delete')->name('admin-home-banner-delete');
        Route::get('/home-banners', 'HomeBannerController@list')->name('admin-home-banner-list');
        Route::post('/home-banners', 'HomeBannerController@list')->name('admin-home-banner-search');
        


        Route::get('/language/add', 'LanguageController@add')->name('admin-language-add');
        Route::post('/language/add', 'LanguageController@add')->name('admin-language-insert'); 
        Route::get('/language/{id}', 'LanguageController@edit')->name('admin-language-edit');
        Route::post('/language/{id}', 'LanguageController@edit')->name('admin-language-update');
        Route::get('/language/delete/{id}', 'LanguageController@delete')->name('admin-language-delete');
        Route::get('/languages', 'LanguageController@list')->name('admin-language-list');
        Route::post('/languages', 'LanguageController@list')->name('admin-language-search');
        
        
        
        Route::get('/whylearn/add', 'WhylearnController@add')->name('admin-whylearn-add');
        Route::post('/whylearn/add', 'WhylearnController@add')->name('admin-whylearn-insert'); 
        Route::get('/whylearn/{id}', 'WhylearnController@edit')->name('admin-whylearn-edit');
        Route::post('/whylearn/{id}', 'WhylearnController@edit')->name('admin-whylearn-update');
        Route::get('/whylearn/delete/{id}', 'WhylearnController@delete')->name('admin-whylearn-delete');
        Route::get('/whylearn', 'WhylearnController@list')->name('admin-whylearn-list');
        Route::post('/whylearn', 'WhylearnController@list')->name('admin-whylearn-search');
        
        
        
        Route::get('/whytech/add', 'WhytechController@add')->name('admin-whytech-add');
        Route::post('/whytech/add', 'WhytechController@add')->name('admin-whytech-insert'); 
        Route::get('/whytech/{id}', 'WhytechController@edit')->name('admin-whytech-edit');
        Route::post('/whytech/{id}', 'WhytechController@edit')->name('admin-whytech-update');
        Route::get('/whytech/delete/{id}', 'WhytechController@delete')->name('admin-whytech-delete');
        Route::get('/whytech', 'WhytechController@list')->name('admin-whytech-list');
        Route::post('/whytech', 'WhytechController@list')->name('admin-whytech-search');
        
        
        
        Route::get('/howitworks/add', 'HowitworksController@add')->name('admin-howitworks-add');
        Route::post('/howitworks/add', 'HowitworksController@add')->name('admin-howitworks-insert'); 
        Route::get('/howitworks/{id}', 'HowitworksController@edit')->name('admin-howitworks-edit');
        Route::post('/howitworks/{id}', 'HowitworksController@edit')->name('admin-howitworks-update');
        Route::get('/howitworks/delete/{id}', 'HowitworksController@delete')->name('admin-howitworks-delete');
        Route::get('/howitworks', 'HowitworksController@list')->name('admin-howitworks-list');
        Route::post('/howitworks', 'HowitworksController@list')->name('admin-howitworks-search');
        
        
        Route::get('/becomefluentin/add', 'BecomefluentinController@add')->name('admin-becomefluentin-add');
        Route::post('/becomefluentin/add', 'BecomefluentinController@add')->name('admin-becomefluentin-insert'); 
        Route::get('/becomefluentin/{id}', 'BecomefluentinController@edit')->name('admin-becomefluentin-edit');
        Route::post('/becomefluentin/{id}', 'BecomefluentinController@edit')->name('admin-becomefluentin-update');
        Route::get('/becomefluentin/delete/{id}', 'BecomefluentinController@delete')->name('admin-becomefluentin-delete');
        Route::get('/becomefluentin', 'BecomefluentinController@list')->name('admin-becomefluentin-list');
        Route::post('/becomefluentin', 'BecomefluentinController@list')->name('admin-becomefluentin-search');
        
        
        
        Route::get('/article/add', 'ArticleController@add')->name('admin-article-add');
        Route::post('/article/add', 'ArticleController@add')->name('admin-article-insert'); 
        Route::get('/article/{id}', 'ArticleController@edit')->name('admin-article-edit');
        Route::post('/article/{id}', 'ArticleController@edit')->name('admin-article-update');
        Route::get('/article/approve/{id}', 'ArticleController@approve')->name('admin-article-approve');
        Route::get('/article/reject/{id}', 'ArticleController@reject')->name('admin-article-reject');
        Route::get('/article/delete/{id}', 'ArticleController@delete')->name('admin-article-delete');
        Route::get('/articles', 'ArticleController@list')->name('admin-article-list');
        Route::post('/articles', 'ArticleController@list')->name('admin-article-search');
        
        
        Route::get('/support/add', 'SupportController@add')->name('admin-support-add');
        Route::post('/support/add', 'SupportController@add')->name('admin-support-insert'); 
        Route::get('/support/{id}', 'SupportController@edit')->name('admin-support-edit');
        Route::post('/support/{id}', 'SupportController@edit')->name('admin-support-update');
        Route::get('/support/delete/{id}', 'SupportController@delete')->name('admin-support-delete');
        Route::get('/support', 'SupportController@list')->name('admin-support-list');
        Route::post('/support', 'SupportController@list')->name('admin-support-search');

        
        Route::get('/logout','AuthController@logout')->name('admin-logout');
    });

});



Route::get('/', 'HomeController@index');

// Login
Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login', 'LoginController@login')->name('post-login-data');
Route::get('/logout','DashboardController@logout')->name('logout');

Route::get('/teacher-registration', 'RegistrationController@teacher_registration')->name('create-teacher-account');
Route::post('/teacher-registration', 'RegistrationController@teacher_registration')->name('post-teacher-data'); 

Route::get('/teachers', 'SearchController@getAllTeachers')->name('teachers');
Route::post('/post-teacher-search','SearchController@teachers_search')->name('post-teacher-search');
Route::get('/teachers/{language}','SearchController@get_teacher_search')->name('teacher-search');
Route::get('/teacher/{id}','SearchController@get_teacher_detail')->name('teacher-detail');



Route::get('/register', 'RegistrationController@index')->name('create-account');
Route::post('/registeruser', 'RegistrationController@registeruser')->name('register-user');
Route::post('/sendcode', 'RegistrationController@authorisationcode')->name('send-authorisationcode');
Route::post('/verifycode', 'RegistrationController@authorisationcode_check')->name('verify-authorisationcode');

Route::post('/registeruserphone', 'RegistrationController@registeruserphone')->name('register-user-phone');
Route::post('/sendcodephone', 'RegistrationController@authorisationcodephone')->name('send-authorisationcode-phone');
Route::post('/verifycodephone', 'RegistrationController@authorisationcode_checkphone')->name('verify-authorisationcodephone');

Route::get('/forgot-password', 'HomeController@forgot_password')->name('forgot-password'); 
Route::post('/forgot-password', 'HomeController@forgot_password')->name('post-forgot-password-data');
Route::get('/reset-password/{q}','HomeController@resetPassword')->name('reset-password');
Route::post('/reset-password/{q}','HomeController@resetPassword')->name('post-reset-password');

Route::post('/newsletter-email', 'HomeController@newsletter_email')->name('newsletter-email'); 

Route::get('/community', 'CommunityController@index')->name('community');
Route::get('/community/{id}','CommunityController@get_community_detail')->name('community-detail');
Route::get('/add-community', 'CommunityController@add')->name('add-community');
Route::post('/community/insert', 'CommunityController@add')->name('post-community-data');

Route::get('/support','SupportController@index')->name('support');



// Chat message & post comments
Route::middleware(['isUserAuthenticated', 'cors'])->group(function(){
    Route::get('/list', 'ChatController@index')->name('message-list');
    Route::get('/message/{receiver_id}', 'ChatController@getMessage')->name('message-detail');
    Route::post('message', 'ChatController@sendMessage')->name('post-message');
    Route::post('/chat-file/{receiver_id}', 'ChatController@sendFile')->name('post-chat-file'); 
    Route::get('/search-chat-user/{search}', 'ChatController@chat_user_search')->name('search-chat-user'); 

    Route::get('/messages', 'ChatController@index')->name('messages');
    
    Route::post('/post-article-comments', 'CommunityController@post_comments')->name('post-article-comments');
    Route::get('/unblock-user/{id}', 'DashboardController@unblock_user')->name('unblock-user'); 
    
    Route::get('/stripe', 'StripePaymentController@stripe')->name('stripe'); 
    Route::post('/stripe-post', 'StripePaymentController@stripePost')->name('stripe-post'); 
    Route::post('/stripe', 'StripePaymentController@stripeCreditPost')->name('stripe.credit.post'); 
    
    Route::get('/my-lesson', 'LessonController@my_lesson')->name('my-lesson'); 
    Route::get('/lesson-detail/{id}','LessonController@get_lesson_detail')->name('lesson-detail');
    Route::get('/change-lesson-date/{id}','LessonController@change_lesson_date')->name('change-lesson-date');
    Route::post('/post-new-lesson-date','LessonController@update_new_lesson_date')->name('post-new-lesson-date'); 
    Route::get('/change-lesson-completion-time/{id}','LessonController@update_lesson_completion_time')->name('change-lesson-completion-time'); 
    
    

});



Route::middleware(['isStudentAuthenticated', 'cors'])->group(function(){
    Route::get('/student-dashboard', 'DashboardController@index')->name('student-dashboard');
    Route::get('/student-profile', 'DashboardController@profile')->name('student-profile');
    Route::get('/student-profile-edit', 'DashboardController@edit_profile')->name('student-profile-edit');
    Route::post('/basic-info-update', 'DashboardController@basic_info_update')->name('basic-info-update');
    Route::post('/communication-tool-update', 'DashboardController@communication_tool_update')->name('communication-tool-update');
    Route::post('/introduction-update', 'DashboardController@introduction_update')->name('introduction-update');
    Route::post('/languages-update', 'DashboardController@languages_update')->name('languages-update'); 
    Route::get('/student-wallet', 'DashboardController@wallet')->name('student-wallet');
    Route::post('/student-wallet-update', 'DashboardController@wallet')->name('student-wallet-update');
    Route::post('/favorite-teacher', 'DashboardController@my_favorite_teacher')->name('favorite-teacher');  
    Route::get('/add-credit', 'DashboardController@add_credit')->name('add-credit');  
    
    Route::get('/student-calendar', 'CalendarController@student_calendar')->name('student-calendar'); 
    
    
    Route::get('/student-settings', 'SettingsController@settings_update')->name('student-settings');
    Route::post('/student-settings-update', 'SettingsController@settings_update')->name('student-settings-update'); 
    Route::post('/password-update', 'SettingsController@password_update')->name('password-update');
    
    
    Route::post('/lesson-packages', 'BookingController@ajax_lesson_packages')->name('lesson-packages'); 
    Route::get('/lesson-booking/{id}', 'BookingController@lesson_booking')->name('lesson-booking');
    Route::get('/fetch-communication-tool-account-id/{accID}', 'BookingController@fetch_communication_tool_accountID');  
    Route::get('/fetch-package-price/{lesson_package_id}', 'BookingController@fetch_package_price');  
    Route::post('/booking-data', 'BookingController@insert_booking_data')->name('booking-data');
    Route::get('/feedback/{id}', 'BookingController@give_feedback')->name('feedback');   
    Route::post('/feedback/{id}', 'BookingController@give_feedback')->name('feedback-post');   
    
    Route::get('/accept-lesson/{id}', 'LessonController@accept_lesson')->name('student-accept-lesson'); 
    Route::get('/decline-lesson/{id}', 'LessonController@decline_lesson')->name('student-decline-lesson'); 
    Route::get('/student-enter-classroom/{id}', 'LessonController@enter_classroom')->name('student-enter-classroom');  
    Route::get('/accept-lesson-invitation/{id}', 'LessonController@accept_lesson_invitation')->name('student-accept-lesson-invitation'); 
    Route::get('/decline-lesson-invitation/{id}', 'LessonController@decline_lesson_invitation')->name('student-decline-lesson-invitation'); 
    
    Route::get('/switch-to-teacher-mode', 'DashboardController@switch_to_teacher_mode')->name('switch-to-teacher-mode'); 
    
});

Route::middleware(['isTeacherAuthenticated', 'cors'])->group(function(){
    Route::get('/teacher-dashboard', 'DashboardController@index')->name('teacher-dashboard');
    
    Route::get('/teacher-profile', 'DashboardController@profile')->name('teacher-profile');
    Route::get('/teacher-profile-edit', 'DashboardController@edit_profile')->name('teacher-profile-edit');
    Route::post('/teacher-basic-info-update', 'DashboardController@basic_info_update')->name('teacher-basic-info-update');
    Route::post('/teacher-communication-tool-update', 'DashboardController@communication_tool_update')->name('teacher-communication-tool-update');
    Route::post('/teacher-introduction-update', 'DashboardController@introduction_update')->name('teacher-introduction-update');
    Route::post('/teacher-languages-update', 'DashboardController@languages_update')->name('teacher-languages-update');
    Route::get('/my-students', 'DashboardController@my_students')->name('my-students');  
    Route::get('/block-student/{id}', 'DashboardController@block_student')->name('block-student'); 
    Route::get('/my-wallet', 'DashboardController@my_wallet')->name('my-wallet'); 
    
    Route::get('/teacher-settings', 'SettingsController@settings_update')->name('teacher-settings');
    Route::post('/teacher-settings-update', 'SettingsController@settings_update')->name('teacher-settings-update'); 
    Route::post('/teacher-password-update', 'SettingsController@password_update')->name('teacher-password-update'); 
    Route::post('/teacher-video-update', 'SettingsController@video_update')->name('teacher-video-update'); 
    Route::post('/teacher-availability-settings-update', 'SettingsController@teacher_availability_settings_update')->name('teacher-availability-settings-update');  
    Route::post('/teacher-booking-settings-update', 'SettingsController@teacher_booking_settings_update')->name('teacher-booking-settings-update');  
    Route::post('/teacher-education-update', 'SettingsController@teacher_education_update')->name('teacher-education-update');  
    Route::post('/teacher-work-exp-update', 'SettingsController@teacher_work_exp_update')->name('teacher-work-exp-update');   
    Route::post('/teacher-certificate-update', 'SettingsController@teacher_certificate_update')->name('teacher-certificate-update');   
    
    Route::get('/add-lesson', 'LessonController@add_lesson')->name('add-lesson');
    Route::post('/post-lesson-data', 'LessonController@add_lesson')->name('post-lesson-data');
    Route::get('/add-lesson/ajax/{category}',array('as'=>'add_lesson.ajax','uses'=>'LessonController@categoryWiseTagAjax')); 
    Route::post('/send-lesson-invitation', 'LessonController@send_lesson_invitation')->name('send-lesson-invitation');
    //Route::get('/fetch-communication-tool/{id}', 'LessonController@fetch_communication_tool')->name('fetch-communication-tool'); 
    //Route::get('/fetch-communication-tool-id/{id}', 'LessonController@fetch_communication_tool_id')->name('fetch-communication-tool-id');
    Route::get('/fetch-lesson-packages/{id}', 'LessonController@fetch_lesson_packages')->name('fetch-lesson-packages');
    Route::get('/fetch-lesson-name/{id}', 'LessonController@fetch_lesson_name')->name('fetch-lesson-name');
    Route::get('/fetch-student-purchased-packages/{studentID}/{invitationType}', 'LessonController@fetch_student_purchased_packages')->name('fetch-student-purchased-packages');
    Route::get('/fetch-student-purchased-timing/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_timing')->name('fetch-student-purchased-timing');
    Route::get('/fetch-student-purchased-date/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_date')->name('fetch-student-purchased-date');
    Route::get('/fetch-student-purchased-communication-tool/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_communication_tool')->name('fetch-student-purchased-communication-tool');
    Route::get('/fetch-student-purchased-communication-tool-id/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_communication_tool_id')->name('fetch-student-purchased-communication-tool-id');
    Route::get('/fetch-student-purchased-amount/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_amount')->name('fetch-student-purchased-amount');
    Route::get('/fetch-student-purchased-language/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_language')->name('fetch-student-purchased-language');
    Route::get('/fetch-student-purchased-lesson/{studentID}/{packageID}', 'LessonController@fetch_student_purchased_lesson')->name('fetch-student-purchased-lesson');
    
    
    Route::get('/lesson-management', 'LessonController@lesson_management')->name('lesson-management'); 
    Route::get('/lesson/delete/{id}', 'LessonController@delete_lesson')->name('teacher-lesson-delete'); 
    Route::post('/fetch-lesson-detail', 'LessonController@lesson_detail')->name('fetch-lesson-detail'); 
    Route::get('/lesson-package', 'LessonController@lesson_packages')->name('lesson-package'); 
    
    Route::get('/accept-lesson/{id}', 'LessonController@accept_lesson')->name('teacher-accept-lesson'); 
    Route::get('/decline-lesson/{id}', 'LessonController@decline_lesson')->name('teacher-decline-lesson'); 
    Route::get('/enter-classroom/{id}', 'LessonController@enter_classroom')->name('teacher-enter-classroom');  
    
    
    Route::get('/teacher-calendar', 'CalendarController@teacher_calendar')->name('teacher-calendar'); 
    Route::get('/view-calendar', 'CalendarController@teacher_view_calendar')->name('view-calendar'); 
    Route::post('/add-teacher-time-slot', 'CalendarController@add_teacher_time_slot')->name('add-teacher-time-slot');
    Route::post('/delete-teacher-time-slot', 'CalendarController@delete_teacher_time_slot')->name('delete-teacher-time-slot'); 
    Route::get('/time-slot/{selectedDate}', 'CalendarController@get_time_slot')->name('time-slot');  
    
    Route::get('/switch-to-student-mode', 'DashboardController@switch_to_student_mode')->name('switch-to-student-mode');  
    
});














