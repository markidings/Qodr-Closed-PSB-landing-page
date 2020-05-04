<?php
\Debugbar::disable();

Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();

Route::get('cekmoota', 'CekMoota@index');

// register reseller
Route::resource('formreseller', 'FormResellerController');

// detail mitra from wp
Route::get('/detail-mitra/{id}', 'DetailMitraController@index');

//poster
Route::get('/greetingcards/{nota}', 'PosterController@greeting')->name('greeting');
Route::get('/cut/{nota}', 'PosterController@cut')->name('cut');
Route::get('/delivery/{nota}', 'PosterController@delivery')->name('delivery');

// form booking
Route::get('/formbooking/{id}', 'BookingController@index');
Route::get('/fullformbooking/{id}', 'BookingController@edit')->name('fullformbooking.edit');
Route::post('/fullformbooking/update/{id}', 'BookingController@update');
Route::resource('formbooking', 'BookingController');
Route::get('/cari/{title}', 'BookingController@loadData');
Route::get('/successbooking', 'BookingController@success');

//search promo
Route::get('/partnercari/{title}', 'PartnerBookingController@loadData');


//register partner
Route::get('register/partner', 'RegisterPartnerController@create')->name('register-partner');
Route::post('register/partner', 'RegisterPartnerController@store')->name('register-partner.store');

// profit mitra
Route::get('/dashboard/detailpaket/{id}', 'ProfitMitraController@listpaket');
Route::post('/dashboard/list/update/{id}', 'ProfitMitraController@update');

Route::post('/dashboard/update/{id}', 'ProfitResellerController@update');
Route::get('/dashboard/profitReseller/edit', 'ProfitResellerController@edit')->name('profit.edit');

//filter by month and year
Route::get('/sorting/{month}/{year}', 'AdminCSBookingController@load');
Route::get('/weeksortingadmincs/{week}/{year}', 'AdminCSBookingController@loadweek');
Route::get('/sortingDP/{month}/{year}', 'AdminCSBookingDpController@load');
Route::get('/weeksortingadmincsDP/{week}/{year}', 'AdminCSBookingDpController@loadweek');
Route::get('/sortingCompleted/{month}/{year}', 'AdminCSBookingDpController@loadCompleted');
Route::get('/weeksortingadmincsCompleted/{week}/{year}', 'AdminCSBookingDpController@loadweekCompleted');
Route::get('/weeksorting/{week}/{year}', 'AdminBookingController@load');
Route::get('/sortingmitra/{month}/{year}', 'AdminBookingController@loadmonth');
//mitra
Route::get('/weeksortingdpm/{week}/{year}', 'AdminBookingDpController@load');
Route::get('/monthsortingdpm/{month}/{year}', 'AdminBookingDpController@loadmonth');
Route::get('/weeksortingpo/{week}/{year}', 'AdminBookingDpController@loadpaidoff');
Route::get('/monthsortingpo/{month}/{year}', 'AdminBookingDpController@loadmonthpaidoff');

//filter by date report profit
Route::get('/weeksortingprofit/{week}/{year}', 'ProfitReportController@loadweek');
Route::get('/sortingprofit/{month}/{year}', 'ProfitReportController@load');
Route::get('/sortingdayprofit/{day}', 'ProfitReportController@loadday');


Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth'
], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Packet
    Route::group(['prefix' => 'paket', 'as' => 'paket.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'PaketController@index']);
        Route::post('/store', ['as' => 'store', 'uses' => 'PaketController@store']);
        Route::get('/all', ['as' => 'all', 'uses' => 'PaketController@all']);
        Route::delete('/{id}/destroy', ['as' => 'destroy', 'uses' => 'PaketController@destroy']);
        Route::get('/{id}/show', ['as' => 'show', 'uses' => 'PaketController@show']);
        Route::put('/{id}/update', ['as' => 'update', 'uses' => 'PaketController@update']);
        Route::get('/{val}/search', ['as' => 'search', 'uses' => 'PaketController@search']);
    });

    // Admin Packet
    Route::group(['prefix' => 'adminPacket', 'as' => 'adminPacket.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'AdminPacketController@index']);
        Route::post('/store', ['as' => 'store', 'uses' => 'AdminPacketController@store']);
        Route::get('/all', ['as' => 'all', 'uses' => 'AdminPacketController@all']);
        Route::delete('/{id}/{img}/destroy', ['as' => 'destroy', 'uses' => 'AdminPacketController@destroy']);
        Route::get('/{id}/show', ['as' => 'show', 'uses' => 'AdminPacketController@show']);
        Route::get('/showPartner', ['as' => 'showPartner', 'uses' => 'AdminPacketController@showPartner']);
        Route::post('/{id}/update', ['as' => 'update', 'uses' => 'AdminPacketController@update']);
        Route::get('/{val}/search', ['as' => 'search', 'uses' => 'AdminPacketController@search']);
    });

    // Broadcast
    Route::group(['prefix' => 'broadcast', 'as' => 'broadcast.'], function () {
        Route::post('/store', ['as' => 'store', 'uses' => 'BroadcastController@store']);
        Route::post('/storeAll', ['as' => 'storeAll', 'uses' => 'BroadcastController@storeAll']);
        Route::post('/storeRole', ['as' => 'storeRole', 'uses' => 'BroadcastController@storeRole']);
    });

    // Report Client Admin CS
    Route::group(['prefix' => 'report-client', 'as' => 'report-client.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'AdminCSBookingDpController@indexCompleted']);
        Route::post('/update', ['as' => 'update', 'uses' => 'AdminCSBookingDpController@update']);
        Route::post('/cancel', ['as' => 'cancel', 'uses' => 'AdminCSBookingDpController@cancel']);
        Route::post('/updateCompleted', ['as' => 'updateCompleted', 'uses' => 'AdminCSBookingDpController@updateCompleted']);
        Route::get('/edit', ['as' => 'edit', 'uses' => 'AdminCSBookingController@edit']);
        Route::post('/store', ['as' => 'store', 'uses' => 'AdminCSBookingController@update']);
    });

    // Report Client Mitra
    Route::group(['prefix' => 'report-partner', 'as' => 'report-partner.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'AdminBookingDpController@index']);
        Route::post('/update', ['as' => 'update', 'uses' => 'AdminBookingDpController@update']);
        Route::post('/updateCompleted', ['as' => 'updateCompleted', 'uses' => 'AdminBookingDpController@updateCompleted']);
        Route::get('/completed', ['as' => 'completed', 'uses' => 'AdminBookingDpController@indexCompleted']);
        Route::post('/cancel', ['as' => 'cancel', 'uses' => 'AdminBookingDpController@cancel']);
    });

    // Report Client Mitra
    Route::group(['prefix' => 'partnerBookingForm', 'as' => 'partnerBookingForm.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'PartnerBookingController@index']);
        Route::post('/store', ['as' => 'store', 'uses' => 'PartnerBookingController@store']);
        Route::get('/show', ['as' => 'show', 'uses' => 'PartnerBookingController@show']);
    });

    // Report Profit
    Route::group(['prefix' => 'profitReport', 'as' => 'profitReport.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'ProfitReportController@index']);
        Route::get('/indexpartner', ['as' => 'indexpartner', 'uses' => 'ProfitReportController@indexpartner']);
        Route::get('/edit', ['as' => 'edit', 'uses' => 'ProfitReportController@edit']);
        Route::put('/update', ['as' => 'update', 'uses' => 'ProfitReportController@update']);
    });


    Route::resource('broadcast', 'BroadcastController');
    Route::resource('paket', 'PaketController');
    Route::resource('partners', 'PartnerController');
    Route::resource('cities', 'CityController');
    Route::resource('snacks', 'SnackController');
    Route::resource('brochures', 'BrochureController');
    Route::resource('resellers', 'ResellerController'); 
    Route::resource('adminbookings', 'AdminBookingController');
    Route::resource('user', 'UserController');
    Route::resource('admin-cs-bookings', 'AdminCSBookingController');
    Route::resource('admin-cs-bookings-dp', 'AdminCSBookingDpController');
    Route::resource('promos', 'PromoController');
    Route::resource('profitMitra', 'ProfitMitraController');
    Route::resource('profitReseller', 'ProfitResellerController');
    // Route::resource('profitReport', 'ProfitReportController');
    // Route::resource('partnerBookingForm', 'PartnerBookingController');

    Route::get('partnerBooking', 'ProfilePartnerController@index')->name('profile-partner');

    Route::get('profitReseller', 'ProfitResellerController@index')->name('profitReseller');
    Route::put('profitReseller', 'ProfitResellerController@update')->name('profitReseller.update');


    // profit mitra
    Route::get('/list', 'ProfitMitraController@list')->name('profitMitra.list');

    // profil mitra
    Route::get('profile/partner', 'ProfilePartnerController@index')->name('profile-partner');
    Route::get('profile/partner/edit', 'ProfilePartnerController@edit')->name('profile-partner.edit');
    Route::put('profile/partner', 'ProfilePartnerController@update')->name('profile-partner.update');

    // shipping cost
    Route::get('shipping-cost', 'ShippingCostController@index')->name('shipping-cost');
    Route::get('shipping-cost/edit', 'ShippingCostController@edit')->name('shipping-cost.edit');
    Route::put('shipping-cost', 'ShippingCostController@update')->name('shipping-cost.update');

    Route::resource('message-templates', 'MessageTemplateController');
    Route::resource('message-histories', 'MessageHistoriesController');

    // setting -> bank account
    Route::get('setting/bank-account', 'SettingBankAccountController@index')->name('setting.bank-account');
    Route::get('setting/bank-account/edit', 'SettingBankAccountController@edit')->name('setting.bank-account.edit');
    Route::put('setting/bank-account', 'SettingBankAccountController@update')->name('setting.bank-account.update');

    // purchase confirms
    Route::resource('purchase-confirms', 'PurchaseConfirmController');
    Route::resource('purchase-confirms-partner', 'PurchaseConfirmPartnerController');

    // prospects
    Route::resource('prospects', 'ProspectController');
});
