<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Mail\RegistrationMail;
use App\Models\Role;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use LaravelLang\Publisher\Concerns\Has;
use Spatie\Activitylog\Models\Activity;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(20);
        return view('manage.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        dd(public_path() . '/build/assets/registration-11a622b1.png');
        $roles = Role::all();
        return view('manage.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser $request)
    {
        $role = Role::findOrFail($request->role_id);

        DB::beginTransaction();
        try {

            $password = Str::random(8);
            $token = Str::random(64);
            $request->merge([
                'password' => Hash::make($password),
                ''
            ]);

            $user = User::create($request->all());
            $user->assignRole($role->name);

            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            $mailContent = [
                'token' => $token,
                'user' => $user,
                'password' => $password,
            ];
            Mail::to($user->email)->send(new RegistrationMail($mailContent));

            DB::commit();
            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::firstWhere('id', $id);
        if (!$user) abort(404);

        $activities = Activity::where('causer_id', $user->id)->orderBy('created_at', 'desc')->limit(5)->get(); //returns the last logged activity
        return view('manage.users.show', compact('user', 'activities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::firstWhere('id', $id);
        if (!$user) abort(404);

        $roles = Role::all();
        return view('manage.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUser $request, string $id)
    {
        $userOld = User::firstWhere('id', $id);
        $sendEmail = false;
        DB::beginTransaction();
        $data = [];
        try {
            if ($userOld->email != $request->email) {
                $email = $request->email;
                $password = Str::random(8);
                $token = Str::random(64);
                $request->merge([
                    'password' => Hash::make($password),
                    'is_email_verified' => 0
                ]);

//                $userOld->removeRole($userOld->getRoleNames());
//                $userOld->roles()->detach();


                $userVerify = UserVerify::firstWhere('user_id', $id);
                if ($userVerify) {
                    $userVerify->token = $token;
                    $userVerify->save();
                } else {
                    UserVerify::create([
                        'user_id' => $userOld->id,
                        'token' => $token
                    ]);
                }

                $mailContent = [
                    'token' => $token,
                    'user' => $userOld,
                    'password' => $password,
                ];
                $sendEmail = true;
            }

            $userOld->syncRoles([]);
            $role = Role::findOrFail($request->role_id);
            $userOld->assignRole($role->name);


            $userOld->update($request->all());
            DB::commit();

            if ($sendEmail)  Mail::to($email)->send(new RegistrationMail($mailContent));

            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();

            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::firstWhere('id', $id);
        if (!$user) abort(404);
        $user->delete();
        return redirect()->back()->with('success', 'Данные успешно удалены 👍');
    }

    public function repeatPassEmail(Request $request, $id) {

        $user = User::firstWhere('id', $id);
        if (!$user) return redirect()->back()->with('error', 'При повторной отправке данных произошла ошибка');

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

        $password = Str::random(8);


        $mailContent = [
            'token' => $token,
            'user' => $user,
            'password' => $password,
        ];

        $user->password = Hash::make($password);
        $user->save();

        Mail::to($user->email)->send(new RegistrationMail($mailContent));

        return redirect()->back()->with('success', 'На электронную почту <b>' . $user->email . '</b> отправлено письмо, содержащее новый пароль и ссылку для подтверждения регистрации');
    }
}
