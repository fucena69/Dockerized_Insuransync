<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\Company;
use App\Models\Prospect;
use App\Models\Relationship;
use App\Models\Source;
use App\Models\Status;
use App\Models\Calendar;
use App\Models\MarketSurvey;
use App\Models\ToDo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class ApiController extends Controller
{
    //GENERAL DETAILS
    public function getSubscriptions(){
        try {
            // Fetch the subscriptions
            $subscription = Subscription::where('is_deleted', 0)
                                    ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Subscriptions retrieved successfully',
                'data' => $subscription
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving subscriptions',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getCompanies(){
        try {
            // Fetch the subscriptions
            $companies = Company::where('is_deleted', 0)
                                    ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Companies retrieved successfully',
                'data' => $companies
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving companies',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getSources(){
        try {
            $sources = Source::where('is_deleted', 0)
                                    ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Sources retrieved successfully',
                'data' => $sources
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving sources',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getRelationships(){
        try {
            $relationships = Relationship::where('is_deleted', 0)
                                    ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Relationships retrieved successfully',
                'data' => $relationships
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving relationships',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getCategories(){
        try {
            $categories = Category::where('is_deleted', 0)
                                    ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving categories',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getStatuses(){
        try {
            $statuses = Status::where('is_deleted', 0)
                                    ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Statuses retrieved successfully',
                'data' => $statuses
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving statuses',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    // ACCOUNT

    public function register(Request $request){
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create a profile for the newly registered user
            $profile = Profile::create([
                'user_id' => $user->id,
                'subscription' => 1, // Default subscription value
                'company' => null, // Assuming company can be null initially
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'profile' => $profile, // Include the profile data in the response
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){

        try {
            $validateUser = Validator::make($request->all(),[
                'name' => 'required',
                'password' => 'required'
             ]);
    
             if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401); 
             }

             if (!Auth::attempt($request->only(['name', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email and Password does not match with our record',
                ], 401);
             }
             $user = User::where('name', $request->name)->first();
             return response()->json([
                'status' => true,
                'message' => 'User Logged in Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken
             ], 200);
        }
        catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $th->getMessage() 
            ], 500); 
        }
    }

    public function profile(){
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profile Information',
            'data' => $userData,
            'id' => auth()->user()->id
         ], 200);
    }

    public function meetings(Request $request){

        try{
            $validateMeeting = Validator::make($request->all(),[
                'userId' => 'required',
                'clientName' => 'required',
                'occupation' => 'required',
                'age' => 'required',
                'active' => 'required'
             ]);

             if ($validateMeeting->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Meeting Validation fails',
                    'errors' => $validateMeeting->errors()
                ], 401); 
             }

            $meeting = Meeting::create([
                'userId' => $request->userId,
                'clientName' => $request->clientName,
                'occupation' => $request->occupation,
                'age' => $request->age,
                'active' => $request->active
             ]);
    
             return response()->json([
                'status' => true,
                'message' => 'Meeting Created Successfully',
                'data' => $meeting
             ], 200);
        }
        catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'Meeting Validation Error',
                'errors' => $th->getMessage() 
            ], 500); 
        }

        
    }

    public function activeMeeting(Request $request){
        try {
            // Validate the request parameters
            $validateRequest = Validator::make($request->all(), [
                'userId' => 'required|integer',
            ]);

            if ($validateRequest->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateRequest->errors()
                ], 401);
            }

            // Fetch the meetings
            $meetings = Meeting::where('userId', $request->userId)
                               ->where('active', 1)
                               ->get();

            // Check if meetings were found`
            if ($meetings->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No active meetings found for the given user ID'
                ], 200);
            }

            // Return the meetings
            return response()->json([
                'status' => true,
                'message' => 'Meetings retrieved successfully',
                'data' => $meetings['0']
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updateMeeting(Request $request, $id){ 
        try {
            // Validate the incoming request
            $validateMeeting = Validator::make($request->all(), [
                'clientName' => 'required',
                'occupation' => 'required',
                'age' => 'required|integer',
                'medicalCondition' => 'required',
                'remarks' => 'required',
                'status' => 'required|integer',
                'active' => 'required|boolean',
            ]);

            if ($validateMeeting->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Meeting Validation Failed',
                    'errors' => $validateMeeting->errors()
                ], 401);
            }

            // Find the meeting by ID
            $meeting = Meeting::find($id);

            if (!$meeting) {
                return response()->json([
                    'status' => false,
                    'message' => 'Meeting Not Found'
                ], 404);
            }

            // Update the meeting's details
            $meeting->update([
                'clientName' => $request->clientName,
                'occupation' => $request->occupation,
                'age' => $request->age,
                'medicalCondition' => $request->medicalCondition,
                'remarks' => $request->remarks,
                'status' => $request->status,
                'active' => $request->active,
                'followupDate' => $request->followupDate
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Meeting Updated Successfully',
                'data' => $meeting
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Meeting Update Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getMeetingsByUserId(Request $request) {
        try {
            // Validate the userId parameter
            $validator = Validator::make($request->all(), [
                'userId' => 'required|integer',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation fails',
                    'errors' => $validator->errors()
                ], 401);
            }
    
            // Fetch all meetings for the given userId
            $meetings = Meeting::where('userId', $request->userId)
                                ->where('is_deleted', 0)
                                ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Meetings retrieved successfully',
                'data' => $meetings
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving meetings',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteMeeting($id){
        try {
            // Find the meeting by ID
            $meeting = Meeting::find($id);

            if (!$meeting) {
                return response()->json([
                    'status' => false,
                    'message' => 'Meeting Not Found'
                ], 404);
            }

            // Update the is_deleted column to 1
            $meeting->update([
                'is_deleted' => 1
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Meeting Deleted Successfully',
                'data' => $meeting
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Meeting Deletion Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    //PROFILES

    public function addProfile(Request $request){
        try{
            $validateAgentProfile = Validator::make($request->all(),[
                'user_id' => 'required',
             ]);

             if ($validateAgentProfile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Profile Validation fails',
                    'errors' => $validateAgentProfile->errors()
                ], 401); 
             }

            $agentprofile = Profile::create([
                'user_id' => $request->user_id,
             ]);
    
             return response()->json([
                'status' => true,
                'message' => 'Profile Created Successfully',
                'data' => $agentprofile
             ], 200);
        }
        catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'Profile Validation Error',
                'errors' => $th->getMessage() 
            ], 500); 
        }

    }

    public function getProfileByUserId($id){
        try {
            // Fetch the profile for the given user_id
            $agentprofile = Profile::where('user_id', $id)
                                ->where('is_deleted', 0)
                                ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Profile retrieved successfully',
                'data' => $agentprofile[0]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving profile',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request, $id){
        try {
            // Validate the incoming request
            $validateAgentProfile = Validator::make($request->all(), [
                'fullname' => 'required',
                'agent_code' => 'required',
                'position' => 'required',
                'title' => 'required',
                'date_coded' => 'required',
                'phone' => 'required',
                'company' => 'required',
            ]);

            if ($validateAgentProfile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Profile Validation Failed',
                    'errors' => $validateAgentProfile->errors()
                ], 401);
            }

            // Find the meeting by ID
            $profile = Profile::find($id);

            if (!$profile) {
                return response()->json([
                    'status' => false,
                    'message' => 'Meeting Not Found'
                ], 404);
            }

            // Update the profile's details
            $profile->update([
                'fullname' => $request->fullname,
                'agent_code' => $request->agent_code,
                'position' => $request->position,
                'title' => $request->title,
                'date_coded' => $request->date_coded,
                'phone' => $request->phone,
                'company' => $request->company
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully',
                'data' => $profile
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Profile Update Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    //USER
    public function getUser(){
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profile Information',
            'data' => $userData,
            'id' => auth()->user()->id
         ], 200);
    }

    public function changePassword(Request $request, $id) {
        try {
            // Validate the incoming request
            $validatePassword = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed'
            ]);
    
            if ($validatePassword->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password Validation Failed',
                    'errors' => $validatePassword->errors()
                ], 200);
            }
    
            // Find the user by ID
            $user = User::find($id);
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found'
                ], 200);
            }
    
            // Check if the current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect'
                ], 200);
            }
    
            // Update the password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully',
                'data' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Password Update Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    //PROSPECTS
    public function getProspects(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch all meetings for the authenticated user
            $prospects = Prospect::where('user_id', $user->id)
                                ->where('is_deleted', 0)
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving prospects',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function addProspect(Request $request){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }

            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'age' => 'required|integer|min:0',
                'occupation' => 'required|string',
                'category' => 'required|integer',
                'source' => 'required|integer',
                'relationship' => 'required|integer',
                'status' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation fails',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Create a new prospect for the authenticated user
            $prospect = Prospect::create([
                'name' => $request->name,
                'age' => $request->age,
                'occupation' => $request->occupation,
                'category' => $request->category,
                'source' => $request->source,
                'relationship' => $request->relationship,
                'status' => $request->status,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Prospect added successfully',
                'data' => $prospect
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error adding prospect',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updateProspect(Request $request, $id){
        try {
            // Validate the incoming request
            $validateMeeting = Validator::make($request->all(), [
                'name' => 'required|string',
                'age' => 'required|integer|min:0',
                'occupation' => 'required|string',
                'category' => 'required',
                'source' => 'required',
                'relationship' => 'required',
                'status' => 'required',
                'remarks' => 'nullable|string',
                'approach_date' => 'nullable',
                'meeting_date' => 'nullable',
                'followup_date' => 'nullable',
                'processing_date' => 'nullable',
                'submitted_date' => 'nullable',
                'approved_date' => 'nullable',
                'denied_date' => 'nullable',
            ]);

            if ($validateMeeting->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Prospect Validation Failed',
                    'errors' => $validateMeeting->errors()
                ], 401);
            }

            // Find the meeting by ID
            $meeting = Prospect::find($id);

            if (!$meeting) {
                return response()->json([
                    'status' => false,
                    'message' => 'Prospect Not Found'
                ], 404);
            }

            // Update the meeting's details
            $meeting->update([
                'name' => $request->name,
                'age' => $request->age,
                'occupation' => $request->occupation,
                'category' => $request->category,
                'source' => $request->source,
                'relationship' => $request->relationship,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'approach_date' => $request->approach_date,
                'meeting_date' => $request->meeting_date,
                'followup_date' => $request->followup_date,
                'processing_date' => $request->processing_date,
                'submitted_date' => $request->submitted_date,
                'approved_date' => $request->approved_date,
                'denied_date' => $request->denied_date,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Prospect Updated Successfully',
                'data' => $meeting
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Prospect Update Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteProspect($id){
        try {
            // Find the prospect by ID
            $prospect = Prospect::find($id);

            if (!$prospect) {
                return response()->json([
                    'status' => false,
                    'message' => 'Prospect Not Found'
                ], 404);
            }

            // Update the is_deleted column to 1
            $prospect->update([
                'is_deleted' => 1
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Prospect Deleted Successfully',
                'data' => $prospect
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Prospect Deletion Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getAppointmentsToday(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }

            // Get today's date
            $today = Carbon::today()->toDateString();

            // Fetch all prospects for the authenticated user with today's meeting_date
            $prospects = Prospect::where('user_id', $user->id)
                ->where('is_deleted', 0)
                ->whereDate('meeting_date', $today)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving prospects',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getNewProspects(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch prospects for the authenticated user with status 1 or 2 and not deleted
            $prospects = Prospect::where('user_id', $user->id)
                                ->where('is_deleted', 0)
                                ->whereIn('status', [1, 2])
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving prospects',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getAppointments(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch prospects for the authenticated user with status 1 or 2 and not deleted
            $prospects = Prospect::where('user_id', $user->id)
                                ->where('is_deleted', 0)
                                ->where('status', 3)
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving prospects',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updatePresentingProspect($id){
        try {
            // Find the prospect by ID
            $prospect = Prospect::find($id);

            if (!$prospect) {
                return response()->json([
                    'status' => false,
                    'message' => 'Prospect Not Found'
                ], 404);
            }

            // Update the is_presenting column to 1
            $prospect->update([
                'is_presenting' => true
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Prospect Presenting Successfully',
                'data' => $prospect
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Prospect Presenting Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updateNotPresentingProspect($id){
        try {
            // Find the prospect by ID
            $prospect = Prospect::find($id);

            if (!$prospect) {
                return response()->json([
                    'status' => false,
                    'message' => 'Prospect Not Found'
                ], 404);
            }

            // Update the is_presenting column to 1
            $prospect->update([
                'is_presenting' => false
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Prospect Presenting Successfully',
                'data' => $prospect
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Prospect Presenting Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getAppointmentsPresenting(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch prospects for the authenticated user where is_presenting is true and not deleted
            $prospects = Prospect::where('user_id', $user->id)
                                ->where('is_deleted', 0)
                                ->where('is_presenting', true)
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving prospects',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function getPresented(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch prospects for the authenticated user with status 4-8 and not deleted
            $prospects = Prospect::where('user_id', $user->id)
                                ->where('is_deleted', 0)
                                ->whereIn('status', [4, 5, 6, 7, 8])
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving prospects',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    //CALENDAR
    public function getCalendars(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch all calendar entries for the authenticated user
            $calendars = Calendar::where('user_id', $user->id)
                                ->where('is_deleted', 0)                    
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Calendars retrieved successfully',
                'data' => $calendars
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving calendars',
                'errors' => $th->getMessage()
            ], 500);
        } 
    }

    public function addCalendar(Request $request){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }

            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'title' => 'required|string|max:255',
                'type' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation fails',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Create a new calendar entry for the authenticated user
            $calendar = Calendar::create([
                'user_id' => $user->id,
                'date' => $request->date,
                'title' => $request->title,
                'type' => $request->type,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Calendar entry added successfully',
                'data' => $calendar
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error adding calendar entry',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updateCalendar(Request $request, $id){
        try {
            // Validate the incoming request
            $validator= Validator::make($request->all(), [
                'title' => 'required|string',
                'date' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Calendar Validation Failed',
                    'errors' => $validator->errors()
                ], 401);
            }

            // Find the calendar event by ID
            $calendar = Calendar::find($id);

            if (!$calendar) {
                return response()->json([
                    'status' => false,
                    'message' => 'Calendar Not Found'
                ], 404);
            }

            // Update the meeting's details
            $calendar->update([
                'title' => $request->title,
                'date' => $request->date,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Calendar Updated Successfully',
                'data' => $calendar
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Calendar Update Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteCalendar($id){
        try {
            // Find the prospect by ID
            $calendar = Calendar::find($id);

            if (!$calendar) {
                return response()->json([
                    'status' => false,
                    'message' => 'Calendar Not Found'
                ], 404);
            }

            // Update the is_deleted column to 1
            $calendar->update([
                'is_deleted' => true
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Calendar Deleted Successfully',
                'data' => $calendar
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Calendar Deletion Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }


        //MARKET SURVEY
    public function addMarketSurvey(Request $request){
  
        try{
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'saving_often' => 'required|string',
                'savings_location' => 'required|string',
                'critical_illness_level' => 'required|string',
                'disabled_level' => 'required|string',
                'force_retirement_level' => 'required|string',
                'child_college_level' => 'required|string',
                'money_protect' => 'required|string',
                'contact_date' => 'required|date',
                'questions' => 'nullable|string',
                'name' => 'required|string',
                'gender' => 'required|string',
                'age' => 'required|integer',
                'phone_number' => 'required',
                'civil_status' => 'required|string',
                'occupation' => 'required|string',
                'remarks' => 'nullable|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation fails',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            // Create a new market survey entry for the authenticated user
            $marketSurvey = MarketSurvey::create([
                'user_id' => $user->id,
                'saving_often' => $request->saving_often,
                'savings_location' => $request->savings_location,
                'critical_illness_level' => $request->critical_illness_level,
                'disabled_level' => $request->disabled_level,
                'force_retirement_level' => $request->force_retirement_level,
                'child_college_level' => $request->child_college_level,
                'money_protect' => $request->money_protect,
                'contact_date' => $request->contact_date,
                'questions' => $request->questions,
                'name' => $request->name,
                'gender' => $request->gender,
                'age' => $request->age,
                'phone_number' => $request->phone_number,
                'civil_status' => $request->civil_status,
                'occupation' => $request->occupation,
                'remarks' => $request->remarks,
                'is_deleted' => false,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Prospect Presenting Successfully',
                'data' => $prospect
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Prospect Presenting Error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
//TODO
     
    public function getAllPending_Todo(){
        try {
            // Ensure the user is authenticated
            $user = Auth::user();
        
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Fetch all Todos for the authenticated user
            $todoLists = Todo::where('user_id', $user->id)
                                ->where('status', 0)      
                                ->get();
        
            return response()->json([
                'status' => true,
                'message' => 'Todo List retrieved successfully',
                'data' => $todoLists
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving Todo List',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}


