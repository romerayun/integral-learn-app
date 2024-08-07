<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'all users', 'nameRU' =>               'Доступ к разделу - Пользователи']);
        Permission::create(['name' => 'add users', 'nameRU' =>               'Добавление пользователей']);
        Permission::create(['name' => 'edit users', 'nameRU' =>              'Редактирование пользователей']);
        Permission::create(['name' => 'delete users', 'nameRU' =>            'Удаление пользователей']);
        Permission::create(['name' => 'show users', 'nameRU' =>              'Детальный просмотр пользователя']);
        Permission::create(['name' => 'import users', 'nameRU' =>            'Импорт пользователей']);
        Permission::create(['name' => 'repeat password users', 'nameRU' =>   'Повторная отправка письма подтверждения']);
        Permission::create(['name' => 'all roles', 'nameRU' =>               'Доступ к разделу - Роли пользователей']);
        Permission::create(['name' => 'add roles', 'nameRU' =>               'Добавление ролей']);
        Permission::create(['name' => 'edit roles', 'nameRU' =>              'Редактирование ролей']);
        Permission::create(['name' => 'delete roles', 'nameRU' =>            'Удаление ролей']);
        Permission::create(['name' => 'all groups', 'nameRU' =>              'Доступ к разделу - Учебные группы']);
        Permission::create(['name' => 'add groups', 'nameRU' =>              'Добавление учебных групп']);
        Permission::create(['name' => 'edit groups', 'nameRU' =>             'Редактирование учебных групп']);
        Permission::create(['name' => 'delete groups', 'nameRU' =>           'Удаление учебных групп']);
        Permission::create(['name' => 'add students groups', 'nameRU' =>     'Добавление обучающихся в учебную группу']);
        Permission::create(['name' => 'all lp', 'nameRU' =>                  'Доступ к разделу - Учебные программы']);
        Permission::create(['name' => 'add lp', 'nameRU' =>                  'Добавление учебных программ']);
        Permission::create(['name' => 'edit lp', 'nameRU' =>                 'Редактирование учебных программ']);
        Permission::create(['name' => 'delete lp', 'nameRU' =>               'Удаление учебных программ']);
        Permission::create(['name' => 'show lp', 'nameRU' =>                 'Управление структурой учебной программы']);
        Permission::create(['name' => 'edit teacher lp', 'nameRU' =>         'Управление преподавателями в учебной программе']);
        Permission::create(['name' => 'all activities', 'nameRU' =>          'Доступ к разделу - Типы активностей']);
        Permission::create(['name' => 'add activity', 'nameRU' =>            'Добавление активностей']);
        Permission::create(['name' => 'edit activity', 'nameRU' =>           'Редактирование активностей']);
        Permission::create(['name' => 'delete activity', 'nameRU' =>         'Удаление активностей']);
        Permission::create(['name' => 'all final quiz', 'nameRU' =>          'Доступ к разделу - Итоговое тестирование (управление)']);
        Permission::create(['name' => 'add final quiz', 'nameRU' =>          'Создание итогового тестирования']);
        Permission::create(['name' => 'edit final quiz', 'nameRU' =>         'Редактирование итогового тестирования']);
        Permission::create(['name' => 'delete final quiz', 'nameRU' =>       'Удаление итогового тестирования']);
        Permission::create(['name' => 'show results final quiz', 'nameRU' => 'Просмотр результатов итогового тестирования']);
        Permission::create(['name' => 'close final quiz', 'nameRU' =>        'Закрытие итогового тестирования']);
        Permission::create(['name' => 'access edu', 'nameRU' =>        'Доступ к обучению']);
    }
}
