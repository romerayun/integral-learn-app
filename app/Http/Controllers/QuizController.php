<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{

    public function constructQuiz($id) {
        $questions = Question::where('activity_id', $id)->get();
        $checked = '';
        $numberQuestion = 1;
        return view('manage.quiz.construct', compact('questions', 'numberQuestion', 'id', 'checked'));
    }


    public function createQuiz(Request $request, $id) {

        $questions = json_decode($request->questions, true);
        $EQuestions = json_decode($request->EQuestions, true);
        $EAnswers = json_decode($request->EAnswers, true);
        $newAnswers = json_decode($request->newAnswers, true);
        $idQuestionFiles = json_decode($request->idQuestionFiles, true);



        try {
            DB::beginTransaction();
            if ($questions) {

                foreach ($questions as $key => $question) {

                    if ($request->hasFile('file' . $key)) {

                        $fileName = time().'_'.$request->file('file' . $key)->getClientOriginalName();
                        $filePath = $request->file('file' . $key)->storeAs('questions', $fileName, 'public');

                        $nameDB = $filePath;
                    } else {
                        $nameDB = null;
                    }


                    if ($question['type'] == 'radio') $type = 'r';
                    else $type = 'c';


                    $newQuestion = Question::create([
                        'text_question' => $question['question'],
                        'activity_id' => $id,
                        'image' => $nameDB,
                        'type' => $type
                    ]);


                    foreach ($question['answer'] as $answer) {

                        if (!$answer['checked']) $isCorrect = 0;
                        else $isCorrect = 1;

                        Answer::create([
                            'answer' => $answer['txtA'],
                            'isCorrect' => $isCorrect,
                            'question_id' => $newQuestion->id
                        ]);


                    }
                }
            }


            if ($EQuestions) {

                foreach ($EQuestions as $idQuestion => $value) {
                    if (isset($value['question'])) {

                        $question = Question::firstWhere('id', $idQuestion);

                        if ($question) {
                            $question->text_question = $value['question'];
                            $question->save();
                        }

                    }

                    if (isset($value['type'])) {

                        $question = Question::firstWhere('id', $idQuestion);

                        if ($question) {
                            $question->type = $value['type'];
                            $question->save();
                        }

                    }

                    if (isset($value['question']) && isset($value['type'])) {

                        $question = Question::firstWhere('id', $idQuestion);

                        if ($question) {
                            $question->text_question = $value['question'];
                            $question->type = $value['type'];
                            $question->save();
                        }

                    }

                }

            }


            if ($EAnswers) {

                foreach ($EAnswers as $idAnswer => $value) {
                    if (isset($value['value'])) {
                        $answer = Answer::firstWhere('id', $idAnswer);

                        if ($answer) {
                            $answer->answer = $value['value'];
                            $answer->save();
                        }
                    }

                    if (isset($value['check'])) {

                        if ($value['check']) $check = 1;
                        else $check = 0;

                        $answer = Answer::firstWhere('id', $idAnswer);

                        if ($answer) {
                            $answer->isCorrect = $check;
                            $answer->save();
                        }

                    }

                    if (isset($value['value']) && isset($value['type'])) {

                        if ($value['check']) $check = 1;
                        else $check = 0;

                        $answer = Answer::firstWhere('id', $idAnswer);

                        if ($answer) {
                            $answer->answer = $value['value'];
                            $answer->isCorrect = $check;
                            $answer->save();
                        }

                    }

                }

            }

            if ($newAnswers) {
                foreach ($newAnswers as $idQuestion => $value) {

                    if ($value['checked']) $check = 1;
                    else $check = 0;

                    Answer::create([
                        'answer' => $value['answer'],
                        'isCorrect' => $check,
                        'question_id' => $idQuestion
                    ]);
                }
            }


            if ($idQuestionFiles) {
                foreach ($idQuestionFiles as $idQ) {

                    if ($request->hasFile('qfile' . $idQ)) {

                        $fileName = time().'_'.$request->file('qfile' . $idQ)->getClientOriginalName();
                        $filePath = $request->file('qfile' . $idQ)->storeAs('questions', $fileName, 'public');

                        $nameDB = $filePath;

                    } else {
                        $nameDB = null;
                    }

                    $question = Question::firstWhere('id', $idQ);

                    if ($question) {
                        $question->image = $nameDB;
                        $question->save();
                    }

                }
            }


            DB::commit();
            return response()->json([
                'message' => "Успешно",
                'code' => 200,
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => "Ошибка при обновлении тестирования",
                'code' => 500,
            ], 500);
        }

    }


    public function destroyAnswer(Request $request) {
        $answer = Answer::firstWhere('id', $request->answer_id);
        if (!$answer) return response()->json([
            'message' => "При удалении вопроса произошла ошибка",
            'code' => 500,
        ], 500);
        $answer->delete();

        return response()->json([
            'message' => "Вопрос был успешно удален",
            'code' => 200,
        ], 200);
    }

    public function destroyFile(Request $request) {
        $question = Question::firstWhere('id', $request->question_id);

        if (!$question) return response()->json([
            'message' => "При удалении файла произошла ошибка",
            'code' => 500,
        ], 500);

        if ($question->image) {
            if (File::exists(public_path('storage/' .$question->image))){
                File::delete(public_path('storage/' .$question->image));
            }

            $question->image = null;
            $question->save();
        }

        return response()->json([
            'message' => "Файл был успешно удален",
            'code' => 200,
        ], 200);
    }


    public function destroyQuestion(Request $request) {
        $question = Question::firstWhere('id', $request->question_id);

        if (!$question) return response()->json([
            'message' => "При удалении вопроса произошла ошибка",
            'code' => 500,
        ], 500);

        if ($question->image) {
            if (File::exists(public_path('storage/' .$question->image))){
                File::delete(public_path('storage/' .$question->image));
            }
        }

        $question->delete();

        return response()->json([
            'message' => "Вопрос был успешно удален",
            'code' => 200,
        ], 200);
    }
}
