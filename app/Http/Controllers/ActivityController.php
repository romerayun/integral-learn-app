<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivity;
use App\Models\Activity;
use App\Models\ActivityTheme;
use App\Models\ActivityType;
use App\Models\LearningProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
//        return view('manage.activity.create');
    }

    public function createActivity($id)
    {

        $lp = LearningProgram::firstWhere('id', $id);
        if (!$lp) abort(404);
        $activityTypes = ActivityType::all();
        return view('manage.activity.create', compact('lp', 'activityTypes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivity $request)
    {
        DB::beginTransaction();
        try {

            $activity = Activity::create($request->all());

            if (isset($request->theme_id)) {

                $count = ActivityTheme::where('theme_id', $request->theme_id)->get()->count();

                ActivityTheme::create(
                    array(
                        'theme_id' => $request->theme_id,
                        'activity_id' => $activity->id,
                        'order' => $count + 1
                    )
                );

            }

            DB::commit();
            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back()->withInput(array('url' => $request->url));

        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back()->withInput($request->all());
        }

    }

    public function createWithTheme($idLp, $idTheme)
    {
        $lp = LearningProgram::firstWhere('id', $idLp);
        if (!$lp) abort(404);
        $activityTypes = ActivityType::all();
        return view('manage.activity.create', compact('lp', 'activityTypes', 'idTheme'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activity::firstWhere('id', $id);
        if (!$activity) abort(404);

        $activityTypes = ActivityType::all();
        return view('manage.activity.update', compact('activity', 'activityTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreActivity $request, string $id)
    {
        $activity = Activity::firstWhere('id', $id);
        if (!$activity) abort(404);
        try {
            $activity->update($request->all());
            return redirect()->back()->with('success', 'Данные успешно обновлены 👍')->withInput($request->all());
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back()->withInput($request->all());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::firstWhere('id', $id);
        if (!$activity) return response()->json([
            'message' => "При удалении темы произошла ошибка",
            'code' => 500,
        ], 500);
        $activity->delete();

        return response()->json([
            'message' => "Активность была успешно удалена",
            'code' => 200,
        ], 200);
    }


    public function updateLocation(Request $request, $theme_id) {

        try {
            DB::beginTransaction();

            $request->except(['_token']);

            foreach ($request->all() as $activity => $order) {
                $tA = ActivityTheme::where('theme_id', $theme_id)->where('activity_id', $activity)->first();
                if (!$tA) {
                    continue;
                } else {
                    $tA->order = $order;
                    $tA->save();
                }
            }
            DB::commit();

            return response()->json([
                'message' => "Успешно",
                'code' => 200,
            ], 200);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'message' => "Ошибка при обновлении активности",
                'code' => 500,
            ], 500);
        }
    }

    public function updateDoubleActivity(Request $request) {

        try {
            DB::beginTransaction();

            foreach ($request->except(['_token']) as $theme => $activity) {

                ActivityTheme::where('theme_id', $theme)->delete();
                if (count($activity) != 0) {
                    foreach ($activity as $item) {

                        if ($item == 0) continue;

                        $res = explode(' ', $item);
                        $at = new ActivityTheme();
                        $at->theme_id = $theme;
                        $at->activity_id = $res[0];
                        $at->order = $res[1];
                        $at->save();
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => "Успешно",
                'code' => 200,
            ], 200);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'message' => "Ошибка при обновлении активности" . $exception,
                'code' => 500,
            ], 500);
        }
    }

}
