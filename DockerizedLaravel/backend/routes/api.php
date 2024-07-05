<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

    //Register
    Route::post('register', [ApiController::class,"register"]);
    Route::post('login', [ApiController::class,"login"]);
    Route::group([
    "middleware" => ["auth:sanctum"]
],function(){
    //PROFILE
    Route::get('profile', [ApiController::class,"profile"]);
    Route::get('agent/profile/{id}', [ApiController::class, 'getProfileByUserId']);
    Route::post('agent/profile', [ApiController::class, 'addProfile']);
    Route::put('agent/profile/{id}', [ApiController::class, 'updateProfile']);
    //USER
    Route::get('user', [ApiController::class,"getUser"]);
    Route::put('user/changePassword/{id}', [ApiController::class,"changePassword"]);
    //MEETINGS
    Route::post('meetings', [ApiController::class,"meetings"]);
    Route::get('activeMeeting', [ApiController::class,"activeMeeting"]);
    Route::put('meetings/{id}', [ApiController::class, "updateMeeting"]);
    Route::get('meetings/user', [ApiController::class, 'getMeetingsByUserId']);
    Route::patch('meetings/delete/{id}', [ApiController::class, 'deleteMeeting']);
    //PROSPECTS
    Route::get('prospects', [ApiController::class, 'getProspects']);
    Route::post('prospect/add', [ApiController::class, 'addProspect']);
    Route::put('prospect/update/{id}', [ApiController::class, 'updateProspect']);
    Route::patch('prospect/delete/{id}', [ApiController::class, 'deleteProspect']);
    Route::patch('prospect/presenting/{id}', [ApiController::class, 'updatePresentingProspect']);
    Route::patch('prospect/not_presenting/{id}', [ApiController::class, 'updateNotPresentingProspect']);
    Route::get('prospects/new/', [ApiController::class, 'getNewProspects']);
    Route::get('prospects/appointments/', [ApiController::class, 'getAppointments']);
    Route::get('prospect/presenting/', [ApiController::class, 'getAppointmentsPresenting']);
    Route::get('prospects/presented/', [ApiController::class, 'getPresented']);
    Route::get('prospect/appointments/today', [ApiController::class, 'getAppointmentsToday']);
    //CALENDAR
    Route::get('calendars', [ApiController::class, 'getCalendars']);
    Route::post('calendar/add', [ApiController::class, 'addCalendar']);
    Route::put('calendar/update/{id}', [ApiController::class, 'updateCalendar']);
    Route::patch('calendar/delete/{id}', [ApiController::class, 'deleteCalendar']);
    //TODO
    Route::get('todo/all', [ApiController::class, 'getAllDone_Todo']);
    Route::get('todo/pending', [ApiController::class, 'getAllPending_Todo']);   
    Route::post('todo/addTodo', [ApiController::class, 'addTodo_List']);     
    //GENERAL DETAILS
    Route::get('subscriptions', [ApiController::class,"getSubscriptions"]);
    Route::get('companies', [ApiController::class,"getCompanies"]);
    Route::get('sources', [ApiController::class,"getSources"]);
    Route::get('relationships', [ApiController::class,"getRelationships"]);
    Route::get('categories', [ApiController::class,"getCategories"]);
    Route::get('statuses', [ApiController::class,"getStatuses"]);
    //ACCOUNT
    Route::get('logout', [ApiController::class,"logout"]); 
    //MARKET SURVEY
    Route::post('market-survey/add', [ApiController::class, 'addMarketSurvey']);
});
 