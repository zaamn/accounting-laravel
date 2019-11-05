<?php

// Adminentication Routes...
Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
Route::post('login', 'Admin\LoginController@login');
Route::post('logout', 'Admin\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Admin\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Admin\RegisterController@register');

//password reset
Route::get('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Admin\ResetPasswordController@reset')->name('password.update');

//email verification
Route::get('email/verify', 'Admin\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Admin\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Admin\VerificationController@resend')->name('verification.resend');

//admin routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/customer-create', 'AccountingController@createCustomer')->name('customer.create');
Route::post('/customer-store', 'AccountingController@storeCustomer')->name('customer.store');
Route::get('/product-create', 'AccountingController@createProduct')->name('product.create');
Route::post('/product-store', 'AccountingController@storeProduct')->name('product.store');
Route::get('/invoice-create', 'AccountingController@createInvoice')->name('invoice.create');
Route::post('/invoice-cart', 'AccountingController@invoiceCart')->name('invoice.cart');
Route::post('/total-count', 'AccountingController@totalCount');
Route::get('/invoiceCart-delete/{id}', 'AccountingController@invoiceCartDelete')->name('invoiceCart.delete');
Route::get('/invoiceCart-clear', 'AccountingController@invoiceCartClear')->name('invoice.clear');
Route::post('/invoice-store', 'AccountingController@invoiceStore')->name('invoice.store');
Route::get('/view-invoice', 'AccountingController@invoiceView')->name('invoice.view');
Route::get('/customer/invoice-view={id}', 'AccountingController@customerInvoiceView')->name('customer.invoice.view');
Route::get('/invoice-download={id}', 'AccountingController@invoiceDownload');

//payment routes
Route::get('payment/stripe', 'StripePaymentController@stripe');
Route::post('payment/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
