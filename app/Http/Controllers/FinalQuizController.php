<?php

namespace App\Http\Controllers;

use App\Models\FinalQuiz;
use App\Models\FinalQuizResult;
use App\Models\LearningProgram;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FinalQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $quizzes1 = FinalQuiz::where('isActive', 1)->orderBy('created_at', 'desc')->get();
        $quizzes2 = FinalQuiz::where('isActive', 0)->orderBy('created_at', 'desc')->get();
        $quizzes = $quizzes1->merge($quizzes2);
        return view('manage.final.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!auth()->user()->can('add final quiz')) abort(403);

        $learningPrograms = LearningProgram::all();
        return view('manage.final.create', compact('learningPrograms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('add final quiz')) abort(403);

        DB::beginTransaction();
        try {

            if ($request->learning_program_id == 0) {
                $request->session()->flash('error', 'Выберите учебную программу 😢');
                return back();
            }

            if ($request->countQuestions == 0) {
                $request->session()->flash('error', 'Создать итоговое тестирование без вопросов невозможно 😢');
                return back();
            }

            if (FinalQuiz::where('learning_program_id', $request->learning_program_id)->where('isActive', 1)->count()) {
                $request->session()->flash('error', 'Для данной учебной программы, уже создано итоговое тестирование 😢');
                return back();
            }

            $finalQuiz = FinalQuiz::create($request->all());

            $key = substr(sha1(Str::random(10) . $finalQuiz->id), 0, 6);
            $finalQuiz->key = $key;
            $finalQuiz->save();

            DB::commit();
            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back();

        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back()->withInput($request->all());
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
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth()->user()->can('delete final quiz')) abort(403);

        $fQ = FinalQuiz::firstWhere('id', $id);
        if (!$fQ) return redirect()->back()->with('danger', 'При удалении данных произошла ошибка 😢');
        $fQ->delete();
        return redirect()->back()->with('success', 'Данные успешно удалены 👍');
    }

    public function disableQuiz(string $id)
    {
        $fQ = FinalQuiz::firstWhere('id', $id);
        if (!$fQ) return redirect()->back()->with('danger', 'При закрытии теста произошла ошибка 😢');
        $fQ->isActive = 0;
        $fQ->save();
        return redirect()->back()->with('success', 'Тест успешно закрыт 👍');
    }

    public function getFinalQuiz()
    {
        return view('final-quiz.index');
    }

    public function getFinalQuizPost(Request $request)
    {
        return redirect(route('final-quiz.userPassing', ['key'=>$request->key]));
    }

    public function userQuizPassing($key) {

        $finalQuiz = FinalQuiz::where('key', $key)->where('isActive', 1)->first();

        if (!$finalQuiz) {
            return redirect()->back()->with('error', 'К сожалению, итоговое тестирование по данному коду доступа не найдено');
        }

        $result = null;
        if ($finalQuiz) {
            $result = FinalQuizResult::where('final_quiz_id', $finalQuiz->id)->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        }

        return view('final-quiz.pass', compact('key', 'finalQuiz', 'result'));
    }

    public function storeFinalQuiz($key, Request $request)
    {
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
                        if ($answer == $request->answers[$q->id]['answers'][$key]) {
                            $allAnswersRight++;
                        }
                    }

                    if ($countAnswers == $allAnswersRight) $countRightAnswer++;
                }

            }

            $res = array(
                'user_id' => Auth::user()->id,
                'final_quiz_id' => $request->final_quiz_id,
                'learning_program_id' => $request->learning_program_id,
                'answers' => json_encode($request->answers),
                'countRightAnswers' => $countRightAnswer
            );

            FinalQuizResult::create($res);

            if (checkPassedQuiz(count($request->answers), $countRightAnswer)) {
                DB::commit();
                $request->session()->flash('success', 'Тест успешно завершен 👍');
                return back();
            }

            DB::commit();
            $request->session()->flash('error', 'К сожалению тест не пройден, попробуйте пройти тест еще раз 😢');
            return back();

        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При сохранении результатов произошла ошибка 😢');
            return back();
        }

    }

    public function showResults($key)
    {
        $finalQuiz = FinalQuiz::firstWhere('key', $key);
        if (!$finalQuiz) abort(404);
        else {
            return view('manage.final.show', compact('key', 'finalQuiz'));
        }
    }

    public function showAnswers($key, $id)
    {
        $finalQuiz = FinalQuiz::firstWhere('key', $key);
        if (!$finalQuiz) abort(404);

        $finalQuizResult = FinalQuizResult::firstWhere('id', $id);
        if (!$finalQuizResult) abort(404);


        else {
            return view('manage.final.showAnswers', compact('key', 'finalQuiz', 'finalQuizResult'));
        }
    }
}
