<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\BogoController;
use App\Http\Controllers\Backend\categoryController;
use App\Http\Controllers\Backend\ChefController;
use App\Http\Controllers\Backend\configController;
use App\Http\Controllers\Backend\contactController;
use App\Http\Controllers\Backend\DinningHourController;
use App\Http\Controllers\Backend\DiscountController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\galleryController;
use App\Http\Controllers\Backend\GardenController;
use App\Http\Controllers\Backend\HolidayController;
use App\Http\Controllers\Backend\homeSlider;
use App\Http\Controllers\Backend\LogoController;
use App\Http\Controllers\Backend\menuController;
use App\Http\Controllers\Backend\openDayController;
use App\Http\Controllers\Backend\orderController;
use App\Http\Controllers\Backend\PopupVideo;
use App\Http\Controllers\Backend\reservationController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\specialitiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\templateController;
use App\Http\Controllers\frontendController;
use App\Mail\ContactFormMail;
use App\Mail\DeliveredOrder;
use App\Mail\ReplyMail;
use App\Mail\reservation;
use App\Models\DinningHour;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

// Route::get('/menu/delete', function(){
//     $exitCode = Artisan::call('day:delete');
//     return 'success';
// });

// Route::get('/mail', function(){
//     $exitCode = Artisan::call('cache:clear');
//     return true;
// });


Route::post('/make-reservation', [reservationController::class, 'store'])->name('make_reservation');
Route::get('/reservation/{id}?step=3&tran={tran}&status={status}', function(){
    return 'hello';
});

Route::get('/', [frontendController::class, 'index'])->name('index');
Route::get('/contact', [frontendController::class, 'contact'])->name('contact');
Route::get('/gallery', [frontendController::class, 'gallery'])->name('gallery');
Route::get('/dining-hour', [frontendController::class, 'dinning_hour'])->name('dinning_hour');
Route::get('/menu', [frontendController::class, 'menu'])->name('menu');
Route::get('/reservation', [frontendController::class, 'reservation'])->name('reservation');
Route::get('/dynamic_dependent/{booking_date}',[reservationController::class,'dynamic_dependent'])->name('dynamic_dependent');
Route::post('addtocart', [frontendController::class, 'addToCart']);
Route::get('cartitem', [frontendController::class, 'cartitem']);
Route::delete('delete/{id}', [frontendController::class, 'delete_cart_item']);
Route::post('/checkout', [frontendController::class, 'checkout'])->name('orderStore');
Route::post('/contact/form', [frontendController::class, 'contact_form'])->name('contact.form');

//discount
Route::post('/gp_star/discount/{code}/{amount}', [reservationController::class, 'gp_star'])->name('gp.star.discount');
Route::post('/city_gem/discount/{code}/{amount}', [reservationController::class, 'city_gem'])->name('city.gem.discount');

//bogo offer
Route::post('/brac_bank/bogo/{card}/{amount}/{menu}/{date}', [reservationController::class, 'brac_bank'])->name('brac_bank.bogo');
Route::post('/ebl/bogo/{card}/{amount}/{menu}/{date}', [reservationController::class, 'ebl'])->name('ebl.bogo');

//check bogo backend
Route::get('/validate/bogo/{card}', [reservationController::class, 'validate_bogo'])->name('validate.bogo');
Route::get('/validate/ebl/{card}/bogo/{menu_price}/{total_amount}/{date}', [reservationController::class, 'validate_bogo_ebl'])->name('validate.bogo.ebl');
Route::get('/validate/brac/{card}/bogo/{menu_price}/{total_amount}/{date}', [reservationController::class, 'validate_bogo_brac'])->name('validate.bogo.brac');
Route::get('/validate/{card_number}/amex/{menu_price}/card/{total_amount}/date/{date}', [reservationController::class, 'validate_amex_bogo'])->name('validate.bogo.amex');

Auth::routes();

Route::get('/register', function(){
    return redirect()->route('login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('backend_dashboard');
    
    Route::get('datewise/count/',[App\Http\Controllers\HomeController::class,'date_person_count'])->name('date.person.count');
    Route::get('total/person/count/',[App\Http\Controllers\HomeController::class,'total_person_count'])->name('total.person.count');
    
    Route::group(['prefix' => 'logo'], function () {
        Route::get('/', [LogoController::class, 'index'])->name('logoShow');
        Route::post('/store', [LogoController::class, 'store'])->name('logoStore');
        Route::post('/update/{logo:id}', [LogoController::class, 'update'])->name('logoUpdate');
        Route::post('/delete/{logo:id}', [LogoController::class, 'destroy'])->name('logoDelete');
    });

    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', [homeSlider::class, 'index'])->name('sliderShow');
        Route::post('/store', [homeSlider::class, 'store'])->name('sliderStore');
        Route::post('/update/{slider:id}', [homeSlider::class, 'update'])->name('sliderUpdate');
        Route::post('/delete/{slider:id}', [homeSlider::class, 'destroy'])->name('sliderDelete');
    });

    Route::group(['prefix' => 'usermanagement'], function () {
        Route::get('/', [ProfileController::class, 'all_user'])->name('user.all');
        Route::post('/add', [ProfileController::class, 'role_user_add'])->name('role.user.add');
        Route::post('/update/{id}', [ProfileController::class, 'role_user_update'])->name('role.user.update');
        Route::post('/delete/{id}', [ProfileController::class, 'role_user_delete'])->name('role.user.delete');
        Route::post('/reset/{id}', [ProfileController::class, 'role_user_password_reset'])->name('role.user.password.reset');
    });

    Route::group(['prefix' => 'about'], function () {
        Route::get('/', [AboutController::class, 'index'])->name('aboutShow');
        Route::post('/store', [AboutController::class, 'store'])->name('aboutStore');
        Route::post('/update/{about:id}', [AboutController::class, 'update'])->name('aboutUpdate');
        Route::post('/delete/{about:id}', [AboutController::class, 'destroy'])->name('aboutDelete');
    });

    Route::group(['prefix' => 'hours'], function () {
        Route::get('/', [openDayController::class, 'index'])->name('hoursShow');
        Route::post('/store', [openDayController::class, 'store'])->name('hoursStore');
        Route::post('/update/{hours:id}', [openDayController::class, 'update'])->name('hoursUpdate');
        Route::post('/delete/{hours:id}', [openDayController::class, 'destroy'])->name('hoursDelete');
    });

    Route::group(['prefix' => 'chef'], function () {
        Route::get('/', [ChefController::class, 'index'])->name('chefShow');
        Route::post('/store', [ChefController::class, 'store'])->name('chefStore');
        Route::post('/update/{chef:id}', [ChefController::class, 'update'])->name('chefUpdate');
        Route::post('/delete/{chef:id}', [ChefController::class, 'destroy'])->name('chefDelete');
    });

    Route::group(['prefix' => 'admingallery'], function () {
        Route::get('/', [galleryController::class, 'index'])->name('galleryShow');
        Route::post('/store', [galleryController::class, 'store'])->name('galleryStore');
        Route::post('/update/{gallery:id}', [galleryController::class, 'update'])->name('galleryUpdate');
        Route::post('/delete/{gallery:id}', [galleryController::class, 'destroy'])->name('galleryDelete');
    });

    //dining hour start
    Route::group(['prefix' => 'dininghour'], function(){
        Route::get('/',[DinningHourController::class,'index'])->name('dining.all');
        Route::post('/store', [DinningHourController::class, 'store'])->name('diningStore');
        Route::post('/update/{dining:id}', [DinningHourController::class, 'update'])->name('diningUpdate');
        Route::post('/delete/{dining:id}', [DinningHourController::class, 'destroy'])->name('diningDelete');
    });
    //dining hour end

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [categoryController::class, 'index'])->name('categoryShow');
        Route::post('/store', [categoryController::class, 'store'])->name('categoryStore');
        Route::get('/edit/{id}', [categoryController::class, 'edit'])->name('category.edit');
        Route::post('/delete/food/{food}/category/{category}', [categoryController::class, 'delete_food_from_category'])->name('delete.food.category');
        Route::post('/delete/day/{day}/category/{category}', [categoryController::class, 'delete_day_from_category'])->name('delete.day.category');
        Route::post('/update/{category:id}', [categoryController::class, 'update'])->name('categoryUpdate');
        Route::post('/delete/{category:id}', [categoryController::class, 'destroy'])->name('categoryDelete');
        Route::get('/food/view/{category:id}', [categoryController::class, 'add_food_view'])->name('category.food.view');
        Route::post('/food/add/{id}', [categoryController::class, 'add_food'])->name('category.food.add');
        Route::post('/category/day/{id}',[categoryController::class,'category_day'])->name('category.day');
        Route::post('/food/add/images/{id}',[categoryController::class,'add_food_image'])->name('category.food.images.add');
        Route::post('/food/update/images/{food}/{category}',[categoryController::class,'update_food_image'])->name('category.food.images.update');
        Route::post('/food/delete/images/{food}/{category}',[categoryController::class,'delete_food_image'])->name('category.food.images.delete');
    });


    Route::group(['prefix' => 'specialization'], function () {
        Route::get('/', [specialitiesController::class, 'index'])->name('specialityShow');
        Route::post('/store', [specialitiesController::class, 'store'])->name('specialityStore');
        Route::post('/update/{specialities:id}', [specialitiesController::class, 'update'])->name('specialityUpdate');
        Route::post('/delete/{specialities:id}', [specialitiesController::class, 'destroy'])->name('specialityDelete');
    });
    
    Route::group(['prefix'=>'event'], function(){
        Route::get('/',[EventController::class,'index'])->name('event.all');
        Route::post('/add',[EventController::class,'add'])->name('event.add');
        Route::post('/update/{id}',[EventController::class,'update'])->name('event.update');
        Route::post('/delete/{id}',[EventController::class,'delete'])->name('event.delete');
    });

    Route::group(['prefix'=>'garden'], function(){
        Route::get('/',[GardenController::class,'index'])->name('garden.all');
        Route::post('/add',[GardenController::class,'add'])->name('garden.add');
        Route::post('/update/{id}',[GardenController::class,'update'])->name('garden.update');
        Route::post('/delete/{id}',[GardenController::class,'delete'])->name('garden.delete');
    });

    Route::group(['prefix' => 'adminmenu'], function () {
        Route::get('/menu', [menuController::class, 'index'])->name('menuShow');
        Route::post('/store', [menuController::class, 'store'])->name('menuStore');
        Route::get('/edit/{menu:id}', [menuController::class, 'edit'])->name('menuEdit');
        Route::post('/update/{menu:id}', [menuController::class, 'update'])->name('menuUpdate');
        Route::post('/delete/{menu:id}', [menuController::class, 'destroy'])->name('menuDelete');
    });

    Route::group(['prefix' => 'adminConfig'], function () {
        Route::get('/', [configController::class, 'index'])->name('configShow');
        Route::post('/store', [configController::class, 'store'])->name('configStore');
        Route::post('/update', [configController::class, 'update'])->name('configUpdate');
        Route::post('/delete/{config:id}', [configController::class, 'destroy'])->name('configDelete');
    });

    Route::group(['prefix' => 'popup/video'], function () {
        Route::get('/', [PopupVideo::class, 'index'])->name('popup.video');
        Route::post('/update/{id}', [PopupVideo::class, 'update'])->name('video.update');
    });

    //holiday route start
    Route::group(['prefix'=>'holiday'], function(){
        Route::get('/',[HolidayController::class,'index'])->name('holiday.all');
        Route::post('/add',[HolidayController::class,'add'])->name('holiday.add');
        Route::post('/update/{id}',[HolidayController::class,'update'])->name('holiday.update');
        Route::post('/delete/{id}',[HolidayController::class,'delete'])->name('holiday.delete');
    });

    //bogos
    Route::group(['prefix'=>'bogos'], function(){
        Route::get('/',[BogoController::class,'index'])->name('bogo.all');
    });

    //discount
    Route::group(['prefix'=>'discount'], function(){
        Route::get('/',[DiscountController::class,'index'])->name('discount.all');
        Route::post('/add',[DiscountController::class,'add'])->name('discount.add');
        Route::post('/update/{id}',[DiscountController::class,'update'])->name('discount.update');
        Route::post('/delete/{id}',[DiscountController::class,'delete'])->name('discount.delete');
    });

    Route::group(['prefix' => 'adminContact'], function () {
        Route::get('/', [contactController::class, 'index'])->name('contactShow');
        Route::post('/store', [contactController::class, 'store'])->name('contactStore');
        Route::post('/update/{contact:id}', [contactController::class, 'update'])->name('contactUpdate');
        Route::post('/delete/{contact:id}', [contactController::class, 'destroy'])->name('contactDelete');
    });

    Route::group(['prefix' => 'my-profile'], function () {
        Route::get('/{user:id}', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update/{user:id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/update-password/{user:id}', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/delete-profile/{user:id}', [ProfileController::class, 'destroy'])->name('profile.delete');
    });

    Route::group(['prefix' => 'reservation'], function () {
        Route::get('/', [reservationController::class, 'index'])->name('reservationShow');
        Route::get('/reservation-make', [reservationController::class, 'make_reservation_page'])->name('reservation.make.page');
        Route::post('/reservation-make', [reservationController::class, 'make_reservation'])->name('reservation.make');

        Route::get('/alldata',[reservationController::class,'all_data'])->name('reservation.all.data');
        Route::get('/data/view/{id}',[reservationController::class,'data_view'])->name('reservation.view');
        Route::post('/store', [reservationController::class, 'store'])->name('reservationStore');
        Route::post('/update/{reservation:id}', [reservationController::class, 'update'])->name('reservationUpdate');
        Route::post('/update/not_arrived/{reservation:id}', [reservationController::class, 'not_arrived_update'])->name('not_arrived_update');
        Route::post('/update/paid_reservation/{reservation:id}', [reservationController::class, 'paid_reservation_update'])->name('paid_reservation_update');
        
        Route::post('/update/not_paid_reservation/{reservation:id}', [reservationController::class, 'not_paid_reservation_update'])->name('not_paid_reservation_update');
        Route::post('/update/paid_reservation/{reservation:id}', [reservationController::class, 'paid_reservation_update'])->name('paid_reservation_update');
        
        //update Date
        Route::post('update/date/{id}',[reservationController::class, 'update_date'])->name('update.date');

        Route::post('/delete/{reservation:id}', [reservationController::class, 'destroy'])->name('reservationDelete');
        Route::post('/delete/onspot/{reservation:id}', [reservationController::class, 'onspot_destroy'])->name('onspot.reservationDelete');
        Route::post('/delete/online/{reservation:id}', [reservationController::class, 'online_destroy'])->name('online.reservationDelete');
        Route::get('/getPass/{reservation:id}', [reservationController::class, 'getPass'])->name('entryPass');
        Route::get('/paid', [reservationController::class, 'paid'])->name('paid');
        Route::get('/not_paid', [reservationController::class, 'not_paid'])->name('notPaid');
        Route::get('/arrived', [reservationController::class, 'arrived'])->name('arrived');
        Route::get('/notArrived', [reservationController::class, 'not_arrived'])->name('not_arrived');

        Route::get('reservation/edit/onspot/{id}',[reservationController::class,'edit'])->name('onspot.reservation.edit');
        Route::get('reservation/edit/online/{id}',[reservationController::class,'edit_online'])->name('online.reservation.edit');
    });

    Route::get('/message',[contactController::class,'all_message'])->name('all.message');
    Route::post('/message/delete/',[contactController::class,'delete_message'])->name('message.delete');
    Route::post('/message/reply/{id}',[contactController::class,'reply_message'])->name('message.reply');

     

    Route::group(['prefix' => 'selling-history'], function () {

        //pending order start
        Route::get('/pending', [orderController::class, 'index'])->name('pending.show');
        Route::get('/show-invoice/{order:id}', [orderController::class, 'showInvoice'])->name('invoice.show');
        Route::get('/confirmed-order/{order:id}', [orderController::class, 'confirmOrder'])->name('confirm-order');
        //pending order end

        //confirmed order start
        Route::get('/confirmed', [orderController::class, 'confirmed'])->name('confirmed.show');
        Route::get('/show-confirmed-invoice/{order:id}', [orderController::class, 'showConfirmedInvoice'])->name('confirmed.invoice.show');
        Route::get('/delivered-order/{order:id}', [orderController::class, 'deliveredOrder'])->name('delivered-order');
        //confirmed order end

        //delivered order show start
        Route::get('/confirmed', [reservationController::class, 'confirmed'])->name('confirmed.show');
        Route::get('/show-delivered-invoice/{order:id}', [orderController::class, 'showDeliveredInvoice'])->name('delivered.invoice.show');
        //delivered order show end

        //cancelled order
        Route::get('/cancel', [orderController::class, 'cancel'])->name('cancel.show');
        Route::get('/show-cancel-invoice/{order:id}', [orderController::class, 'showCancelInvoice'])->name('cancel.invoice.show');
        Route::get('/cancelled-order/{order:id}', [orderController::class, 'cancelledOrder'])->name('cancelled-order');
    });
    Route::get('/excel', [frontendController::class, 'export'])->name('download_today');
    Route::post('/export/pick', [frontendController::class, 'exportToDateFromDate'])->name('report_picker');
    Route::post('/export/pick/custom', [frontendController::class, 'exportcustom'])->name('report_picker.custom');
});




Route::post('sslcommerz/success',[reservationController::class,'SSLSuccess']);
Route::post('sslcommerz/failed',[reservationController::class,'SSLFailed']);
Route::post('sslcommerz/cancel',[reservationController::class,'SSLCancel']);
Route::post('sslcommerz/ipn',[reservationController::class,'SSLIpn']);

