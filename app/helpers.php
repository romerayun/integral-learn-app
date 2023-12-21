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
