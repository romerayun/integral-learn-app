import $ from "jquery";

$(document).ready(function () {

    function showToast(color, title, text) {
        let toastElList = [].slice.call(document.querySelectorAll('.toast'))

        $('.toast-title').html(title);
        $('.toast').addClass('bg-'+color);
        $('.toast-body').html(text);

        let toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    function addButtons() {
        let html = '<a class="btn btn-label-secondary create-activity">Активность </a>';
        $(".buttons-container").append(html);
    }

    function destroyButtons() {
        $(".create-activity").remove();
    }


    function validateForm(name) {
        if ($(name).length) {
            let validate = new JustValidate(name, {
                    errorFieldCssClass: 'is-invalid',
                    successFieldCssClass: 'is-valid',
                    validateBeforeSubmitting: true,
                    focusInvalidField: true,
                    tooltip: {
                        position: 'top',
                    },
                },
                [
                    {
                        key: 'is required',
                        dict: {
                            Russian: 'Поле обязательно для заполенения',
                        },
                    },
                    {
                        key: 'is integer',
                        dict: {
                            Russian: 'Значение должно быть целым числом',
                        },
                    },
                    {
                        key: 'is short',
                        dict: {
                            Russian: 'Минимальное количество символов - 1',
                        },
                    },
                    {
                        key: 'is long50',
                        dict: {
                            Russian: 'Максимальное количество символов - 50',
                        },
                    },
                    {
                        key: 'is long80',
                        dict: {
                            Russian: 'Максимальное количество символов - 80',
                        },
                    },
                    {
                        key: 'error date',
                        dict: {
                            Russian: 'Выберите дату в формате ГГГГ-ММ-ДД',
                        },
                    },
                    {
                        key: 'is inn',
                        dict: {
                            Russian: 'ИНН должен состоять из 12 символов',
                        },
                    },
                    {
                        key: 'is snils',
                        dict: {
                            Russian: 'СНИЛС должен быть в формате XXX-XXX-XXX YY',
                        },
                    },
                    {
                        key: 'is phone',
                        dict: {
                            Russian: 'Номер телефона должен быть в формате +7 (ХХХ) ХХХ-ХХ-ХХ',
                        },
                    },
                ]
            );


            if ($("#name-theme:not(.d-none)").length) {
                validate.addField('.name', [
                    {
                        rule: 'minLength',
                        value: 1,
                        errorMessage: 'is short',
                    },
                    {
                        rule: 'required',
                        errorMessage: 'is required',
                    }
                ]);
            }


            validate.setCurrentLocale('Russian');
            return validate;
        }
        return null;
    }


    // console.log($(".themes-container").children());



    let offCanvasEl;

    $(".create-new").click(function () {
        validateForm('#form-add-new-theme');
        let el = document.querySelector("#add-new-record");
        setTimeout(() => {
            offCanvasEl = new bootstrap.Offcanvas(el);
            offCanvasEl.show()
        }, 200);
    });


    if ($("#form-add-new-theme").length) {
        let form = document.querySelector('#form-add-new-theme');
        form.onsubmit = function () {

            let validate2 = validateForm('#form-add-new-theme');

            validate2.revalidate().then(async isValid => {
                if (isValid) {
                    validate2 = validateForm();
                    let body = new FormData(form);
                    body.append('learning_program_id', $('#learning_program_id').val());

                    let response = await fetch('/api/store-theme', {
                        method: 'POST',
                        body: body
                    });

                    let result = await response.json();

                    if (result.code === 200) {
                        showToast('success', 'Отлично', "Тема успешно добавлена");
                        offCanvasEl.hide();
                        form.reset();

                        if ($("#count-rows").length) {
                            $(".themes-container").html(result.result);
                            addButtons();
                        } else $(".themes-container").append(result.result);

                        updateListItem();

                    } else {
                        showToast('error', 'Ошибка', "При добавлении темы произошла ошибка");
                    }
                }
            });

            return false;
        };
    }


    $(document).on("click", ".delete-theme", function (event) {
        event.preventDefault();
        $(".confirm-delete").removeAttr('del-theme');
        $(".confirm-delete").removeAttr('del-activity');
        $('#modalCenter').modal('show');
        $(".confirm-delete").attr('del-theme', $(this).attr('attr-theme'));
    });

    $(document).on("click", ".delete-activity", function (event) {
        event.preventDefault();
        $(".confirm-delete").removeAttr('del-theme');
        $(".confirm-delete").removeAttr('del-activity');
        $('#modalCenter').modal('show');
        $(".confirm-delete").attr('del-activity', $(this).attr('attr-activity'));
    });

    if ($(".delete-theme").length || $(".delete-activity").length) {
        $(document).on("click", ".confirm-delete", async function (event) {
            event.preventDefault();
            let value;
            let theme = true;
            // let body = new FormData();
            let body = '';

            if ($(this)[0].hasAttribute('del-theme')) {
                value = $(this).attr('del-theme');
                body = 'learning_program_id='+$('#learning_program_id').val();
            } else {
                value = $(this).attr('del-activity');
                theme = false;
            }


            let response;

            if (theme) {
                 response = await fetch('/api/destroy-theme/' + value, {
                    method: 'DELETE',
                     headers: {
                         'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                     },
                    body: body
                });
            } else {
                response = await fetch('/api/destroy-activity/' + value, {
                    method: 'DELETE',
                    body: body
                });
            }

            let result = await response.json();

            if (result.code === 200) {

                if (theme) {
                    $('#theme' + value)[0].remove();
                    if ($(".theme").length === 0) {
                        destroyButtons();
                        $(".themes-container").html('<input type="hidden" id="count-rows" value="0"><p class="fw-bold">Добавьте первую тему ☺️</p>');
                    } else await updateListItem();
                } else {
                    //activity body result

                    let activity = $('#activity' + value + ' .activity-hours');
                    let theme = activity.parents('.theme').find('.card-action-hours');

                    let countHoursActivity = +activity.html();
                    let countHoursTheme = +theme.html();

                    theme.html(countHoursTheme - countHoursActivity);
                    $('#activity' + value)[0].remove();
                }


                $('#modalCenter').modal('hide');
                showToast('success', 'Отлично', result.message);

            } else {
                showToast('error', 'Ошибка', result.message);
            }


        });
    }


    $(document).on("click", ".edit-theme", function (event) {
        validateForm('#form-edit-theme');
        let el = document.querySelector("#edit-record");

        let parent = $(this).parents('.theme');
        let title = parent.find('.card-action-name').text();

        $("#edit-record .offcanvas-title span").html(title)
        $("#edit-record  #name").val(title);
        $("#edit-record  #name-hidden").val(title);
        $("#edit-record  #theme-id").val($(this).attr('attr-theme'));


        setTimeout(() => {
            offCanvasEl = new bootstrap.Offcanvas(el);
            offCanvasEl.show()
        }, 200);
    });

    if ($("#form-edit-theme").length) {
        let formEdit = document.querySelector('#form-edit-theme');
        formEdit.onsubmit = function () {

            let validate2 = validateForm('#form-edit-theme');

            validate2.revalidate().then(async isValid => {
                if (isValid) {
                    validate2 = validateForm();

                    let name = $("#form-edit-theme #name").val();
                    let theme = $("#theme-id").val();

                    let body = 'name=' + encodeURIComponent(name) + '&_token=' + encodeURIComponent($("#form-edit-theme #token").val());


                    let response = await fetch('/api/update-theme/' + theme, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                        },
                        body: body
                    });

                    let result = await response.json();
                    // ~(result);
                    if (result.code === 200) {
                        showToast('success', 'Отлично', "Тема успешно обновлена");
                        offCanvasEl.hide();
                        formEdit.reset();
                        // updateListItems();
                        $('#theme' + theme).find('.card-action-name').html(name);
                        // if ($("#count-rows").length) $(".themes-container").html(result.result);
                        // else $(".themes-container").append(result.result);

                    } else {
                        showToast('error', 'Ошибка', "При обновлении темы произошла ошибка");
                    }
                }
            });

            return false;
        };
    }

    $(".switch-show").click(function () {
        $('#select-theme').toggleClass('d-none');
        $('#name-theme').toggleClass('d-none');
    });

    // let value = 12;
    // let activity = $('#activity' + value + ' .activity-hours');
    // let theme = activity.parents('.theme').find('.card-action-hours');
    //
    // let countHoursActivity = +activity.html();
    // let countHoursTheme = +theme.html();
    //
    // theme.html(countHoursTheme - countHoursActivity);

    // let value = 57;
    // console.log($('#theme' + value + ' .card-action-hours').html());

});
