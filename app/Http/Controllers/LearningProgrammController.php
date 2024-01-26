<?php

namespace App\Http\Controllers;

use App\Models\LearningProgram;
use App\Models\LearningProgramTheme;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LearningProgrammController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $learningPrograms = LearningProgram::paginate(20);
        return view('manage.learning-programs.index', compact('learningPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manage.learning-programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request);

        DB::beginTransaction();
        try {

            if ($request->plan) {
                $fileName = time().'_'.$request->plan->getClientOriginalName();
                $filePath = $request->file('plan')->storeAs('working_programs', $fileName, 'public');

                $request->merge([
                    'working_program' => $filePath
                ]);
            }

            LearningProgram::create($request->all());
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
        $lp = LearningProgram::firstWhere('id', $id);
        if (!$lp) abort(404);

        $ids = collect($lp->themes->toArray())->pluck('id');
        $themes = Theme::whereNotIn('id', $ids)->orderBy('name', 'asc')->get();

        return view('manage.learning-programs.show', compact('lp', 'themes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lp = LearningProgram::firstWhere('id', $id);

        if (!$lp) abort(404);

        if ($lp->working_program) {
            if(File::exists(public_path('storage/' .$lp->working_program))){
                File::delete(public_path('storage/' .$lp->working_program));
            }
        }

        $lp->delete();
        return redirect()->back()->with('success', 'Данные успешно удалены 👍');
    }

    public function showPersonalLP() {
        return view('lp.index');
    }

    public function showDetailsLP($id) {

        $lp = LearningProgram::firstWhere('id', $id);

        if (!$lp) abort(404);

        return view('lp.detail', compact('lp'));
    }
}
