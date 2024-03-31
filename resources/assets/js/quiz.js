import $ from "jquery";

$(document).ready(function () {


    function showToast(color, title, text) {
        let toastElList = [].slice.call(document.querySelectorAll('.toast'))

        let bg = 'bg-'+color;

        $('.toast-title').html(title);
        $('.toast').addClass(bg);
        $('.toast-body').html(text);

        let toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, {'delay': 3500})
        })
        toastList.forEach(toast => toast.show());

        setTimeout(function () {
            $('.toast').removeClass(bg);
        }, 4000);
    }


    $(document).on("click", ".new-answer" ,function(){
        let newA = "";
        let old = $(this).parents(".answers").prev().parents('.question').attr('attr-time');
        if (old === 'old') {
            newA = "attr-new='new'";
        }

        let number = $(this).parents("ul.answers").parents(".questions-content").find("li.question").last().attr("attr-number");
        let type = $(this).parents("ul.answers").children(".answers-content").children("li").last().find("input").first().attr("type");
        let txt = '';

        if (type === 'checkbox') {
            txt = '<li ' + newA + '><div class="input_el d-flex align-items-center gap-2"><input class="form-check-input" type="checkbox" name="el' + number + '"><input type="text" class="form-control form-control-sm" placeholder="Введите ответ..."><div class="controls"><a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ"><i class="tf-icons bx bx-trash"></i></a></div></div></li>';
        } else {
            txt = '<li ' + newA + '><div class="input_el d-flex align-items-center gap-2"><input class="form-check-input" type="radio" name="el' + number + '"><input type="text" class="form-control form-control-sm" placeholder="Введите ответ..."><div class="controls"><a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ"><i class="tf-icons bx bx-trash"></i></a></div></div></li>';
        }

        $(this).parents("ul.answers").children(".answers-content").append(txt);
        $('[data-bs-toggle="tooltip"]').tooltip();
    });


    if ($(".del-answer").length) {
        $(document).on("click", ".del-answer", async function (event) {
            Sweetalert2.fire({
                title: "Вы уверены?",
                text: "Вы действительно хотите удалить выбранные данные?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Отмена"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let t = $(this);

                    if ($(this).parents('.answers-content').children('li').length <= 2) {
                        showToast('warning', 'Внимание!', "В вопросе не может быть меньше двух ответов");
                        return;
                    }


                    let idAnswer = $(this).parents("li").attr("attr-id");
                    if ($(this).parents(".answers").prev().parents('.question').attr('attr-time') === 'old' && idAnswer) {

                        let body = 'answer_id=' + idAnswer;

                        let response = await fetch('/api/destroy-answer', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                            },
                            body: body
                        });

                        let result = await response.json();


                        if (result.code === 200) {
                            $(this).parents(".controls").parents(".input_el").parent("li").remove();
                            showToast('success', 'Отлично', result.message);
                        } else {
                            showToast('danger', 'Ошибка', result.message);
                        }

                    } else {

                        $(this).parents(".controls").parents(".input_el").parent("li").remove();
                        showToast('success', 'Отлично', "Ответ успешно удален");
                    }


                }
            });
        });
    }

    $(document).on("click", ".change-type" ,function(){
        $(this).parents("ul").find(".answers-content").find("li").each(function( index ) {
            let elem = $(this).find("input").first();
            if (elem.attr("type") === "checkbox") elem.attr("type", "radio");
            else elem.attr("type", "checkbox");
        });
    });

    $(".new-question").click(function(){

        let number = $(this).parents(".card").find(".questions-content").find("li.question").last().attr("attr-number");

        if (number == undefined) number = 1;
        else number = +number + 1;

        let question = '<li class="list-group-item border-none question" attr-number="' + number + '">\n' +
            '                                    <div class="d-flex align-items-center gap-3 ms-4">\n' +
            '                                        <input class="form-control" type="text"  placeholder="Введите вопрос...">\n' +
            '                                        <div class="controls d-flex align-items-center gap-3">\n' +
            '                                           <form id="form-file' + number + '">\n' +
            '                                            <input type="file" name="file' + number + '" id="file' + number + '" class="file-upload" accept="image/*" data-multiple-caption="{count} files selected">\n' +
            '                                            <label for="file' + number + '" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Загрузить файл"><i class="tf-icons bx bx-upload"></i><span></span></label></form>\n' +
            '\n' +
            '                                            <a class="del-question" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить вопрос">\n' +
            '                                                <i class="tf-icons bx bx-trash"></i>\n' +
            '                                            </a>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '\n' +
            '                                    <ul class="answers">\n' +
            '                                        <div class="answers-content">\n' +
            '                                            <li>\n' +
            '                                                <div class="input_el d-flex align-items-center gap-2">\n' +
            '                                                    <input class="form-check-input" type="checkbox" name="el' + number + '">\n' +
            '                                                    <input type="text" class="form-control form-control-sm" placeholder="Введите ответ...">\n' +
            '                                                    <div class="controls">\n' +
            '                                                        <a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ">\n' +
            '                                                            <i class="tf-icons bx bx-trash"></i>\n' +
            '                                                        </a>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </li>\n' +
            '                                            <li>\n' +
            '                                                <div class="input_el d-flex align-items-center gap-2">\n' +
            '                                                    <input class="form-check-input" type="checkbox" name="el' + number + '">\n' +
            '                                                    <input type="text" class="form-control form-control-sm" placeholder="Введите ответ...">\n' +
            '                                                    <div class="controls">\n' +
            '                                                        <a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ">\n' +
            '                                                            <i class="tf-icons bx bx-trash"></i>\n' +
            '                                                        </a>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </li>\n' +
            '\n' +
            '                                        </div>\n' +
            '                                        <div class="d-flex mt-3 mb-2">\n' +
            '                                            <a class="new-answer btn btn-sm btn-primary text-white me-2"><i class="tf-icons bx bx-plus me-1"></i> Добавить ответ</a>\n' +
            '                                            <a class="change-type btn btn-sm btn-primary text-white" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Изменение типа на множественный или одиночный выбор ответа"><i class="tf-icons bx bx-refresh me-1"></i> Изменить тип вопроса</a>\n' +
            '                                        </div>\n' +
            '                                    </ul>\n' +
            '                                </li>';


        $(this).parents(".card").find(".questions-content").append(question);
        $('[data-bs-toggle="tooltip"]').tooltip();

    });

    // ДОДЕЛАТЬ
    $(document).on("click", ".del-question" ,function(){
        Sweetalert2.fire({
            title: "Вы уверены?",
            text: "Вы удаляете вопрос, все ответы будут удалены",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Отмена"
        }).then(async (result) => {
            if (result.isConfirmed) {

                if ($(this).parents(".controls").parents("li").parents('.questions-content').children('li').length === 1) {
                    showToast('warning', 'Внимание!', "Тест должен содержать хотя бы один вопрос");
                    return;
                }

                let t = $(this);

                if (t.parents("li").attr("attr-time") === 'old') {
                    let idQuestion = t.parents("li").attr("attr-number");

                    let body = 'question_id=' + idQuestion;

                    let response = await fetch('/api/destroy-question', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                        },
                        body: body
                    });

                    let result = await response.json();


                    if (result.code === 200) {
                        $(this).parents(".controls").parents("li").remove();
                        showToast('success', 'Отлично', result.message);
                    } else {
                        showToast('danger', 'Ошибка', result.message);
                    }

                } else {
                    $(this).parents(".controls").parents("li").remove();
                    showToast('success', 'Отлично', "Вопрос успешно удален");
                }

            }
        });

    });

    $(document).on("click", "#store-quiz" ,function(){

        let content = $(".questions-content");

        let countEl  = 0;
        let countF   = 0;
        let countAEl = 0
        let countAF  = 0;
        let questions = new Object();
        let files = new FormData();
        let editQuestions = new Object();
        let editAnswers = new Object();
        let newAnswers = new Object();
        // let filesQ = new FormDa();
        let idQFiles = new Object();
        let resA = false;
        let resC = false;


        if (content.children("li").length === 0) {
            showToast('danger', 'Оой, ошибка', "Вы не добавили ни одного вопроса!");
        } else {

            let j = 1;

            content.children("li").each(function( index ) {

                resA = false;
                resC = false;
                let idQ = 0;


                countEl++;
                let old = false;
                if ($(this).attr("attr-time") === 'old') {
                    old = true;
                }

                let inputTxt = $(this).find("input[type=text]");
                let questionTxt = inputTxt.val();

                if (questionTxt !== '') {
                    countF++;
                    inputTxt.attr("style", "");

                    let type = $(this).find('.answers').find("input").first().attr("type");

                    let file;

                    if (!old) {
                        file = $(this).find("form").children("input")[0].files[0];
                        if (file !== undefined) {
                            files.append("file"+j , file);
                        }

                        questions[j] = {"question" : questionTxt, "type" : type, "answer" : {}};

                    } else {

                        if ($(this).find("form").children("input").length)
                            file = $(this).find("form").children("input")[0].files[0];

                        idQ = $(this).attr("attr-number");

                        if (file !== undefined) {
                            files.append("qfile"+idQ , file);
                            idQFiles[j] = idQ;
                        }

                        let t = '';
                        if (type === 'checkbox') t = 'c';
                        else t = 'r';

                        let oldText = $(this).find("input[type=text]").attr("attr-val");
                        let oldType = $(this).attr("attr-type");


                        if (questionTxt !== oldText) {
                            editQuestions[idQ] = {'question' : questionTxt};
                        }

                        if (t !== oldType) {
                            editQuestions[idQ] = {'type' : t};
                        }

                        if (questionTxt !== oldText && t !== oldType) {
                            editQuestions[idQ] = {'question' : questionTxt, 'type' : t};
                        }

                    }


                    let i = 1;
                    let countAnswer = 0;
                    let countChecked = 0;

                    $(this).find(".answers li").each(function (index) {

                        let checkedVal = '';
                        let checked = $(this).find("input[type="+type+"]").is(':checked');
                        let answerTxt = $(this).find("input[type=text]");
                        let oldAnswer = $(this).find("input[type=text]").attr("attr-val");
                        let idAnswer = $(this).attr("attr-id");

                        let oldChecked = $(this).find("input[type="+type+"]").attr("attr-check");

                        if (checked === true) {
                            checkedVal = "checked";
                        }

                        if (answerTxt.val() === '') {
                            answerTxt.css("border-color", "red");

                        } else {
                            answerTxt.attr("style", "");
                            countAF++;


                            if ($(this).attr("attr-new") == 'new') {

                                newAnswers[idQ] = {"answer" : answerTxt.val(), "checked" : checked}

                            }

                            if (checkedVal == "" && oldChecked == 'checked') {
                                editAnswers[idAnswer] = {'check' : false};

                                if (answerTxt.val() != oldAnswer) {
                                    editAnswers[idAnswer] = {'check' : false, "value" : answerTxt.val()};
                                }

                            } else if (checkedVal == "checked" && oldChecked == '') {
                                editAnswers[idAnswer] = {'check' : true};

                                if (answerTxt.val() != oldAnswer) {
                                    editAnswers[idAnswer] = {'check' : false, "value" : answerTxt.val()};
                                }
                            }

                            if (answerTxt.val() != oldAnswer && (checkedVal == oldChecked)) {
                                editAnswers[idAnswer] = {"value" : answerTxt.val()};
                            }


                            if (!old) questions[j]['answer'][i] = {"txtA" : answerTxt.val(), "checked" : checked};

                        }

                        if (checked == true) {
                            countChecked++;
                        }


                        i++;
                        countAEl++;
                        countAnswer++;

                    });

                    if (countAnswer < 2) {
                        showToast('danger', 'Оой, ошибка', "В вопросе должно быть минимум 2 ответа!");
                        return;
                    } else {
                        resA = true;
                    }
                    if (countChecked == 0) {
                        showToast('danger', 'Оой, ошибка', "Не выбраны правильные ответы!");
                        return;
                    } else {
                        resC = true;
                    }

                }
                else {
                    inputTxt.css("border-color", "red");
                    return;
                }


                j++;
            });


            if (countF != countEl || countAF != countAEl) showToast('danger', 'Оой, ошибка', "Заполните все поля!");
            else if ( resA && resC) {

                files.append("questions", JSON.stringify(questions));
                files.append("newAnswers", JSON.stringify(newAnswers));
                files.append("EQuestions", JSON.stringify(editQuestions));
                files.append("EAnswers", JSON.stringify(editAnswers));
                files.append("idQuestionFiles", JSON.stringify(idQFiles));

                $.ajax({
                    type : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    url : '/api/createQuiz/' + $("#activity").val(),
                    cache: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    data : files,
                    success: function (result) {

                        if (result.code === 200) {
                            location.reload();
                        } else {
                            showToast('danger', 'Ошибка', "При обновлении теста, произошла ошибка");
                        }

                    },
                });
            }
        }


    });

    $(document).on("click", ".delFile" ,function(){

        Sweetalert2.fire({
            title: "Вы уверены?",
            text: "Восстановление удаленного файла невозможно",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Отмена"
        }).then(async (result) => {
            if (result.isConfirmed) {
                let t = $(this);
                if (t.parents("li").attr("attr-time") === 'old') {

                    let idQuestion = t.parents("li").attr("attr-number");
                    let number = $(this).parents("li.question").attr("attr-number");

                    let body = 'question_id=' + idQuestion;

                    let response = await fetch('/api/destroy-question-file', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                        },
                        body: body
                    });

                    let result = await response.json();


                    if (result.code === 200) {
                        $(this).parents('.controls').prepend('<form id="form-file'+number+'"><input type="file" name="file'+number+'" id="file'+number+'" class="file-upload" accept="image/*" data-multiple-caption="{count} files selected"><label for="file'+number+'" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Загрузить файл"><i class="tf-icons bx bx-upload"></i><span></span></label></form>');
                        $(this).remove();
                        // location.reload();
                    } else {
                        showToast('danger', 'Ошибка', result.message);
                    }

                }

            }
        });
    });



})
