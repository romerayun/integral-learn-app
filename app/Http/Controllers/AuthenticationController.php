<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Mail\RegistrationMail;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthenticationController extends Controller
{
    public function login() {
//        dd(auth()->user());
//        Session::flush();
//        Auth::logout();
        return view('auth.login');
    }

    public function registration() {
        return view('auth.register');
    }


    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
//            return redirect()->intended('dashboard')
//                ->withSuccess('You have Successfully loggedin');
//            return redirect("login")->with('success','Super');
            if(\auth()->user()->is_email_verified === 0) {
                return redirect("login")->with('error', 'К сожалению, Ваша электронная почта не подтверждена 🥺 <br><br>' . '<a href="'. route('registration.repeatEmail').'">Отправить ссылку для подтверждения</a>');
            }

            return redirect()->route('main');
        }

        return redirect("login")->with('error','Вы ввели неверный логин или пароль');
    }

    public function storeUser(Request $request) {

        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'patron' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string',
            'terms-conditions' => 'accepted'
        ]);

        DB::beginTransaction();
        try {

            $password = $validated['password'];
            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);
            $user->assignRole('student');

            $token = Str::random(64);

            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            $mailContent = [
                'token' => $token,
                'user' => $user,
                'password' => $password,
            ];

//            Auth::login($user);

            $request->session()->flash('success', 'Вы успешно зарегистрированы 🥳 <br> На Вашу электронную почту <b>' . $request->email . '</b> отправлено письмо, содержащее ссылку для подтверждения регистрации');

            Mail::to($user->email)->send(new RegistrationMail($mailContent));
            DB::commit();
            return back();


        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'К сожалению, произошла ошибка при регистрации нового пользователя 😢');
            return back();
        }

//        $request->redirect();
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Извините, адрес Вашей электронной почты не может быть идентифицирован';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();

                $message = "Ваша электронная почта успешно подтверждена, Вы можете войти в свой аккаунт";
                return redirect()->route('login')->with('success', $message);
            } else {
                $message = "Ваша электронная почта уже подтверждена, Вы можете войти в свой аккаунт";
            }
        }

        return redirect()->route('login')->with('error', $message);
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }

    public function forgot() {

        return view('auth.forgot');
    }


    public function submitForgotPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $request->session()->flash('success', 'На Вашу электронную почту <b>' . $request->email . '</b> отправлено письмо, содержащее ссылку для сброса пароля');

        Mail::to($request->email)->send(new ForgotPasswordMail($token));


        return back();
    }

    public function showResetPasswordForm($token)
    {
        $email = DB::table('password_resets')
            ->where([
                'token' => $token
            ])
            ->first();
        return view('auth.reset', ['token' => $token, 'email' => $email]);
    }


    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Произошла ошибка при обновлении пароля! Неверный токен!');
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('success', 'Ваш пароль был успешно изменен!');
    }

    public function repeatEmail() {
        return view('auth.repeat');
    }

    public function repeatEmailPost(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $user = DB::table('users')
            ->where([
                'email' => $request->email,
            ])
            ->first();

        $message = 'Адрес Вашей электронной почты не найден';

        if(!is_null($user) ){

            if($user->is_email_verified) {
                $request->session()->flash('error', 'Ваша электронная почта уже подтверждена, Вы можете войти в свой аккаунт');
                return back();
            } else {

                $userToken = UserVerify::firstWhere('user_id', $user->id);
                if (!$userToken) {
                    $token = Str::random(64);

                    UserVerify::create([
                        'user_id' => $user->id,
                        'token' => $token
                    ]);
                } else {
                    $token = $userToken->token;
                }

                $mailContent = [
                    'token' => $token,
                    'user' => $user,
                    'password' => 'Ваш пароль надежно зашифрован',
                ];
                Mail::to($user->email)->send(new RegistrationMail($mailContent));

                $request->session()->flash('success', 'На Вашу электронную почту <b>' . $user->email . '</b> отправлено письмо, содержащее ссылку для подтверждения регистрации');
                return back();
            }
        }

        return redirect()->route('login')->with('error', $message);

    }
}
