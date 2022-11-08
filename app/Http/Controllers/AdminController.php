<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    // change password
    public function changePassword(Request $request){
        /*
            1. all field must be fill
            2. new password and confirm password length must be greater than 6
            3. new password and confirm password must be same
            4. client old password must be same with db password
            5. password change
        */

        $this->passwordValidationCheck($request);

        $currentUserId = Auth::user()->id;

        $user = User::select('password')->where('id',$currentUserId)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword, $dbHashValue)){
            $data = [
                        'password' => Hash::make($request->newPassword)
                    ];
            User::where('id',Auth::user()->id)->update($data);

            // Auth::logout();
            // return redirect()->route('auth#loginPage');

            return back()->with(['changeSuccess'=>'Password Changed...']);
        }

        return back()->with(['notMatch'=>'the old password not match. Try Again...']);
    }

    // direct admin details page
    public function details(){
        return view('admin.account.details');
    }

    // direct admin profile page
    public function edit(){
        return view('admin.account.edit');
    }

    //update account
    public function update($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        //image
        if($request->hasFile('image')){
            // 1. old image name | check => delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Accound Updated...']);
    }

    // admin list
    public function list(){
        $admin = User::when(request('key'),function($querry){
            $querry->orWhere('name','like','%'.request('key').'%')
                    ->orWhere('email','like','%'.request('key').'%')
                    ->orWhere('gender','like','%'.request('key').'%')
                    ->orWhere('address','like','%'.request('key').'%')
                    ->orWhere('phone','like','%'.request('key').'%');
            })
            ->where('role','admin')->paginate(3);
        $admin->appends(request()->all());
        return view('admin.account.list',compact('admin'));
    }

    //admin change role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }

    // admin change update
    public function change($id,Request $request){
        $data = $this->requestUserData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    // request user data admin change update
    private function requestUserData($request){
        return [
            'role'=>$request->role
        ];
    }

    // admin list delete
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    //request user data update
    private function getUserData($request){
        return [
            'name'=> $request->name,
            'email'=> $request->email,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'updated_at'=>Carbon::now()
        ];
    }

    // account validation check
    private function accountValidationCheck(Request $request){
        Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required',
            'gender'=> 'required',
            'phone'=> 'required',
            'image'=> 'mimes:png,jpg,jpeg|file',
            'address'=> 'required'
        ])->validate();
    }

    // password validation check
    private function passwordValidationCheck(Request $request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ])->validate();
    }



    // admin ajax go to admin or user
    public function ajaxAdminList(Request $request){
        // logger($request->all());
        User::where('id',$request->adminId)->update([
            'role'=>$request->currentRole
        ]);
        return response()->json([ 'status' => 'true', 'message' => 'order completed' ], 200);
    }

    // admin ajax go to admin or user
    public function ajaxUserList(Request $request){
        logger($request->all());
        User::where('id',$request->userId)->update([
            'role'=>$request->role
        ]);
        // return response()->json([ 'status' => 'success', 'message' => 'order completed' ], 200);
    }

    // clear contact list
    public function ajaxContactList(Request $request){
        Contact::where('id',$request->contactId)
            ->delete();
    }
}
