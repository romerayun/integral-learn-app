<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activityTypes = ActivityType::all();

        return view('manage.activity-types.index', compact('activityTypes'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->user()->can('add activity')) abort(403);

        return view('manage.activity-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!auth()->user()->can('add activity')) abort(403);
        $validatedData = $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Поле наименование не может быть пустым',
            ]
        );

        DB::beginTransaction();
        try {
            ActivityType::create($request->all());
            DB::commit();
            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();

            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢');
            return back();
        }
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
        if(!auth()->user()->can('edit activity')) abort(403);

        $aT = ActivityType::firstWhere('id', $id);
        if (!$aT) abort(404);
        return view('manage.activity-types.update', compact('aT'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!auth()->user()->can('edit activity')) abort(403);

        $validatedData = $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Поле наименование не может быть пустым',
            ]
        );

        $aT = ActivityType::firstWhere('id', $id);
        if (!$aT) abort(404);
        $aT->update($request->all());
        return redirect()->back()->with('success', 'Данные успешно обновлены 👍');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->can('delete activity')) abort(403);

        $aT = ActivityType::firstWhere('id', $id);
        if (!$aT) return redirect()->back()->with('danger', 'При удалении данных произошла ошибка 😢');
        $aT->delete();
        return redirect()->back()->with('success', 'Данные успешно удалены 👍');
    }
}
