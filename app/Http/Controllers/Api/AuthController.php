<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\{Auth,Hash,Notification,Crypt};
use App\Http\Requests\Api\{RegisterRequest,LoginRequest};
use App\Notifications\VerifyEmail;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $data = $request->validated();
            unset($data['confirm_password']);
            $data['name'] = $data['first_name'] .' '.$data['last_name'];
            $data['password'] = Hash::make($data['password']);
            $user =User::create($data);
            if($user){
                $code = Crypt::encryptString($user->id);
                $details = [
                    'greeting' => 'Hi '.$data['name'],
                    'body' => 'Congratulations your signup successfully, please use below link to verify your email.',
                    'thanks' => 'Thank',
                    'actionText' => 'Verfiy',
                    'actionURL' => url('api/verify',$code),
                ];
          
                Notification::send($user, new VerifyEmail($details));
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return error($ex->getMessage());
        }       
        return success('User register successfully');
    }

    public function login(LoginRequest $request)
    {
        try {
            $remember = $request->remember? true : false;
            $data = $request->validated();
            $user = User::where('email', $data['email'])->first();
            if($user != null && $user->email_verified_at == null){
                return error('Please verfiy your account using verification link send on your email.');
            }
            if($user->role != 0){
                return error('Invalide credentials.');
            }
            if (Auth::attempt($data,$remember)) {
                $res = success('User login successfully');
            } else {
                $res = error('Unauthorised');
            }
        } catch (\Throwable $th) {
            return error($th->getMessage());
        }
        return $res;
    }

    public function verifyAccount($id)
    {
        $id = $code = Crypt::decryptString($id);
        try {
            $user =User::where('id',$id)->first();
            if($user == null){
                return redirect('404');
            }
            if($user->email_verified_at != null){
                return redirect('404');
            }
            $user->update(['email_verified_at' => date('Y-m-d H:i:s')]);
        } catch (\Throwable $ex) {
            return redirect('404');
        }
        return view('account-verified')->with('message','your account verified successfully.');
    }
   
}
