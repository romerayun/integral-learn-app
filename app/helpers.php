<?php
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
    function getTypeActivityLog($event) {
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
}


