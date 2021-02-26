<?php 
use Illuminate\Support\Facades\Route;

Route::middleware(['check_login'])->group(function () {
    Route::get('/', 'ViewmenuController@index');

    Route::get('/about', 'AboutcompanyController@index');

    Route::group(['prefix' => 'view-menu'], function () {
        Route::get('/time-leave', 'ViewmenuController@timeLeave');

        Route::get('/kpi', 'ViewmenuController@kpi');
    });

    Route::group(['prefix' => 'dashboard'], function () {
        Route::middleware(['check_hr'])->group(function () {
            Route::get('index', 'DashboardController@index');
        });
    });

    Route::group(['prefix' => 'check-in-gps'], function () {
        Route::get('/index', 'CheckInOutController@index');

        Route::post('/create', 'CheckInOutController@create');
    });

    Route::group(['prefix' => 'staff-time'], function () {
        Route::get('/index', 'CheckInOutController@show');
    });

    Route::middleware(['check_hr'])->group(function () {
        Route::group(['prefix' => 'special-date'], function () {
            Route::get('/index', 'SpecialDateController@index');

            Route::post('/create', 'SpecialDateController@createSpecialDate');

            Route::get('/delete', 'SpecialDateController@deleteSpecialDate');

            Route::get('/detail', 'SpecialDateController@detailSpecialDate');

            Route::post('/update', 'SpecialDateController@updateSpecialDate');
        });
    });

    Route::group(['prefix' => 'time-leave'], function () {
        Route::get('/index', 'TimeleaveController@index');

        Route::post('/create', 'TimeleaveController@createTime');

        Route::get('/delete', 'TimeleaveController@deleteTime');

        Route::get('/detail', 'TimeleaveController@detailTime');

        Route::post('/update', 'TimeleaveController@updateTime');

        // Phep
        Route::post('/createLeave', 'TimeleaveController@createLeave');

        Route::get('/detailLeave', 'TimeleaveController@detailLeave');

        // Approve time leave
        Route::middleware(['check_hr_or_manager'])->group(function () {
            Route::get('/approve-time-leave', 'TimeleaveController@approveTimeLeave');

            Route::get('/detail-staff-approve', 'TimeleaveController@detailStaffApprove');

            Route::post('/approve-time-leave', 'TimeleaveController@approvedTimeLeave');

        });

        // All time leave
        Route::middleware(['check_hr'])->group(function () {
            Route::get('/all-staff-time', 'TimeleaveController@getAllStaffTime');

        });
    });

    Route::group(['prefix' => 'kpi'], function () {
        Route::get('/set-kpi', 'KpiController@setKpi');

        Route::get('/find-kpi-staff', 'KpiController@findKpiStaff');

        Route::get('/find-kpi-department', 'KpiController@findKpiDepartment');

        Route::get('/set-detail-kpi', 'KpiController@setDetailKpi');

        Route::post('/create-kpi', 'KpiController@createKpi');

        Route::get('/get-detail-kpi', 'KpiController@test');

        Route::middleware(['check_hr_or_manager'])->group(function () {
         
            Route::get('/get-list-kpi', 'KpiController@listKpi');

            Route::post('/approve-kpi', 'KpiController@approveKpi');

        });
    });
});