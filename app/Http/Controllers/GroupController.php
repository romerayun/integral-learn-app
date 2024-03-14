<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroup;
use App\Models\Group;
use App\Models\GroupLearningProgram;
use App\Models\GroupUser;
use App\Models\LearningProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::paginate(20);
        return view('manage.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $learningPrograms = LearningProgram::all();
        return view('manage.groups.create', compact('learningPrograms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroup $request)
    {
        DB::beginTransaction();
        try {

            $group = Group::create($request->all());

            if (isset($request->learning_program) && count($request->learning_program)) {
                foreach ($request->learning_program as $item) {

                    GroupLearningProgram::create(
                        array(
                            'group_id' => $group->id,
                            'learning_program_id' => $item
                        )
                    );
                }
            }

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
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = Group::firstWhere('id', $id);
        if (!$group) abort(404);

        $idsLP = [];
        foreach ($group->learningPrograms as $lp) {
            $idsLP[$lp->id] = $lp->id;
        }


        $learningPrograms = LearningProgram::all();

        return view('manage.groups.edit', compact('learningPrograms', 'group', 'idsLP'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $group = Group::firstWhere('id', $id);
        if (!$group) abort(404);

        DB::beginTransaction();

        try {
            $gLP = GroupLearningProgram::where('group_id', $id);
            $group->update($request->all());

            if ($gLP->count()) {
                foreach ($gLP->get() as $item) {
                    $item->delete();
                }
            }



            if (isset($request->learning_program) && count($request->learning_program)) {
                foreach ($request->learning_program as $item) {

                    GroupLearningProgram::create(
                        array(
                            'group_id' => $group->id,
                            'learning_program_id' => $item
                        )
                    );
                }
            }

            DB::commit();
            $request->session()->flash('success', 'Данные успешно обновлены 👍');
            return back();

        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При обвновлении данных произошла ошибка 😢' . $exception);
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::firstWhere('id', $id);
        if (!$group) return redirect()->back()->with('danger', 'При удалении данных произошла ошибка 😢');
        $group->delete();
        return redirect()->back()->with('success', 'Данные успешно удалены 👍');
    }

    public function addUserToGroup($id) {
        $group = Group::firstWhere('id', $id);
        $ids = collect($group->users->toArray())->pluck('id');
        if (!$group) abort(404);
        $users = User::whereNotIn('id', $ids)->orderBy('surname', 'asc')->orderBy('name', 'asc')->get();
        return view('manage.groups.add-user', compact('users', 'id', 'group'));
    }

    public function addUserToGroupStore(Request $request, $id) {

        DB::beginTransaction();
        try {
            $group = Group::firstWhere('id', $id);
            if (!$group) abort(404);

            if (isset($request->users) && count($request->users)) {
                foreach ($request->users as $item) {

                    GroupUser::create(
                        array(
                            'group_id' => $id,
                            'user_id' => $item
                        )
                    );
                }
            }

            DB::commit();
            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back();
        }
    }

    public function destroyGroupUser($group_id, $id) {
//        dd($id);
        $groupUser = GroupUser::firstWhere('id', $id);
        if (!$groupUser) return redirect()->back()->with('danger', 'При удалении данных произошла ошибка 😢');
        $groupUser->delete();
        return redirect()->back()->with('success', 'Данные успешно удалены 👍');
    }
}
