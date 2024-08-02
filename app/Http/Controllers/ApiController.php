<?php

namespace App\Http\Controllers;

use App\Models\LearningProgram;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Intervention\Image\Facades\Image;


class ApiController extends Controller
{
    public function storeImage(Request $request) {
        if ($request->image) {
            $fileName = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('uploads', $fileName, 'public');

            return response()->json([
                'message' => "Успешно",
                'url' => $fileName,
                'fullUrl' => '/storage/' . $filePath,
            ], 200);
        } else {
            return response()->json([
                'message' => "Ошибка при сохранении изображения"
            ], 500);
        }
    }

    public function getActivityByDate(Request $request) {

        $res = [];

        for($month = 1; $month <= 12; $month++) {
            $date = Carbon::createFromDate($request->year, $month, 01);
            $dateSQL = $date->format('Y-m');

            $activities = DB::table('activity_log')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count_activity'))
                ->whereBetween('created_at', [$dateSQL . '-01', $dateSQL . '-31'])
                ->groupBy('date')
                ->pluck('count_activity', 'date');


            $countDays = $date->daysInMonth;
            $monthName = Str::ucfirst($date->translatedFormat('F'));



            $i = 0;
            $resMonth = [];
            while ($i < $countDays) {
                $x = $i + 1;
                $currentDate = Carbon::createFromDate($request->year, $request->month, $x)->format('Y-m-d');

                if (isset($activities[$currentDate]))
                    $y = $activities[$currentDate];
                else
                    $y = 0;

                $resMonth[] = [
                    'x' => $x,
                    'y' => $y,
                ];

                $i++;
            }

            $res[] = [
                'name' => $monthName,
                'data' => $resMonth,
            ];
        }

        return json_encode($res);
    }

    public function upload(Request $request) {

        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();

            $fileName = time().'.'.$extension;

            if (!File::isDirectory(public_path('files'))) {
                File::makeDirectory(public_path('files'));
            }

            if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'webp') {
                $image = Image::make($request->file('upload'));
                $image->save(public_path('files/' . $fileName), 50, $extension);
            } else {
                $request->file('upload')->move(public_path('files/'), $fileName);
            }




            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('files/'.$fileName);
            $msg = 'Файл был успешно загружено';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function getCountQuestions($lp)
    {
        $learningProgram = LearningProgram::find($lp);

        if (!$learningProgram) return response()->json([
            'code' => 500,
            'message' => "Учебная программа не найдена",
            'countQ' => 0
        ], 500);


        if (!$learningProgram->themes->count()) return response()->json([
            'code' => 200,
            'message' => "Вопросов не найдно",
            'countQ' => 0
        ], 200);

        $countQuestions = 0;

        foreach ($learningProgram->themes as $theme) {
            if (!$theme->activities->count()) continue;
            foreach ($theme->activities as $activity) {
                if ($activity->type_id == getIdTypeQuiz()) {
                    $countQuestions += $activity->questions->count();
                }
            }
        }

        return response()->json([
            'code' => 200,
            'message' => "Вопросов в учебной программе",
            'countQ' => $countQuestions
        ], 200);
    }
}
