<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function importPage() {
        return view('manage.users.import');
    }

    public function import(Request $request) {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');

            Excel::import(new UsersImport(), $file);

            return redirect()->back()->with('success', 'Файл был успешно импортирован!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $errors) {
            $res = '';
//            dd($errors->errors());
            foreach ($errors->errors() as $error) {
                $res .= "<br>- " . $error[0];
            }
            DB::rollback();
            $request->session()->flash('error', 'При импортировании данных произошла ошибка 😢' . $res);
            return back();
        }
    }
}
