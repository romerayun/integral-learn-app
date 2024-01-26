<?php

namespace App\Imports;

use App\Mail\RegistrationMail;
use App\Models\Role;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class UsersImport implements
    toCollection,
    WithStartRow,
    WithValidation,
    SkipsOnError,
    SkipsEmptyRows



{

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }


    public function collection(Collection $collection) {
        $mailContent = [];
        try {
            foreach ($collection as $row) {
                $password = Str::random(8);
                $token = Str::random(64);

                if($row[4] == 'Мужской') $sex = 'M';
                else $sex = 'F';

                $user = User::create([
                    'surname' => $row[0],
                    'name' => $row[1],
                    'patron' => $row[2],
                    'email' => $row[3],
                    'sex' => $sex,
                    'password' => Hash::make($password),
                ]);
                $user->assignRole('student');

                UserVerify::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                $mailContent[$user->email] = [
                    'token' => $token,
                    'user' => $user,
                    'password' => $password,
                ];

//                Mail::to($user->email)->send(new RegistrationMail($mailContent));
            }
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }

        foreach ($mailContent as $email => $data) {
            Mail::to($email)->send(new RegistrationMail($data));
        }
        DB::commit();
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
//            '0' => ['required'],
//            '1' => ['required'],
//            '2' => ['required'],
            '3' => ['email', 'unique:users,email'],
        ];
    }

    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
