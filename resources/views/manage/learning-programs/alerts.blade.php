{{--<div class="modal fade" id="createTheme" tabindex="-1" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title w-100 text-center" id="createThemeTitle">Добавление темы</h5>--}}
{{--                <button--}}
{{--                    type="button"--}}
{{--                    class="btn-close"--}}
{{--                    data-bs-dismiss="modal"--}}
{{--                    aria-label="Close"--}}
{{--                ></button>--}}
{{--            </div>--}}
{{--            <div class="modal-body text-center pb-0 pt-4">--}}
{{--                <h3>Удалить выбранные данные?</h3>--}}
{{--                <p class="text-muted">Удаление может привести к нарушению целостности данных</p>--}}
{{--            </div>--}}
{{--            <div class="modal-footer justify-content-center mt-0">--}}
{{--                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">--}}
{{--                    Закрыть--}}
{{--                </button>--}}
{{--                <button type="button" class="btn btn-success">Сохранить</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}



<div class="offcanvas offcanvas-end" id="add-new-record" aria-modal="true" role="dialog">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Новая тема</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form class="add-new-record pt-0 row g-2" id="form-add-new-theme">
            @csrf

            <div class="col-sm-12 mt-3">
                <label class="switch align-items-center">
                    <input type="checkbox" class="switch-input switch-show" name="isExisting">
                    <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    <span class="switch-label">Добавить существующую тему</span>
                </label>
            </div>

            <div class="col-sm-12 mt-3 d-none" id="select-theme">
                <div>
                    <label for="theme_id" class="form-label">Выберите тему<sup class="text-danger">*</sup></label>
                    <select id="theme_id" name="theme_id" class="select2 form-select @if($errors->has('theme_id')) is-invalid @endif">
                        @foreach($themes as $item)
                            <option value="{{$item->id}}">{{$item->name}}
                                @if (count($item->learningPrograms))
                                    (Уч. программа(ы) -
                                    @foreach($item->learningPrograms as $learningProgram)
                                        {{$learningProgram->name}}
                                    @endforeach
                                    )
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text text-danger">
                        @if($errors->has('theme_id'))
                            @foreach($errors->get('theme_id') as $message)
                                {{$message}}<br>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-sm-12 mt-3" id="name-theme">
                <label class="form-label" for="name">Наименование</label>
                <div>
                    <input type="text" id="name" class="form-control name" name="name" placeholder="Техническая документация...">
                </div>
            </div>

            <div class="col-sm-12 mt-3">
                <button type="submit" class="btn btn-success me-sm-2 me-1">Сохранить</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Отмена</button>
            </div>
        </form>
    </div>
</div>

<div class="offcanvas offcanvas-end" id="edit-record" aria-modal="true" role="dialog">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Редактирование темы - <span></span></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form class="edit-record pt-0 row g-2" id="form-edit-theme">
            <div class="col-sm-12">
                <label class="form-label" for="name">Наименование</label>
                <div>
                    <input type="text" id="name" class="form-control name" name="name" placeholder="Техническая документация...">
                    <input type="hidden" id="name-hidden">
                    <input type="hidden" id="theme-id">
                </div>
            </div>

            <div class="col-sm-12 mt-3">
                <button type="submit" class="btn btn-success me-sm-2 me-1">Сохранить</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Отмена</button>
            </div>
        </form>
    </div>
</div>
