<?php

use Illuminate\Support\Facades\Route;
// use Mail;

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

Route::get('/', function () {
    return view('front.dashboard');
});

Route::get('user/login', [App\Http\Controllers\Auth\LoginController::class, 'login_view'])->name('front.login');

// Route::get('user/login', function () {
//     if(isset(Auth::user()->id)){
//         return view('front.login');
//     }else{
//         return view('front.dashboard');
//     }
// })->name('front.login');

Route::get('mail-temp', function () {
    return view('email.new-website-launch-at-latogo');
});

//email
Route::get('authorized/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle']);
Route::get('authorized/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
//facebook
Route::get('/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectFacebook']);
Route::get('/callback', [App\Http\Controllers\Auth\LoginController::class, 'facebookCallback']);

Route::post('doUsrlgn', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('user.dologin');
Route::post('doAdmlgn', [App\Http\Controllers\Auth\admin\LoginController::class, 'login'])->name('admin.dologin');

Auth::routes();

Route::get('admin/login', [App\Http\Controllers\Auth\admin\LoginController::class, 'login_view'])->name('admin.login');

Route::get('teacher/register', [App\Http\Controllers\front\teacher\HomeController::class, 'create'])->name('teacher.create');
Route::post('teacher/register', [App\Http\Controllers\front\teacher\HomeController::class, 'store'])->name('teacher.store');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['Admin']], function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('calendar/{id}', [App\Http\Controllers\admin\TeacherController::class, 'calendar'])->name('calendar');
    Route::post('/availability-update/{id}', [App\Http\Controllers\admin\TeacherController::class,'availabilityUpdate'])->name('availability.update');

    Route::post('/status-action', [App\Http\Controllers\admin\AjaxController::class, 'setStatusAction'])->name('status-action');
    Route::post('/delete-action', [App\Http\Controllers\admin\AjaxController::class, 'setDeleteAction'])->name('delete-action');
    Route::post('/pureDelete', [App\Http\Controllers\admin\AjaxController::class, 'pureDelete'])->name('pureDelete');

    Route::get('/home', [App\Http\Controllers\admin\HomeController::class, 'index'])->name('home');
    Route::get('/logout', [App\Http\Controllers\Auth\admin\LoginController::class, 'logout'])->name('logout');
    Route::get('banner/index', function () {
        return view('admin.banner.create');
    });

    Route::get('/banner', [App\Http\Controllers\admin\BannerController::class, 'index'])->name('banner');
    Route::match(['get', 'post'], '/banner/create', [App\Http\Controllers\admin\BannerController::class, 'create'])->name('banner.create');
    Route::match(['get', 'post'], '/banner/edit/{id}', [App\Http\Controllers\admin\BannerController::class, 'edit'])->name('banner.edit');
    /////by ritu bottom banner////
    Route::get('/Add-Bottom-Banner', [App\Http\Controllers\AdminController::class, 'add_bottom_banner'])->name('add_bottom_banner');
    Route::post('/save_banner', [App\Http\Controllers\AdminController::class, 'save_banner'])->name('save_banner');
    Route::get('/View-Bottom-Banner', [App\Http\Controllers\AdminController::class, 'View_bottom_banner'])->name('View_bottom_banner');
    Route::get('/edit_bottom_banner/{id}', [App\Http\Controllers\AdminController::class, 'edit_bottom_banner'])->name('edit_bottom_banner');
    Route::post('/update_bottom_banner', [App\Http\Controllers\AdminController::class, 'update_bottom_banner'])->name('update_bottom_banner');
    Route::get('/delete_bottom_banner/{id}', [App\Http\Controllers\AdminController::class, 'delete_bottom_banner'])->name('delete_bottom_banner');
    Route::get('/banner_status/{id}', [App\Http\Controllers\AdminController::class, 'banner_status'])->name('banner_status');
    /////by ritu bottom banner////
    /////whatNew by Ritu//////
    Route::get('/what-new', [App\Http\Controllers\admin\WhatnewController::class, 'index'])->name('what-new');
    Route::match(['get', 'post'], '/what-new/create', [App\Http\Controllers\admin\WhatnewController::class, 'create'])->name('what-new.create');
    Route::match(['get', 'post'], '/what-new/edit/{id}', [App\Http\Controllers\admin\WhatnewController::class, 'edit'])->name('what-new.edit');
    /////whatNewpoint by Ritu //////
    Route::get('/whats-new-point', [App\Http\Controllers\admin\WhatsnewpointController::class, 'index'])->name('whats-new-point');
    Route::match(['get', 'post'], '/whats-new-point/create', [App\Http\Controllers\admin\WhatsnewpointController::class, 'create'])->name('whats-new-point.create');
    Route::match(['get', 'post'], '/whats-new-point/edit/{id}', [App\Http\Controllers\admin\WhatsnewpointController::class, 'edit'])->name('whats-new-point.edit');
    /////Client part//////
    Route::get('/client', [App\Http\Controllers\admin\ClientController::class, 'index'])->name('client');
    Route::match(['get', 'post'], '/client/create', [App\Http\Controllers\admin\ClientController::class, 'create'])->name('client.create');
    Route::match(['get', 'post'], '/client/edit/{id}', [App\Http\Controllers\admin\ClientController::class, 'edit'])->name('client.edit');
    /////Testimonials by Ritu//////
    Route::get('/testimonials', [App\Http\Controllers\admin\TestimonialController::class, 'index'])->name('testimonials');
    Route::match(['get', 'post'], '/testimonials/create', [App\Http\Controllers\admin\TestimonialController::class, 'create'])->name('testimonials.create');
    Route::match(['get', 'post'], '/testimonials/edit/{id}', [App\Http\Controllers\admin\TestimonialController::class, 'edit'])->name('testimonials.edit');
    //////become_an_instructors/////
    Route::get('/become_an_instructors', [App\Http\Controllers\admin\BecomeAnInstructorController::class, 'index'])->name('become_an_instructors');
    Route::match(['get', 'post'], '/become_an_instructors/create', [App\Http\Controllers\admin\BecomeAnInstructorController::class, 'create'])->name('become_an_instructors.create');
    Route::match(['get', 'post'], '/become_an_instructors/edit/{id}', [App\Http\Controllers\admin\BecomeAnInstructorController::class, 'edit'])->name('become_an_instructors.edit');
    //////////become_an_instructor_videos//////
    /////short Banner At home page//////
    Route::get('/short_banners', [App\Http\Controllers\admin\ShortBannerController::class, 'index'])->name('short_banners');
    Route::match(['get', 'post'], '/short_banners/create', [App\Http\Controllers\admin\ShortBannerController::class, 'create'])->name('short_banners.create');
    Route::match(['get', 'post'], '/short_banners/edit/{id}', [App\Http\Controllers\admin\ShortBannerController::class, 'edit'])->name('short_banners.edit');
    /////transform_short_banners////////
    Route::get('/transform_short_banners', [App\Http\Controllers\admin\TransformShortBannerController::class, 'index'])->name('transform_short_banners');
    Route::match(['get', 'post'], '/transform_short_banners/create', [App\Http\Controllers\admin\TransformShortBannerController::class, 'create'])->name('transform_short_banners.create');
    Route::match(['get', 'post'], '/transform_short_banners/edit/{id}', [App\Http\Controllers\admin\TransformShortBannerController::class, 'edit'])->name('transform_short_banners.edit');
    ////Trial classes///////////
    Route::get('/trial_classes', [App\Http\Controllers\admin\TrialClassController::class, 'index'])->name('trial_classes');
    Route::match(['get', 'post'], '/trial_classes/create', [App\Http\Controllers\admin\TrialClassController::class, 'create'])->name('trial_classes.create');
    Route::match(['get', 'post'], '/trial_classes/edit/{id}', [App\Http\Controllers\admin\TrialClassController::class, 'edit'])->name('trial_classes.edit');

    /////transform_short_banners End//////
    Route::get('/become_an_instructor_videos', [App\Http\Controllers\admin\BecomeAnInstructorVideoController::class, 'index'])->name('become_an_instructor_videos');
    Route::match(['get', 'post'], '/become_an_instructor_videos/create', [App\Http\Controllers\admin\BecomeAnInstructorVideoController::class, 'create'])->name('become_an_instructor_videos.create');
    Route::match(['get', 'post'], '/become_an_instructor_videos/edit/{id}', [App\Http\Controllers\admin\BecomeAnInstructorVideoController::class, 'edit'])->name('become_an_instructor_videos.edit');
    /////cantact_title section///////
    Route::get('/contact_titles', [App\Http\Controllers\admin\ContactTitleController::class, 'index'])->name('contact_titles');
    Route::match(['get', 'post'], '/contact_titles/create', [App\Http\Controllers\admin\ContactTitleController::class, 'create'])->name('contact_titles.create');
    Route::match(['get', 'post'], '/contact_titles/edit/{id}', [App\Http\Controllers\admin\ContactTitleController::class, 'edit'])->name('contact_titles.edit');
    /////Contact Query////
    Route::get('/contact_queries', [App\Http\Controllers\admin\ContactQueryController::class, 'index'])->name('contact_queries');
    Route::match(['get', 'post'], '/contact_queries/create', [App\Http\Controllers\admin\ContactQueryController::class, 'create'])->name('contact_queries.create');
    Route::match(['get', 'post'], '/contact_queries/edit/{id}', [App\Http\Controllers\admin\ContactQueryController::class, 'edit'])->name('contact_queries.edit');
    /////contact Video/////
    Route::get('/contact_videos', [App\Http\Controllers\admin\ContactVideoController::class, 'index'])->name('contact_videos');
    Route::match(['get', 'post'], '/contact_videos/create', [App\Http\Controllers\admin\ContactVideoController::class, 'create'])->name('contact_videos.create');
    Route::match(['get', 'post'], '/contact_videos/edit/{id}', [App\Http\Controllers\admin\ContactVideoController::class, 'edit'])->name('contact_videos.edit');
    /////Education Section/////
    Route::get('/education_info', [App\Http\Controllers\admin\EducationInfoController::class, 'index'])->name('education_info');
    Route::match(['get', 'post'], '/education_info/create', [App\Http\Controllers\admin\EducationInfoController::class, 'create'])->name('education_info.create');
    Route::match(['get', 'post'], '/education_info/edit/{id}', [App\Http\Controllers\admin\EducationInfoController::class, 'edit'])->name('education_info.edit');
    ////// by ritu///
    Route::get('/banner_point', [App\Http\Controllers\admin\BannerPointController::class, 'index'])->name('banner_point');
    Route::match(['get', 'post'], '/banner_point/create', [App\Http\Controllers\admin\BannerPointController::class, 'create'])->name('banner_point.create');
    Route::match(['get', 'post'], '/banner_point/edit/{id}', [App\Http\Controllers\admin\BannerPointController::class, 'edit'])->name('banner_point.edit');

    Route::get('/resion', [App\Http\Controllers\admin\ResionOfBestController::class, 'index'])->name('resion');
    Route::match(['get', 'post'], '/resion/create', [App\Http\Controllers\admin\ResionOfBestController::class, 'create'])->name('resion.create');
    Route::match(['get', 'post'], '/resion/edit/{id}', [App\Http\Controllers\admin\ResionOfBestController::class, 'edit'])->name('resion.edit');

    Route::get('/faq', [App\Http\Controllers\admin\FaqController::class, 'index'])->name('faq');
    Route::match(['get', 'post'], '/faq/create', [App\Http\Controllers\admin\FaqController::class, 'create'])->name('faq.create');
    Route::match(['get', 'post'], '/faq/edit/{id}', [App\Http\Controllers\admin\FaqController::class, 'edit'])->name('faq.edit');
    //blog
    Route::get('/blog', [App\Http\Controllers\admin\BlogController::class, 'index'])->name('blog');
    Route::match(['get', 'post'], '/blog/create', [App\Http\Controllers\admin\BlogController::class, 'create'])->name('blog.create');
    Route::match(['get', 'post'], '/blog/edit/{id}', [App\Http\Controllers\admin\BlogController::class, 'edit'])->name('blog.edit');

    Route::get('/video', [App\Http\Controllers\admin\StudentVideoController::class, 'index'])->name('video');
    Route::match(['get', 'post'], '/video/create', [App\Http\Controllers\admin\StudentVideoController::class, 'create'])->name('video.create');
    Route::match(['get', 'post'], '/video/edit/{id}', [App\Http\Controllers\admin\StudentVideoController::class, 'edit'])->name('video.edit');

    Route::get('/why-we', [App\Http\Controllers\admin\WhyWeController::class, 'index'])->name('why-we');
    Route::match(['get', 'post'], '/why-we/create', [App\Http\Controllers\admin\WhyWeController::class, 'create'])->name('why-we.create');
    Route::match(['get', 'post'], '/why-we/edit/{id}', [App\Http\Controllers\admin\WhyWeController::class, 'edit'])->name('why-we.edit');

    Route::get('/head', [App\Http\Controllers\admin\HeadInstructorController::class, 'index'])->name('head');
    Route::match(['get', 'post'], '/head/create', [App\Http\Controllers\admin\HeadInstructorController::class, 'create'])->name('head.create');
    Route::match(['get', 'post'], '/head/edit/{id}', [App\Http\Controllers\admin\HeadInstructorController::class, 'edit'])->name('head.edit');

    Route::get('/about', [App\Http\Controllers\admin\AboutUsController::class, 'index'])->name('about');
    Route::match(['get', 'post'], '/about/create', [App\Http\Controllers\admin\AboutUsController::class, 'create'])->name('about.create');
    Route::match(['get', 'post'], '/about/edit/{id}', [App\Http\Controllers\admin\AboutUsController::class, 'edit'])->name('about.edit');

    Route::get('/pricing', [App\Http\Controllers\admin\ManagePricingController::class, 'index'])->name('pricing');
    Route::match(['get', 'post'], '/pricing/create', [App\Http\Controllers\admin\ManagePricingController::class, 'create'])->name('pricing.create');
    Route::match(['get', 'post'], '/pricing/edit/{id}', [App\Http\Controllers\admin\ManagePricingController::class, 'edit'])->name('pricing.edit');
    Route::get('/time', [App\Http\Controllers\admin\ManagePricingController::class, 'time'])->name('time');

    Route::get('/price-master', [App\Http\Controllers\admin\PriceMasterController::class, 'index'])->name('price-master');
    Route::match(['get', 'post'], '/price-master/create', [App\Http\Controllers\admin\PriceMasterController::class, 'create'])->name('price-master.create');
    Route::match(['get', 'post'], '/price-master/edit/{id}', [App\Http\Controllers\admin\PriceMasterController::class, 'edit'])->name('price-master.edit');

    Route::get('/category_class', [App\Http\Controllers\admin\CategoryClass::class, 'index'])->name('category_class');
    Route::match(['get', 'post'], '/category_class/create', [App\Http\Controllers\admin\CategoryClass::class, 'create'])->name('category_class.create');
    Route::match(['get', 'post'], '/category_class/edit/{id}', [App\Http\Controllers\admin\CategoryClass::class, 'edit'])->name('category_class.edit');

    Route::get('/course', [App\Http\Controllers\admin\CourseController::class, 'index'])->name('course');
    Route::match(['get', 'post'], '/course/create', [App\Http\Controllers\admin\CourseController::class, 'create'])->name('course.create');
    Route::match(['get', 'post'], '/course/edit/{id}', [App\Http\Controllers\admin\CourseController::class, 'edit'])->name('course.edit');

    Route::get('/review', [App\Http\Controllers\admin\ReviewController::class, 'index'])->name('review');
    Route::match(['get', 'post'], '/review/create', [App\Http\Controllers\admin\ReviewController::class, 'create'])->name('review.create');
    Route::match(['get', 'post'], '/review/edit/{id}', [App\Http\Controllers\admin\ReviewController::class, 'edit'])->name('review.edit');

    Route::get('/course_level', [App\Http\Controllers\admin\CourseLevelController::class, 'index'])->name('course_level');
    Route::match(['get', 'post'], '/course_level/create', [App\Http\Controllers\admin\CourseLevelController::class, 'create'])->name('course_level.create');
    Route::match(['get', 'post'], '/course_level/edit/{id}', [App\Http\Controllers\admin\CourseLevelController::class, 'edit'])->name('course_level.edit');

    Route::get('/course_faq', [App\Http\Controllers\admin\CourseFaqController::class, 'index'])->name('course_faq');
    Route::match(['get', 'post'], '/course_faq/create', [App\Http\Controllers\admin\CourseFaqController::class, 'create'])->name('course_faq.create');
    Route::match(['get', 'post'], '/course_faq/edit/{id}', [App\Http\Controllers\admin\CourseFaqController::class, 'edit'])->name('course_faq.edit');

    Route::get('/course_lession', [App\Http\Controllers\admin\CourseLessionController::class, 'index'])->name('course_lession');
    Route::match(['get', 'post'], '/course_lession/create', [App\Http\Controllers\admin\CourseLessionController::class, 'create'])->name('course_lession.create');
    Route::match(['get', 'post'], '/course_lession/edit/{id}', [App\Http\Controllers\admin\CourseLessionController::class, 'edit'])->name('course_lession.edit');

    Route::get('/student', [App\Http\Controllers\admin\StudentController::class, 'index'])->name('student');
    Route::match(['get', 'post'], '/student/create', [App\Http\Controllers\admin\StudentController::class, 'create'])->name('student.create');
    Route::match(['get', 'post'], '/student/edit/{id}', [App\Http\Controllers\admin\StudentController::class, 'edit'])->name('student.edit');

    Route::get('/teacher', [App\Http\Controllers\admin\TeacherController::class, 'index'])->name('teacher');
    Route::match(['get', 'post'], '/teacher/create', [App\Http\Controllers\admin\TeacherController::class, 'create'])->name('teacher.create');
    Route::match(['get', 'post'], '/teacher/edit/{id}', [App\Http\Controllers\admin\TeacherController::class, 'edit'])->name('teacher.edit');
    /////Booking Classes///////////
    Route::get('/bookclasses', [App\Http\Controllers\admin\BookClassController::class, 'index'])->name('bookclasses');
    Route::match(['get', 'post'], '/bookclasses/create', [App\Http\Controllers\admin\BookClassController::class, 'create'])->name('bookclasses.create');
    Route::match(['get', 'post'], '/bookclasses/edit/{id}', [App\Http\Controllers\admin\BookClassController::class, 'edit'])->name('bookclasses.edit');
    /////Booking Classes End///////
    //////footer Text////
    Route::get('/footer_texts', [App\Http\Controllers\admin\FooterTextController::class, 'index'])->name('footer_texts');
    Route::match(['get', 'post'], '/footer_texts/create', [App\Http\Controllers\admin\FooterTextController::class, 'create'])->name('footer_texts.create');
    Route::match(['get', 'post'], '/footer_texts/edit/{id}', [App\Http\Controllers\admin\FooterTextController::class, 'edit'])->name('footer_texts.edit');
    ///end part////
    /////Student Login ////////////////
    Route::get('/referral', [App\Http\Controllers\admin\ReferralController::class, 'index'])->name('referral');
    Route::match(['get', 'post'], '/referral/create', [App\Http\Controllers\admin\ReferralController::class, 'create'])->name('referral.create');
    Route::match(['get', 'post'], '/referral/edit/{id}', [App\Http\Controllers\admin\ReferralController::class, 'edit'])->name('referral.edit');
    ////Referral//////
    Route::get('/student_login', [App\Http\Controllers\admin\StudenLoginPageController::class, 'index'])->name('student_login');
    Route::match(['get', 'post'], '/student_login/create', [App\Http\Controllers\admin\StudenLoginPageController::class, 'create'])->name('student_login.create');
    Route::match(['get', 'post'], '/student_login/edit/{id}', [App\Http\Controllers\admin\StudenLoginPageController::class, 'edit'])->name('student_login.edit');
    //////admin orders///////
    Route::get('/view-orders', [App\Http\Controllers\AdminController::class, 'view_order'])->name('view_order');
    Route::get('/view-book-sessions', [App\Http\Controllers\AdminController::class, 'book_session'])->name('book_session');

    Route::get('/order_details/{id}',[App\Http\Controllers\AdminController::class, 'order_details'])->name('order_details');
    /// admin order end ///
    Route::get('/cms', [App\Http\Controllers\admin\CmsController::class, 'index'])->name('cms');
    Route::match(['get', 'post'], '/cms/create', [App\Http\Controllers\admin\CmsController::class, 'create'])->name('cms.create');
    Route::match(['get', 'post'], '/cms/edit/{id}', [App\Http\Controllers\admin\CmsController::class, 'edit'])->name('cms.edit');

    Route::get('/credit', [App\Http\Controllers\admin\StudentController::class, 'credit'])->name('credit');
    Route::get('/time', [App\Http\Controllers\admin\StudentController::class, 'time'])->name('time');
    Route::get('/classtype', [App\Http\Controllers\admin\StudentController::class, 'classtype'])->name('classtype');
    Route::post( '/credit/add', [App\Http\Controllers\admin\StudentController::class, 'creditmanage'])->name('credit.add');
    Route::get('/creditclass', [App\Http\Controllers\admin\StudentController::class, 'creditclass'])->name('creditclass');

    Route::get('messages', [App\Http\Controllers\admin\SupportController::class, 'messages'])->name('messages');
    Route::get('/load-latest-messages', [App\Http\Controllers\admin\SupportController::class, 'getLoadLatestMessages']);
    Route::post('/send', [App\Http\Controllers\admin\SupportController::class, 'postSendMessage']);
    Route::get('/fetch-old-messages', [App\Http\Controllers\admin\SupportController::class, 'getOldMessages']);
    Route::get('/coupon', [App\Http\Controllers\admin\CouponController::class, 'index'])->name('coupon');

    Route::get('/st_time', [App\Http\Controllers\admin\TeacherController::class, 'st_time'])->name('st_time');
    Route::get('/st_slot', [App\Http\Controllers\admin\TeacherController::class, 'st_slot'])->name('st_slot');
    Route::get('/cal', [App\Http\Controllers\admin\TeacherController::class, 'cal_data'])->name('cal');
    Route::get('/book_session', [App\Http\Controllers\admin\TeacherController::class, 'book_session'])->name('book_session');
    Route::get('/teacher-to-merithub/{id}', [App\Http\Controllers\admin\TeacherController::class, 'merithub_create_class'])->name('book.session.merithub');
    //Quize-Test
    Route::get('/quize', [App\Http\Controllers\admin\QuizeTestController::class, 'index'])->name('quize');
    Route::match(['get', 'post'], '/quize/create', [App\Http\Controllers\admin\QuizeTestController::class, 'create'])->name('quize.create');
    Route::match(['get', 'post'], '/quize/edit/{id}', [App\Http\Controllers\admin\QuizeTestController::class, 'edit'])->name('quize.edit');

    Route::get('/coupon_remember',[App\Http\Controllers\admin\ReferralController::class,'coupon_remember'])->name('coupon_remember');

});
Route::get('/support', [App\Http\Controllers\front\CommonController::class, 'supportView'])->name('support');
Route::get('/user/support', [App\Http\Controllers\front\CommonController::class, 'support'])->name('support');
Route::get('/checkMsg', [App\Http\Controllers\front\CommonController::class, 'checkMsg'])->name('checkMsg');
Route::get('/user-import', [App\Http\Controllers\front\CommonController::class, 'userImport'])->name('user.import');
Route::get('/user-img-change', [App\Http\Controllers\front\CommonController::class, 'userImgChange'])->name('user.img.change');
// Route::get('/pricing', [App\Http\Controllers\admin\ManagePricingController::class, 'pricing'])->name('pricing');
Route::get('/time', [App\Http\Controllers\admin\ManagePricingController::class, 'time1'])->name('time');
Route::get('/view', [App\Http\Controllers\admin\ManagePricingController::class, 'view'])->name('view');
Route::get('/view1/{id}', [App\Http\Controllers\admin\ManagePricingController::class, 'view1'])->name('view1');
Route::get('/price', [App\Http\Controllers\admin\ManagePricingController::class, 'price'])->name('price');
Route::get('/timeprice', [App\Http\Controllers\admin\ManagePricingController::class, 'timeprice'])->name('timeprice');
Route::get('/about', function () {
    return view('front.about-us');
});
Route::get('/about-us', function () {
    return view('front.about-us');
});
Route::get('/course-structure', function () {
    return view('front.course-structure');
});
Route::get('/cms', function () {
    return view('front.policy');
});
Route::get('/become-a-teacher-page', function () {
    return view('front.teacher.become-a-teacher-page');
});
// Route::get('/pricing', function () {
//     // return view('front.pricing');
// });
Route::get('/cal', [App\Http\Controllers\front\StudentController::class, 'cal_data'])->name('cal');

// Route::get('/support', function () {
//     return view('front.support');
// });
Route::get('/blog', [App\Http\Controllers\admin\BlogController::class, 'view'])->name('blog.view');
Route::get('/blog-fetch/{id}', [App\Http\Controllers\admin\BlogController::class, 'fetch'])->name('blog.fetch');


Route::get('/blog', [App\Http\Controllers\admin\BlogController::class, 'view'])->name('blog.view');
Route::get('/blog-fetch/{id}', [App\Http\Controllers\admin\BlogController::class, 'fetch'])->name('blog.fetch');

Route::match(['get', 'post'], 'student/register', [App\Http\Controllers\front\StudentController::class, 'register'])->name('student.register');


Route::group(['prefix' => 'student', 'as' => 'student.', 'middleware' => ['Student']], function () {

    Route::get('/student-settings', [App\Http\Controllers\student\StudentSettingController::class, 'index'])->name('student-settings');
    Route::get('/my-classes', [App\Http\Controllers\student\StudentSettingController::class, 'class'])->name('my-classes');
    Route::get('student-my-order', [App\Http\Controllers\student\StudentSettingController::class, 'my_order'])->name('student-my-order');
    Route::get('student-my-order-details/{id}', [App\Http\Controllers\student\StudentSettingController::class, 'my_order_details'])->name('student-my-order-details');

    Route::get('/student-book-session', [App\Http\Controllers\front\StudentController::class, 'book_session'])->name('book.session');
    Route::get('/student-to-merithub/{id}', [App\Http\Controllers\front\StudentController::class, 'merithub_create_class'])->name('book.session.merithub');

    Route::post( '/student-settings/create', [App\Http\Controllers\student\StudentSettingController::class, 'create'])->name('student-settings.create');
    Route::post( '/timezone/create', [App\Http\Controllers\student\StudentSettingController::class, 'timezone'])->name('timezone.create');
    Route::post('/student-settings/create', [App\Http\Controllers\student\StudentSettingController::class, 'create'])->name('student-settings.create');
    Route::post('/timezone/create', [App\Http\Controllers\student\StudentSettingController::class, 'timezone'])->name('timezone.create');

    Route::match(['get', 'post'], '/dashboard', [App\Http\Controllers\front\StudentController::class, 'index'])->name('index');

    Route::post( '/referemail', [App\Http\Controllers\student\StudentSettingController::class, 'email'])->name('referemail');

    Route::get('/student-book-a-class', function () {
        return view('front.student-book-a-class');
    })->name('sbac');
    Route::get('/refer-a-friend', function () {
        return view('front.refer-a-friend');
    });
    Route::get('wishlists', [App\Http\Controllers\admin\BookClassController::class, 'viewwishlist'])->name('wish.list');

    Route::get('cart-list', [App\Http\Controllers\student\CartController::class, 'cartList'])->name('cart.list');
    Route::get('single-cart', [App\Http\Controllers\student\CartController::class, 'addToCart'])->name('single.cart.store');
    Route::post('update-cart', [App\Http\Controllers\student\CartController::class, 'updateCart'])->name('cart.update');
    Route::get('remove', [App\Http\Controllers\student\CartController::class, 'removeCart'])->name('cart.remove');
    Route::get('clear', [App\Http\Controllers\student\CartController::class, 'clearAllCart'])->name('cart.clear');
    Route::post('coupan', [App\Http\Controllers\student\CartController::class, 'coupan'])->name('coupan');
    Route::get('checkout', [App\Http\Controllers\student\CheckoutController::class, 'index'])->name('checkout');
    Route::post('add-checkout1', [App\Http\Controllers\student\PaymentController1::class, 'paypalSubmit'])->name('add.checkout1');
    Route::post('add-checkout', [App\Http\Controllers\student\PaymentController::class, 'paypalSubmit'])->name('add.checkout');

    Route::post('cancle', [App\Http\Controllers\student\CheckoutController::class, 'cancle'])->name('paypalCancel');
    Route::get('success', [App\Http\Controllers\student\CheckoutController::class, 'success'])->name('paypalSuccess');

    Route::get('class_details/{id}', [App\Http\Controllers\front\StudentController::class, 'class_details'])->name('class_details');
    Route::get('messages', [App\Http\Controllers\front\StudentController::class, 'messages'])->name('messages');
    Route::get('/load-latest-messages', [App\Http\Controllers\front\StudentController::class, 'getLoadLatestMessages']);
    Route::post('/send', [App\Http\Controllers\front\StudentController::class, 'postSendMessage']);
    Route::get('/fetch-old-messages', [App\Http\Controllers\front\StudentController::class, 'getOldMessages']);

    Route::get('/student-settings/delete', [App\Http\Controllers\student\StudentSettingController::class, 'delete'])->name('student-settings.delete');
    Route::post('/student-settings/profile', [App\Http\Controllers\student\StudentSettingController::class, 'profile'])->name('student-settings.profile');

    Route::post('paypal-course-order-create', [App\Http\Controllers\student\PaymentController::class, 'paypalCourseOrderCreate'])->name('paypal-course-order-create');
    Route::post('paypal-order-capture', [App\Http\Controllers\student\PaymentController::class, 'paypalOrderCapture'])->name('paypal-order-capture');

    Route::post('paypal-course-order-create1', [App\Http\Controllers\student\PaymentController1::class, 'paypalCourseOrderCreate'])->name('paypal-course-order-create1');
    Route::post('paypal-order-capture1', [App\Http\Controllers\student\PaymentController1::class, 'paypalOrderCapture'])->name('paypal-order-capture1');

    Route::post('payment', [App\Http\Controllers\student\StripeController::class, 'payment'])->name('stripe.post');
    Route::post('payment', [App\Http\Controllers\student\StripeController1::class, 'payment'])->name('stripe.post');
    Route::get('subscription-calcle/{id}', [App\Http\Controllers\student\StripeController::class, 'cancle'])->name('subscription-calcle');
    Route::get('subscription-calcle1/{id}', [App\Http\Controllers\student\StripeController::class, 'active'])->name('subscription-calcle1');

    Route::get('quize', [App\Http\Controllers\admin\QuizeTestController::class, 'quize'])->name('quize');
    Route::get('quizechild/{id}', [App\Http\Controllers\admin\QuizeTestController::class, 'quizechild'])->name('quizechild');
    Route::get('quizesub/{id}/{parent_id}', [App\Http\Controllers\admin\QuizeTestController::class, 'quizesub'])->name('quizesub');
    Route::get('quizetest', [App\Http\Controllers\admin\QuizeTestController::class, 'quizetest'])->name('quizetest');


    Route::get('/student-change-password', function () {
        return view('front.student-change-password');
    });

    Route::get('/practice', function () {
        return view('front.quize');
    });

    Route::get('/cancle', function () {
        return view('front.cancle-policy');
    });
    Route::post('change-password', [App\Http\Controllers\student\ChangePasswordController::class, 'store'])->name('change.password');

    Route::post('/coupan', [App\Http\Controllers\student\CartController::class, 'coupan'])->name('coupan');
    Route::post('/remove', [App\Http\Controllers\student\CartController::class, 'remove'])->name('remove');
    Route::get('/cancleclass', [App\Http\Controllers\front\StudentController::class, 'cancleclass'])->name('cancleclass');

});
Route::get('cart', [App\Http\Controllers\student\CartController::class, 'addToCart'])->name('student.cart.store');


Route::get('wishlist/{id}', [App\Http\Controllers\admin\BookClassController::class, 'addwishlist'])->name('add-wishlist');
Route::get('wishlist/remove/{id}', [App\Http\Controllers\admin\BookClassController::class, 'removewishlist'])->name('remove-wishlist');

Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => ['Teacher']], function () {
    Route::get('dashboard', [App\Http\Controllers\front\teacher\HomeController::class, 'index'])->name('dashboard');
    Route::get('setting', [App\Http\Controllers\front\teacher\HomeController::class, 'setting'])->name('setting');
    Route::post('setting', [App\Http\Controllers\front\teacher\HomeController::class, 'setting_update'])->name('setting.update');
    Route::get('calendar', [App\Http\Controllers\front\teacher\HomeController::class, 'calendar'])->name('calendar');
    Route::get('messages', [App\Http\Controllers\front\teacher\HomeController::class, 'messages'])->name('messages');
    Route::get('/load-latest-messages', [App\Http\Controllers\front\teacher\HomeController::class, 'getLoadLatestMessages']);
    Route::post('/send', [App\Http\Controllers\front\teacher\HomeController::class,'postSendMessage']);
    Route::get('/fetch-old-messages', [App\Http\Controllers\front\teacher\HomeController::class,'getOldMessages']);
    Route::post('/availability-update', [App\Http\Controllers\front\teacher\HomeController::class,'availabilityUpdate'])->name('availability.update');
    Route::post( '/timezone-update', [App\Http\Controllers\front\teacher\HomeController::class, 'timezone'])->name('timezone.update');
    Route::post('/unavailability', [App\Http\Controllers\front\teacher\HomeController::class,'unavailability'])->name('unavailability');
    Route::get('/cancleclass', [App\Http\Controllers\front\teacher\HomeController::class, 'cancleclass'])->name('cancleclass');
    Route::get('/cancleunavailability', [App\Http\Controllers\front\teacher\HomeController::class, 'cancleunavailability'])->name('cancleunavailability');
    Route::post('/delete-action', [App\Http\Controllers\admin\AjaxController::class, 'pureDelete'])->name('delete-action');

});
Route::post('/state-list', [App\Http\Controllers\admin\AjaxController::class, 'stateList'])->name('state-list');
Route::post('/city-list', [App\Http\Controllers\admin\AjaxController::class, 'cityList'])->name('city-list');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('student.logout');

Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'ForgetPassword'])->name('ForgetPasswordGet');
Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'ForgetPasswordStore'])->name('ForgetPasswordPost');
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'ResetPassword'])->name('ResetPasswordGet');
Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');

Route::get('/student/checkoutNew',[App\Http\Controllers\student\CheckoutController::class, 'addToCartNew'])->name('student.checkoutNew');

Route::get('/expired', function () {
    return view('front.url-expired');
});
Route::get('/user/practice', function () {
    return view('front.quize');
});

Route::get('/currency_changes', [App\Http\Controllers\front\CommonController::class, 'CurrencyChanges'])->name('currency_changes');

// Route::get('s-email', function () {
//     Mail::send('email.sample', [], function ($messages) {
//         // $messages->to('deepansh.techsaga@gmail.com')
//         $messages->to('saurabh.r@techsaga.co.in')
//         ->from(env('MAIL_USERNAME'), 'Latogo');
//         $messages->subject("DEMO TESTING!!");
//     });
//     echo 'DONE';
// });

Route::get('v1/server/cron/alert2hours', function () {
    \Artisan::call('Alert:2Hour');
});
Route::get('v1/server/cron/alert30minutes', function () {
    \Artisan::call('Alert:30Minutes');
});

Route::post('/age-verify', [App\Http\Controllers\front\CommonController::class, 'verification'])->name('age-verification');

Auth::routes();
Route::post('/timezone-list', [App\Http\Controllers\admin\AjaxController::class, 'TimezoneList'])->name('timezone-list');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('{slug}', [App\Http\Controllers\admin\CmsController::class, 'fetch'])->name('cms.data.fetch');
