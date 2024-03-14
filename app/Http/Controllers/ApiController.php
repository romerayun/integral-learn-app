<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function uploadEditorImage(Request $request) {

//        $file = Input::file('attachment');
        dd($request->files);
        if ($request->files->count()) {
            foreach ($request->files as $file) {
                $fileName = time().'_'.$file[0]->getClientOriginalName();
                echo $fileName;
                $filePath = $request->file('files')[0]->storeAs('learning_program', $fileName, 'public');
            }
        } else {
            return false;
        }



//        if ($request[0]) {

            return $filePath;

//        } else {
//            return false;
//        }
    }
}
