<?php

namespace App\Http\Controllers;

use App\Models\LearningProgram;
use App\Models\LearningProgramTheme;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            if (isset($request->isExisting)) {
                if (isset($request->learning_program_id)) {

                    $theme = Theme::firstWhere('id', $request->theme_id);
                    $count = LearningProgramTheme::where('learning_program_id', $request->learning_program_id)->get()->count();

                    LearningProgramTheme::create(
                        array(
                            'theme_id' => $request->theme_id,
                            'learning_program_id' => $request->learning_program_id,
                            'order' => $count+1
                        )
                    );

                }
            } else {
                $theme = Theme::create($request->all());

                if (isset($request->learning_program_id)) {

                    $count = LearningProgramTheme::where('learning_program_id', $request->learning_program_id)->get()->count();

                    LearningProgramTheme::create(
                        array(
                            'theme_id' => $theme->id,
                            'learning_program_id' => $request->learning_program_id,
                            'order' => $count+1
                        )
                    );

                }
            }

            DB::commit();

            if (isset($request->isExisting)) {
                $html = ' <div class="card card-action mb-4 theme" id="theme' . $theme->id . '">
                                    <div class="card-header">
                                        <div class="card-action-title">
                                            <div class="card-action-hours d-block fw-light">' . getCountHoursTheme($theme->id) . '</div>
                                            <div class="card-action-name fw-bold" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="' . $theme->name . '">' . $theme->name . '</div>
                                        </div>
                                        <div class="card-action-element">
                                            <ul class="list-inline mb-0">

                                                <li class="list-inline-item">
                                                    <a href="' . route('activity.createWithTheme', ['learning_program' => $request->learning_program_id, 'theme' => $theme->id]) . '" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Добавить активность"><i class="tf-icons bx bx-plus-circle"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="edit-theme" attr-theme="' . $theme->id . '" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Редактировать тему"><i class="tf-icons bx bx-pencil"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a attr-theme="' . $theme->id . '" class="delete-theme" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить тему"><i class="tf-icons bx bx-trash"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <div class="theme-handle">
                                                        <i class="tf-icons bx bx-move"></i>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="collapse show" style="">
                                        <div class="card-body pt-0">

                                            <div class="activities-container">
                                                <div class="empty-activity">+</div>';
                if (count($theme->activities) != 0) {
                    foreach ($theme->activities as $activity) {

                        $html .= '<div class="card card-action mb-4 activity" id="activity' . $activity->id . '">
                                                        <div class="card-header">
                                                            <div class="card-action-title fw-bold">' . $activity->name . '</div>
                                                            <div class="card-action-element">
                                                                <ul class="list-inline mb-0">

                                                                    <li class="list-inline-item">
                                                                        <a href="' . route('activity.edit', ['activity' => $activity->id]) . '" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Редактировать активность"><i class="tf-icons bx bx-pencil"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a attr-activity="' . $activity->id . '" class="delete-activity"  data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить активность" ><i class="tf-icons bx bx-trash"></i></a>

                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <div class="activity-handle">
                                                                            <i class="tf-icons bx bx-move"></i>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="collapse show" style="">
                                                            <div class="card-body pt-0 pb-3">
                                                                <div class="d-flex fs-tiny align-items-center">
                                                                    <span class="badge bg-label-' . $activity->type->color . ' activity-type">' . $activity->type->name . '</span>
                                                                    <span class="activity-hours">' . $activity->count_hours . '</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                    }
            }




                                            $html .= '</div>

                                        </div>
                                    </div>
                                </div>';
            } else {
                $html = '<div class="card card-action mb-4 theme" id="theme'.$theme->id.'">
                        <div class="card-header">
                            <div class="card-action-title">
                                <div class="card-action-hours d-block fw-light">0</div>
                                <div class="card-action-name fw-bold" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="'.$theme->name.'">'.$theme->name.'</div>

                            </div>
                            <div class="card-action-element">
                                <ul class="list-inline mb-0">

                                    <li class="list-inline-item">
                                                    <a href="'.route('activity.createWithTheme', ['learning_program' => $request->learning_program_id, 'theme' => $theme->id]).'" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Добавить активность"><i class="tf-icons bx bx-plus-circle"></i></a>
                                                </li>
                                    <li class="list-inline-item">
                                        <a class="edit-theme"><i class="tf-icons bx bx-pencil"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a attr-theme="'.$theme->id.'" class="delete-theme"><i class="tf-icons bx bx-trash"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <div class="theme-handle">
                                            <i class="tf-icons bx bx-move"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="collapse show">
                            <div class="card-body pt-0">

                                <div class="activities-container">
                                    <div class="empty-activity">+</div>
                                </div>

                            </div>
                        </div>
                    </div>';
            }


            return response()->json([
                'message' => "Успешно",
                'result' => $html,
                'code' => 200,
            ], 200);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'message' => "Ошибка при создании темы" . $exception,
                'code' => 500,
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {

        $theme = Theme::firstWhere('id', $id);
        if (!$theme) return response()->json([
            'message' => "Редактируемая тема не найдена",
            'code' => 404,
        ], 404);

        try {
            DB::beginTransaction();

            $theme->name = $request->name;
            $theme->save();
            DB::commit();

            return response()->json([
                'message' => "Успешно",
                'code' => 200,
            ], 200);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'message' => "Ошибка при обновлении темы",
                'error' => $exception,
                'e' => $request,
                'code' => 500,
            ], 500);
        }
    }

    public function destroy(Request $request, string $id)
    {

        $theme = LearningProgramTheme::where('theme_id', $id)->where('learning_program_id', $request->learning_program_id);
        if (!$theme) return response()->json([
            'message' => "При удалении темы произошла ошибка",
            'code' => 500,
        ], 500);
        $theme->delete();

        return response()->json([
            'message' => "Тема была успешно удалена",
            'code' => 200,
        ], 200);
    }


    public function updateLocation(Request $request, $idLP) {

    try {
        DB::beginTransaction();

        $request->except(['_token']);

        foreach ($request->all() as $theme => $order) {
            $tLP = LearningProgramTheme::where('theme_id', $theme)->where('learning_program_id', $idLP)->first();
            if (!$tLP) {
                continue;
            } else {
                $tLP->order = $order;
                $tLP->save();
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
            'message' => "Ошибка при обновлении темы",
            'code' => 500,
        ], 500);
    }
}
}
