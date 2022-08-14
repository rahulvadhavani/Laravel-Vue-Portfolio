<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User,BlogComment, BlogLike};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Hash,Session,Validator};

class UserController extends Controller
{
    public function logout()
    {
        try {
            Session::flush();
        } catch (\Throwable $ex) {
            return error($ex->getMessage());
        }
        return success('Logout successfully');
    }

    public function changePassword(Request $request)
    {
        $data = $request->only('password','old_password','password_confirmation');
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => ['required', function($attribute,$value,$fail){
                    if(!Hash::check($value,Auth::user()->password)){
                        $fail("Old password didn't match");
                    }
                }],
                'password' => ['required_with:old_password','confirmed']
            ]);
            if ($validator->fails()) {
                return error($validator->errors()->first(),$validator->errors());
            }
            $user = \App\Models\User::where('id',auth()->user()->id)->first();
            $validatedData['password'] = Hash::make($data['password']);
            $user->update($validatedData);
        } catch (\Throwable $ex) {
            return redirect('404');
        }
        return success('Password updated successfullly.');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->only('phone','last_name','first_name','user_name','image');
        $request->image = base64_decode($request->image);
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
                'user_name' => 'max:50',
                'file' => 'nullable|file|image|mimes:jpeg,png,gif,svg|max:2000',
            ]);
            if ($validator->fails()) {
                return error($validator->errors()->first(),$validator->errors());
            }
            $user = User::where('id',auth()->user()->id)->first();
            if($request->file != null){
                if($user->image != null){
                    $img = basename($user->image);
                    $data['image'] = $request->file->storeAs('users',$img,'userPublic');
                }else{
                    $data['image'] = $request->file->store('users','userPublic');
                }
            }
            $user->update($data);
            return success('Profile updated successfullly.');

        } catch (\Throwable $ex) {
            return error($ex->getMessage());
        }
        return view('account-verified')->with('message','your account verified successfully.');
    }

    public function getProfile(){
        $user = User::select('id','first_name','email','last_name','user_name','image','phone','name','email_verified_at')
        ->where('id', auth()->user()->id)
        ->first();
        return success('profile get successfully.',$user);
    }

    public function postComment(Request $request){
        $userid = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'blog_id' => 'required|exists:blogs,id',
            'comment' => 'required|max:900',
        ]);
        if ($validator->fails()) {
            return error($validator->errors()->first(),$validator->errors());
        }
        $data = $request->only('blog_id','comment');
        $data['user_id'] = $userid;
        BlogComment::create($data);
        $blogComment = BlogComment::where('blog_id',$data['blog_id'])->with(['user' => function($query){
            $query->select('id','image','first_name','last_name');
        }])->get();
        return success('Comment post successfully.',$blogComment);
    }

    public function postLike(Request $request){
        $userid = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'blog_id' => 'required|exists:blogs,id',
        ]);
        $data = $request->only('blog_id');
        if ($validator->fails()) {
            return error($validator->errors()->first(),$validator->errors());
        }
        $data['user_id'] = $userid;
        $like = BlogLike::firstOrCreate(['user_id' => $userid,'blog_id' => $data['blog_id']],['status' => 1]);
        if(!$like->wasRecentlyCreated){
            $like->update(['status' => !$like->status]);
        }
        $likeCount = BlogLike::where('blog_id', $data['blog_id'])->where('status',1)->count();
        $likeStatus = $like->status == 1 ? true : false;
        $data = ['like_count' => $likeCount,'like_status' => $likeStatus];
        $like = BlogLike::where(['user_id' => $userid,'blog_id' => $like->blog_id])->first();    
        return success("Blog liked successfully.",$data);
    }
   
}
