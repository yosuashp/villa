<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {
    Route::post('paypal', 'Paypal\ProcessController@ipn')->name('Paypal');
    Route::get('paypal-sdk', 'PaypalSdk\ProcessController@ipn')->name('PaypalSdk');
    Route::post('perfect-money', 'PerfectMoney\ProcessController@ipn')->name('PerfectMoney');
    Route::post('stripe', 'Stripe\ProcessController@ipn')->name('Stripe');
    Route::post('stripe-js', 'StripeJs\ProcessController@ipn')->name('StripeJs');
    Route::post('stripe-v3', 'StripeV3\ProcessController@ipn')->name('StripeV3');
    Route::post('skrill', 'Skrill\ProcessController@ipn')->name('Skrill');
    Route::post('paytm', 'Paytm\ProcessController@ipn')->name('Paytm');
    Route::post('payeer', 'Payeer\ProcessController@ipn')->name('Payeer');
    Route::post('paystack', 'Paystack\ProcessController@ipn')->name('Paystack');
    Route::post('voguepay', 'Voguepay\ProcessController@ipn')->name('Voguepay');
    Route::get('flutterwave/{trx}/{type}', 'Flutterwave\ProcessController@ipn')->name('Flutterwave');
    Route::post('razorpay', 'Razorpay\ProcessController@ipn')->name('Razorpay');
    Route::post('instamojo', 'Instamojo\ProcessController@ipn')->name('Instamojo');
    Route::get('blockchain', 'Blockchain\ProcessController@ipn')->name('Blockchain');
    Route::get('blockio', 'Blockio\ProcessController@ipn')->name('Blockio');
    Route::post('coinpayments', 'Coinpayments\ProcessController@ipn')->name('Coinpayments');
    Route::post('coinpayments-fiat', 'Coinpayments_fiat\ProcessController@ipn')->name('CoinpaymentsFiat');
    Route::post('coingate', 'Coingate\ProcessController@ipn')->name('Coingate');
    Route::post('coinbase-commerce', 'CoinbaseCommerce\ProcessController@ipn')->name('CoinbaseCommerce');
    Route::get('mollie', 'Mollie\ProcessController@ipn')->name('Mollie');
    Route::post('cashmaal', 'Cashmaal\ProcessController@ipn')->name('Cashmaal');
    Route::post('authorize-net', 'AuthorizeNet\ProcessController@ipn')->name('AuthorizeNet');
    Route::post('2check-out', 'TwoCheckOut\ProcessController@ipn')->name('TwoCheckOut');
    Route::post('mercado-pago', 'MercadoPago\ProcessController@ipn')->name('MercadoPago');
});

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //Property and Room
        Route::get('properties', 'PropertyController@properties')->name('property.index');
        Route::get('property/create', 'PropertyController@create')->name('property.create');
        Route::post('property/store', 'PropertyController@saveProperty')->name('property.store');
        Route::get('property/edit/{id}', 'PropertyController@edit')->name('property.edit');
        Route::post('property/update/{id}', 'PropertyController@saveProperty')->name('property.update');

         //Room Category
         Route::get('room-categories', 'RoomCategoryController@roomCategories')->name('property.room.category.index');
         Route::get('{property}/{id}/room-categories/', 'RoomCategoryController@roomCategoriesByProperty')->name('property.room.category.property');
         Route::get('room-category/create', 'RoomCategoryController@create')->name('property.room.category.create');
         Route::post('room-category/store', 'RoomCategoryController@store')->name('property.room.category.store');
         Route::get('room-category/edit/{id}', 'RoomCategoryController@edit')->name('property.room.category.edit');
         Route::post('room-category/update/{id}', 'RoomCategoryController@update')->name('property.room.category.update');


        //Location
        Route::get('locations', 'LocationController@locations')->name('location.index');
        Route::post('location/store', 'LocationController@saveLocation')->name('location.store');
        Route::post('location/update/{id}', 'LocationController@saveLocation')->name('location.update');

        //Property Type
        Route::get('property-types', 'PropertyTypeController@propertiesType')->name('type.property.index');
        Route::post('property-types/store', 'PropertyTypeController@savePropertyType')->name('type.property.store');
        Route::post('property-types/update/{id}', 'PropertyTypeController@savePropertyType')->name('type.property.update');


        //Amenity
        Route::get('amenities', 'AmenityController@amenities')->name('amenity.index');
        Route::post('amenity/store', 'AmenityController@saveAmenity')->name('amenity.store');
        Route::post('amenity/update/{id}', 'AmenityController@saveAmenity')->name('amenity.update');

        //Notification
        Route::get('notifications','AdminController@notifications')->name('notifications');
        Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
        Route::get('notifications/read-all','AdminController@readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report','AdminController@requestReport')->name('request.report');
        Route::post('request-report','AdminController@reportSubmit');

        Route::get('system-info','AdminController@systemInfo')->name('system.info');


        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');
        Route::get('users/with-balance', 'ManageUsersController@usersWithBalance')->name('users.with.balance');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
        Route::get('user/tickets/{id}', 'ManageUsersController@tickets')->name('users.tickets');
        Route::get('user/payments/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/payments/via/{method}/{type?}/{userId}', 'ManageUsersController@depositViaMethod')->name('users.deposits.method');
        Route::get('user/booked-properties/{id}', 'ManageUsersController@bookedProperties')->name('users.booked.properties');
        Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');

        // Owners Manager
        Route::get('owners', 'ManageOwnersController@allOwners')->name('owners.all');
        Route::get('owners/active', 'ManageOwnersController@activeOwners')->name('owners.active');
        Route::get('owners/banned', 'ManageOwnersController@bannedOwners')->name('owners.banned');
        Route::get('owners/email-verified', 'ManageOwnersController@emailVerifiedOwners')->name('owners.email.verified');
        Route::get('owners/email-unverified', 'ManageOwnersController@emailUnverifiedOwners')->name('owners.email.unverified');
        Route::get('owners/sms-unverified', 'ManageOwnersController@smsUnverifiedOwners')->name('owners.sms.unverified');
        Route::get('owners/sms-verified', 'ManageOwnersController@smsVerifiedOwners')->name('owners.sms.verified');
        Route::get('owners/with-balance', 'ManageOwnersController@ownersWithBalance')->name('owners.with.balance');

        Route::get('owners/{scope}/search', 'ManageOwnersController@search')->name('owners.search');
        Route::get('owner/detail/{id}', 'ManageOwnersController@detail')->name('owners.detail');
        Route::post('owner/update/{id}', 'ManageOwnersController@update')->name('owners.update');
        Route::post('owner/add-sub-balance/{id}', 'ManageOwnersController@addSubBalance')->name('owners.add.sub.balance');
        Route::get('owner/send-email/{id}', 'ManageOwnersController@showEmailSingleForm')->name('owners.email.single');
        Route::post('owner/send-email/{id}', 'ManageOwnersController@sendEmailSingle')->name('owners.email.single');
        Route::get('owner/login/{id}', 'ManageOwnersController@login')->name('owners.login');
        Route::get('owner/transactions/{id}', 'ManageOwnersController@transactions')->name('owners.transactions');
        Route::get('owner/properties/{id}', 'ManageOwnersController@properties')->name('owners.properties');
        Route::get('owner/payments/via/{method}/{type?}/{ownerId}', 'ManageOwnersController@depositViaMethod')->name('owners.deposits.method');
        Route::get('owner/withdrawals/{id}', 'ManageOwnersController@withdrawals')->name('owners.withdrawals');
        Route::get('owner/withdrawals/via/{method}/{type?}/{ownerId}', 'ManageOwnersController@withdrawalsViaMethod')->name('owners.withdrawals.method');


        // User Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');
        Route::get('users/email-log/{id}', 'ManageUsersController@emailLog')->name('users.email.log');
        Route::get('users/email-details/{id}', 'ManageUsersController@emailDetails')->name('users.email.details');

        // Owner Login History
        Route::get('owners/login/history/{id}', 'ManageOwnersController@ownerLoginHistory')->name('owners.login.history.single');

        Route::get('owners/send-email', 'ManageOwnersController@showEmailAllForm')->name('owners.email.all');
        Route::post('owners/send-email', 'ManageOwnersController@sendEmailAll')->name('owners.email.send');
        Route::get('owners/email-log/{id}', 'ManageOwnersController@emailLog')->name('owners.email.log');
        Route::get('owners/email-details/{id}', 'ManageOwnersController@emailDetails')->name('owners.email.details');


        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');


        // Deposit Gateway
        Route::name('gateway.')->prefix('gateway')->group(function(){
            // Automatic Gateway
            Route::get('automatic', 'GatewayController@index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'GatewayController@edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'GatewayController@update')->name('automatic.update');
            Route::post('automatic/remove/{code}', 'GatewayController@remove')->name('automatic.remove');
            Route::post('automatic/activate', 'GatewayController@activate')->name('automatic.activate');
            Route::post('automatic/deactivate', 'GatewayController@deactivate')->name('automatic.deactivate');


            // Manual Methods
            Route::get('manual', 'ManualGatewayController@index')->name('manual.index');
            Route::get('manual/new', 'ManualGatewayController@create')->name('manual.create');
            Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');
            Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate');
            Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
        });


        // DEPOSIT SYSTEM
        Route::name('deposit.')->prefix('payment')->group(function(){
            Route::get('/', 'DepositController@deposit')->name('list');
            Route::get('pending', 'DepositController@pending')->name('pending');
            Route::get('rejected', 'DepositController@rejected')->name('rejected');
            Route::get('approved', 'DepositController@approved')->name('approved');
            Route::get('successful', 'DepositController@successful')->name('successful');
            Route::get('details/{id}', 'DepositController@details')->name('details');

            Route::post('reject', 'DepositController@reject')->name('reject');
            Route::post('approve', 'DepositController@approve')->name('approve');
            Route::get('via/{method}/{type?}', 'DepositController@depositViaMethod')->name('method');
            Route::get('/{scope}/search', 'DepositController@search')->name('search');
            Route::get('date-search/{scope}', 'DepositController@dateSearch')->name('dateSearch');

        });


        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdraw')->group(function(){
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve');
            Route::post('reject', 'WithdrawalController@reject')->name('reject');


            // Withdraw Method
            Route::get('method/', 'WithdrawMethodController@methods')->name('method.index');
            Route::get('method/create', 'WithdrawMethodController@create')->name('method.create');
            Route::post('method/create', 'WithdrawMethodController@store')->name('method.store');
            Route::get('method/edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');
            Route::post('method/edit/{id}', 'WithdrawMethodController@update')->name('method.update');
            Route::post('method/activate', 'WithdrawMethodController@activate')->name('method.activate');
            Route::post('method/deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate');
        });

        // Report
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
        Route::get('report/user/login/history', 'ReportController@userLoginHistory')->name('report.user.login.history');
        Route::get('report/user/login/ipHistory/{ip}', 'ReportController@userLoginIpHistory')->name('report.user.login.ipHistory');
        Route::get('report/owner/login/history', 'ReportController@ownerLoginHistory')->name('report.owner.login.history');
        Route::get('report/owner/login/ipHistory/{ip}', 'ReportController@ownerLoginIpHistory')->name('report.owner.login.ipHistory');
        Route::get('report/email/history', 'ReportController@emailHistory')->name('report.email.history');


        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.importLang');



        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');



        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');
        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css','GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css','GeneralSettingController@customCssSubmit');


        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');


        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');



        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.test.mail');


        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsTemplate')->name('sms.template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsTemplateUpdate')->name('sms.template.global');
        Route::get('sms-template/setting','SmsTemplateController@smsSetting')->name('sms.templates.setting');
        Route::post('sms-template/setting', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.setting');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.test.sms');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');


        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {

            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Start Owner Area
|--------------------------------------------------------------------------
*/

Route::namespace('Owner')->prefix('owner')->name('owner.')->group(function(){
    Route::namespace('Auth')->group(function(){
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register')->middleware('regStatus');
        Route::post('check-mail', 'RegisterController@checkUser')->name('checkUser');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'ForgotPasswordController@codeVerify')->name('password.code.verify');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
    });

    Route::middleware('owner')->group(function(){

        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware('owner.checkStatus')->group(function(){

            Route::get('dashboard', 'OwnerController@dashboard')->name('dashboard');

            Route::get('profile', 'OwnerController@profile')->name('profile');
            Route::post('profile', 'OwnerController@profileUpdate')->name('profile.update');
            Route::get('change-password', 'OwnerController@changePassword')->name('change.password');
            Route::post('change-password', 'OwnerController@submitPassword');

            //2FA
            Route::get('twofactor', 'OwnerController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'OwnerController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'OwnerController@disable2fa')->name('twofactor.disable');

            //Property and Room
            Route::get('properties', 'PropertyController@properties')->name('property.index');
            Route::get('property/create', 'PropertyController@create')->name('property.create');
            Route::post('property/store', 'PropertyController@saveProperty')->name('property.store');
            Route::get('property/edit/{id}', 'PropertyController@edit')->name('property.edit');
            Route::post('property/update/{id}', 'PropertyController@saveProperty')->name('property.update');

            //Room Category
            Route::get('room-categories', 'RoomCategoryController@roomCategories')->name('property.room.category.index');
            Route::get('{property}/{id}/room-categories/', 'RoomCategoryController@roomCategoriesByProperty')->name('property.room.category.property');
            Route::get('room-category/create', 'RoomCategoryController@create')->name('property.room.category.create');
            Route::post('room-category/store', 'RoomCategoryController@store')->name('property.room.category.store');
            Route::get('room-category/edit/{id}', 'RoomCategoryController@edit')->name('property.room.category.edit');
            Route::post('room-category/update/{id}', 'RoomCategoryController@update')->name('property.room.category.update');

            // Withdraw
            Route::get('/withdraw', 'OwnerController@withdrawMoney')->name('withdraw');
            Route::post('/withdraw', 'OwnerController@withdrawStore')->name('withdraw.money');
            Route::get('/withdraw/preview', 'OwnerController@withdrawPreview')->name('withdraw.preview');
            Route::post('/withdraw/preview', 'OwnerController@withdrawSubmit')->name('withdraw.submit');
            Route::get('/withdraw/history', 'OwnerController@withdrawLog')->name('withdraw.history');

            // Owner Support Ticket
            Route::prefix('ticket')->group(function () {
                Route::get('/', 'TicketController@supportTicket')->name('ticket');
                Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
                Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
                Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
                Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
                Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
            });
        });

    });
});


/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/


Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
    Route::post('check-mail', 'Auth\RegisterController@checkUser')->name('checkUser');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');

            Route::get('profile-setting', 'UserController@profile')->name('profile.setting');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('change.password');
            Route::post('change-password', 'UserController@submitPassword');

            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');


            // Deposit
            Route::get('/payment', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('payment/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('payment/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('payment/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
            Route::get('payment/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('payment/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');

            //Room Booking
            Route::post('/property/rooms/confirm', 'UserController@confirmRooms')->name('room.confirm');

            Route::get('reviews', 'UserController@reviews')->name('review');
            Route::post('reviews/store', 'UserController@saveReview')->name('review.store');
            Route::post('reviews/update/{id}', 'UserController@saveReview')->name('review.update');
            Route::get('pending-reviews', 'UserController@pendingReview')->name('review.pending');
            Route::get('completed-reviews', 'UserController@completedReview')->name('review.complete');
            Route::get('properties-history', 'UserController@propertyHistory')->name('property.history');

            Route::post('property/booking', 'PropertyController@bookingProcess')->name('property.booking');

        });
    });
});

Route::get('locations', 'SiteController@locations')->name('locations');

Route::get('search-location/{location}/{slug}', 'PropertyController@propertySearch')->name('search.location.property');
Route::get('search-property-type/{propertyType}/{slug}','PropertyController@propertySearch')->name('search.property.type');

Route::get('search', 'PropertyController@propertySearch')->name('property.search');
Route::get('search-filter', 'PropertyController@propertySearchFilter')->name('property.search.ajax');

Route::get('property/{id}/{slug}', 'PropertyController@propertyDetail')->name('property');

Route::get('property/{propertyId}/{slug}/room-category/{categoryId}', 'PropertyController@roomsByCategory')->name('property.category.rooms');
Route::get('property/{propertyId}/{slug}/room-category', 'PropertyController@roomsByCategory')->name('property.category.rooms.date');

Route::post('/property/review/load', 'PropertyController@reviewLoad')->name('property.review.load');

Route::get('page/{id}/{slug}', 'SiteController@policy')->name('policy');

Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit');
Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');

Route::get('blog', 'SiteController@blogs')->name('blog');
Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');

Route::post('/subscribe', 'SiteController@subscribe')->name('subscribe');

Route::get('/{slug}', 'SiteController@pages')->name('pages');
Route::get('/', 'SiteController@index')->name('home');
