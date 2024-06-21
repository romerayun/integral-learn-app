<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CompleteActivity;
use App\Models\LearningProgram;
use App\Models\LearningProgramTeacher;
use App\Models\LearningProgramTheme;
use App\Models\Question;
use App\Models\Result;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $users = User::role('prepodavatel')->get();

        return view('manage.learning-programs.show', compact('lp', 'themes', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lp = LearningProgram::firstWhere('id', $id);
        if (!$lp) abort(404);

        return view('manage.learning-programs.edit', compact('lp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lp = LearningProgram::firstWhere('id', $id);
        if (!$lp) abort(404);

        DB::beginTransaction();
        try {

            if ($request->plan) {
                $fileName = time().'_'.$request->plan->getClientOriginalName();
                $filePath = $request->file('plan')->storeAs('working_programs', $fileName, 'public');

                 if (!empty($lp->working_program)) {
                     Storage::disk('public')->delete($lp->working_program);
                 }

                $request->merge([
                    'working_program' => $filePath
                ]);
            }

            $lp->update($request->all());
            DB::commit();
            $request->session()->flash('success', 'Данные успешно обновлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При обновлении данных произошла ошибка 😢' . $exception );
            return back();
        }
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

    public function completeActivity(Request $request, $lp, $theme, $activity) {

        if ($activity == getIdTypeQuiz()) {
            $request->session()->flash('error', 'Завершение тестирования, возможно только при его прохождении!');
            return back();
        }

        $request->merge([
            'learning_program_id' => $lp,
            'theme_id' => $theme,
            'activity_id' => $activity,
            'user_id' => Auth::user()->id,
        ]);

        DB::beginTransaction();
        try {

            CompleteActivity::create($request->all());

            DB::commit();
            $request->session()->flash('success', 'Активность завершена 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При обновлении данных произошла ошибка 😢');
            return back();
        }

    }

    public function showActivity($lp, $theme, $activity) {
        $lp = LearningProgram::firstWhere('id', $lp);
        if (!$lp) abort(404);
        $theme = Theme::firstWhere('id', $theme);
        if (!$theme) abort(404);
        $activity = Activity::firstWhere('id', $activity);
        if (!$activity) abort(404);

        $prevAct = prevActivity($lp->id, $theme->id, $activity->id);

        if ($prevAct) {
            if(!checkCompleteActivity($lp->id, $prevAct->themes->first()->id, $prevAct->id)) {
                abort(403);
            }
        }


        return view('lp.showActivity', compact('lp', 'theme', 'activity'));


    }

    public function storeQuiz($lp, $theme, $activity, Request $request) {
//        dd($request, $lp);
        DB::beginTransaction();
        try {
            $countRightAnswer = 0;
            foreach ($request->answers as $question) {

                $q = Question::findOrFail($question['question_id']);
                $questionRight[$q->id] = $q->answers->where('isCorrect', 1)->pluck('id')->all();

                $countAnswers = count($questionRight[$q->id]);
                if ($countAnswers == count($request->answers[$q->id]['answers'])) {

                    $allAnswersRight = 0;
                    foreach ($questionRight[$q->id] as $key => $answer) {
    //                    echo 'Правильный ответ - ' .$answer . "<br>";
    //                    echo 'Ответ пользователя - ' .$request->answers[$q->id]['answers'][$key] . "<br>";
                        if ($answer == $request->answers[$q->id]['answers'][$key]) {
                            $allAnswersRight++;
                        }
                    }

                    if ($countAnswers == $allAnswersRight) $countRightAnswer++;
                }

            }

            $res = array(
                'user_id' => Auth::user()->id,
                'activity_id' => $activity,
                'answers' => json_encode($request->answers),
                'countRightAnswers' => $countRightAnswer
            );

            Result::create($res);

            if (checkPassedQuiz(count($request->answers), $countRightAnswer)) {
                $completeActivity = [
                    'learning_program_id' => $lp,
                    'theme_id' => $theme,
                    'activity_id' => $activity,
                    'user_id' => Auth::user()->id,
                ];
                CompleteActivity::create($completeActivity);

                DB::commit();
                $request->session()->flash('success', 'Тест успешно завершен 👍');
                return back();
            }

            DB::commit();
            $request->session()->flash('error', 'К сожалению тест не пройден, попробуйте пройти тест еще раз 😢');
            return back();

        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢');
            return back();
        }



    }

    public function storeTeacher(Request $request, $lp) {

        $request->merge([
            'learning_program_id' => $lp,
        ]);

        DB::beginTransaction();
        try {

            if (is_array($request->user_id)) {
                foreach ($request->user_id as $user) {
                    LearningProgramTeacher::create([
                        'user_id' => $user,
                        'learning_program_id' => $lp,
                    ]);
                }
            } else {
                LearningProgramTeacher::create($request->all());
            }


            DB::commit();
            $request->session()->flash('success', 'Преподаватель успешно прикреплен 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При обновлении данных произошла ошибка 😢');
            return back();
        }


    }
}
