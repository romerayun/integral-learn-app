<?php

use App\Models\LearningProgram;

const REQUIRED_RIGHT_ANSWERS = 50;

if (! function_exists('getCountHoursTheme')) {
        function getCountHoursTheme($theme_id) {

            $theme = \App\Models\Theme::firstWhere('id', $theme_id);
            if (!$theme) return 0;

            if (count($theme->activities) == 0) {
                return 0;
            } else {
                $res = 0;
                foreach ($theme->activities as $activity) {
                    $res += $activity->count_hours;
                }
            }

            return $res;

        }
    }


    if (! function_exists('getIdTypeQuiz')) {
        function getIdTypeQuiz() {
            $type = \App\Models\ActivityType::firstWhere('name', 'Тестирование');
            if (!$type) return 0;

            return $type->id;
        }
    }

    if (! function_exists('getTypeActivityLog')) {
        function getTypeActivityLog($event)
        {
            $colorsActivityLogs = [
                'created' => [
                    'color' => 'success',
                    'name' => 'Создание'
                ],
                'updated' => [
                    'color' => 'warning',
                    'name' => 'Редактирование'
                ],
                'deleted' => [
                    'color' => 'danger',
                    'name' => 'Удаление'
                ],
                'default' => [
                    'color' => 'info',
                    'name' => 'Обычное действие'
                ],
            ];

            return $colorsActivityLogs[$event];
        }
    }


    function getNameActivity($logName) {
        $models = [
            'default' => 'Стандартное действие',
            'activity' => 'Активности',
            'activity_theme' => 'Привязка активности к теме',
            'activity_type' => 'Тип активности',
            'answer' => 'Ответ на вопрос в тестировании (активность)',
            'group' => 'Группы',
            'group_lp' => 'Привязка группы к учебной программе',
            'group_user' => 'Привязка пользователей к группе',
            'learning_program' => 'Учебные программы',
            'lp_teacher' => 'Привзяка преподавателей к учебной программе',
            'learning_program_theme' => 'Привзяка тем к учебной программе',
            'permissions' => 'Права доступа',
            'question' => 'Вопросы в тестировании (активность)',
            'role' => 'Роли пользователей',
            'theme' => 'Темы учебной программы',
            'users' => 'Пользователи',
        ];

        return $models[$logName];
    }

    if (!function_exists('getMyLearningProgram')) {
        function getMyLearningProgram() {

        }
    }

    if (!function_exists('checkCompleteActivity')) {
        function checkCompleteActivity($lp, $theme, $activity) {
            return \App\Models\CompleteActivity::
                where('learning_program_id', $lp)->
                where('theme_id', $theme)->
                where('activity_id', $activity)->
                where('user_id', auth()->user()->id)->count();
        }
    }

    if (!function_exists('checkCompleteAllTheme')) {
        function checkCompleteAllTheme($lp, $theme) {

            $countActivities = \App\Models\Theme::findOrFail($theme)->activities->count();
            $countCompleteActivities = \App\Models\CompleteActivity::
                                        where('learning_program_id', $lp)->
                                        where('theme_id', $theme)->
                                        where('user_id', auth()->user()->id)->count();


            if ($countActivities == $countCompleteActivities) return ['result' => true, 'count' => $countCompleteActivities];
            else return ['result' => false, 'count' => $countCompleteActivities];

        }
    }

    if (!function_exists('prevActivity')) {
        function prevActivity($lp, $theme, $activity_id) {

            $lp = LearningProgram::firstWhere('id', $lp);

            $activities = [];
            $i = 0;
            foreach ($lp->themes as $theme) {

                foreach ($theme->activities as $activity) {
                    $activities[] = $activity;
                    if ($activity->id == $activity_id) {
                        if ($i == 0) return false;
                        else return $activities[$i-1];
                    }
                    $i++;
                }
            }

            return false;

        }
    }

        if (!function_exists('nextActivity')) {
            function nextActivity($lp, $theme, $activity_id) {

                $lp = LearningProgram::firstWhere('id', $lp);

                $activities = [];
                $i = 0;
                $temp = 0;
                foreach ($lp->themes as $theme) {

                    foreach ($theme->activities as $activity) {
                        $activities[] = $activity;
                        if ($activity->id == $activity_id) {
                            $temp = $i + 1;
                        }
                        $i++;
                    }
                }

                if (isset($activities[$temp])) {
                    return $activities[$temp];
                } else {
                    return false;
                }

//                return false;

            }
        }

        if (!function_exists('getColorQuiz')) {
            function getColorQuiz($percent) {

                if ($percent < 50) {
                    return 'danger';
                } else if ($percent < 75) {
                    return 'warning';
                } else {
                    return 'success';
                }

            }
        }

        if (!function_exists('checkPassedQuiz')) {
            function checkPassedQuiz($countQuestions, $rightAnswers) {
                $percentRightAnswers = round($rightAnswers / $countQuestions * 100);
                if ($percentRightAnswers >= REQUIRED_RIGHT_ANSWERS) {
                    return true;
                } else {
                    return false;
                }
            }
        }


        if (!function_exists('getFinalQuizByLearningProgram')) {
            function getFinalQuizByLearningProgram($lp, $countQuestions)
            {
                $learningProgram = LearningProgram::find($lp);

                if (!$learningProgram) return false;
                if (!$learningProgram->themes->count()) return false;


                $questions = [];

                foreach ($learningProgram->themes as $theme) {
                    if (!$theme->activities->count()) continue;
                    foreach ($theme->activities as $activity) {

                        if ($activity->type_id == getIdTypeQuiz()) {
                            if ($activity->questions->count()) {
                                foreach ($activity->questions as $question)
                                $questions[] = $question;
                            }
                        }
                    }
                }

                return [
                    'keys' => array_rand($questions, $countQuestions),
                    'questions' => $questions,
                ];
            }
        }

        if (!function_exists('getSuccessAndFailFinalQuiz')) {
            function getSuccessAndFailFinalQuiz($fQ)
            {
                if (count($fQ)) {
                   $success = 0;
                   $fail = 0;
                   foreach ($fQ as $item) {
                       if (checkPassedQuiz(count(json_decode($item->answers, true)), $item->countRightAnswers)) {
                           $success++;
                       } else {
                           $fail++;
                       }
                   }
                   $percentSuccess = round($success / count($fQ) * 100, 2);
                   $percentFail = round($fail / count($fQ) * 100, 2);

                   $res = "<br><span class='text-success'>Успешно сданных: $success ($percentSuccess%)</span><br><span class='text-danger'>Не сданных: $fail ($percentFail%)</span>";
                   return $res;

                } else {
                    return '';
                }
            }
        }


        if (!function_exists('getQuestionById')) {
            function getQuestionById($id)
            {
                $question = \App\Models\Question::where('id', $id)->first();
                if (!$question) return false;
                else return $question;
            }
        }


        if (!function_exists('getCompleteActivity')) {
            function getCompleteActivity($lp_id)
            {

                $learningProgram = LearningProgram::find($lp_id);

                if (!$learningProgram) return 0;
                if (!$learningProgram->themes->count()) return 0;

                $activitiesCount = 0;
                $completeActivitiesCount = 0;

                foreach ($learningProgram->themes as $theme) {
                    if (!$theme->activities->count()) continue;
                    foreach ($theme->activities as $activity) {

                        $activitiesCount++;
                        if(checkCompleteActivity($learningProgram->id, $theme->id, $activity->id)) {
                            $completeActivitiesCount++;
                        }

                    }
                }

                return round($completeActivitiesCount / $activitiesCount * 100, 2);


            }
        }
