import 'jquery.repeater';
import 'bootstrap-datepicker/dist/locales/bootstrap-datepicker.ru.min';
import $ from "jquery";
import {Dropzone} from "dropzone";


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

    if ($('.select2').length) {
        $(".select2").select2({

        });
    }

    const editor = Jodit.make("#editor", {
        language: "ru",
        maxHeight: '500',
        buttons: [
            'source', '|',
            'copy', 'paste', 'cut', 'undo', 'redo', '|',
            'bold',
            'strikethrough',
            'underline',
            'italic', '|',
            'ul',
            'ol', '|',
            'outdent', 'indent', 'align', '|',
            'font',
            'fontsize',
            'brush',
            'paragraph', '|',
            'file',
            'image',
            'video',
            'table',
            'link', '|',
            'eraser',
            '|',
            'fullsize',
            'preview',
            'print',
        ],
        uploader: {
            "insertImageAsBase64URI": true
        }

    });

    // $('#summernote').summernote();
    // if ($("#editor").length) {
    //     const editor = new Editor({
    //         el: document.querySelector('#editor'),
    //         height: '500px',
    //         initialEditType: 'wysiwyg',
    //         previewStyle: 'vertical',
    //         language: 'ru-RU',
    //         hooks: {
    //             addImageBlobHook(blob, callback) {
    //
    //                 var data = new FormData();
    //                 data.append("attachment", blob);
    //                 console.log(blob);
    //
    //                 axios.post("/api/upload-editor-image", data, {
    //                     //multipart 설정
    //                     headers: {
    //                         "Content-Type" : "multipart/form-data"
    //                     }
    //                 })
    //                     .then(res=>{
    //                         console.log(result);
    //                         // callback(result.data.url);
    //                     })
    //                     .catch(err=>{
    //                         //4-2. 업로드 실패한 경우
    //                         // - 사용자에게 알림 등을 출력한다.
    //                         window.alert("error");
    //                     });
    //                 // axios.post()
    //
    //                 // try {
    //                 //     const formData = new FormData();
    //                 //
    //                 //     formData.append("upl_img", blob);
    //                 //
    //                 //     var csrfHeader = 'X-CSRF-TOKEN';
    //                 //     var csrfToken = $('input[name="_token"]').val();
    //                 //
    //                 //     $.ajax({
    //                 //         url: '/api/upload-editor-image',
    //                 //         method: 'POST',
    //                 //         data: formData,
    //                 //         processData: false,
    //                 //         contentType: false,
    //                 //         beforeSend: function (xhr) {
    //                 //             xhr.setRequestHeader(csrfHeader, csrfToken);
    //                 //         },
    //                 //         success: function (response) {
    //                 //             // 서버로부터 반환된 이미지 URL을 에디터에 삽입
    //                 //             console.log(response);
    //                 //             // callback(response.imageUrl, "image");
    //                 //         },
    //                 //         error: function (xhr, status, error) {
    //                 //             console.error('이미지 업로드 실패:', xhr.responseText, status, error);
    //                 //         }
    //                 //     });
    //                 //
    //                 //     // const response = await fetch('/api/upload-editor-image', {
    //                 //     //     method: 'POST',
    //                 //     //     headers: {
    //                 //     //         "X-CSRF-Token": $('input[name="_token"]').val(),
    //                 //     //     },
    //                 //     //     body: formData,
    //                 //     // });
    //                 //     //
    //                 //     // const filename = await response.text();
    //                 //     // console.log('Upload file: ', filename);
    //                 //
    //                 //
    //                 //     // const imageUrl = `/tui-editor/image-print?filename=${filename}`;
    //                 //     // callback(imageUrl, 'image alt attribute');
    //                 //
    //                 // } catch (error) {
    //                 //     console.error('업로드 실패 : ', error);
    //                 // }
    //
    //             }
    //         }
    //     });
    //
    //     $('#save').click(function (e) {
    //         e.preventDefault();
    //         $("#editor-html").val(editor.getHTML());
    //         $("#form-editor").submit();
    //     });
    // }





    // if ($('.quill').length) {
    //     let editor = new Quill('.quill', {
    //         modules: {
    //             toolbar: [[{
    //                 font: []
    //             }, {
    //                 size: []
    //             }], ["bold", "italic", "underline", "strike"], [{
    //                 color: []
    //             }, {
    //                 background: []
    //             }], [{
    //                 script: "super"
    //             }, {
    //                 script: "sub"
    //             }], [{
    //                 header: "1"
    //             }, {
    //                 header: "2"
    //             }, "blockquote", "code-block"], [{
    //                 list: "ordered"
    //             }, {
    //                 list: "bullet"
    //             }, {
    //                 indent: "-1"
    //             }, {
    //                 indent: "+1"
    //             }], [{
    //                 direction: "rtl"
    //             }], ["link", "image", "video", "formula"], ["clean"]],
    //             imageUploader: {
    //                 upload: (file) => {
    //                     return new Promise((resolve, reject) => {
    //                         const formData = new FormData();
    //                         formData.append("image", file);
    //
    //                         fetch(
    //                             "/api/upload-image",
    //                             {
    //                                 method: "POST",
    //                                 body: formData
    //                             }
    //                         )
    //                             .then((response) => response.json())
    //                             .then((result) => {
    //                                 showToast('success', 'Отлично', "Изображение успешно загружено");
    //                                 resolve(result.fullUrl);
    //                             })
    //                             .catch((error) => {
    //                                 console.log(error);
    //                                 showToast('danger', 'Ошибка', "При загрузке изображения произошла ошибка");
    //                                 reject("Upload failed");
    //                                 console.error("Error:", error.message);
    //                             });
    //                     });
    //                 }
    //             },
    //         },
    //
    //         theme: 'snow'
    //     });
    //
    //     let form = document.querySelector('.quill-form');
    //     form.onsubmit = function() {
    //         let hidden = document.querySelector('#quill-html');
    //
    //         hidden.value = editor.root.innerHTML;
    //
    //         return true;
    //     };
    // }

    $('.repeater').repeater({
        repeaters: [{
            selector: '.inner-repeater'
        }]
    });

    if ($(".bs-datepicker-format").length) {
        $(".bs-datepicker-format").each(function (index) {
            $(this).datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                isRTL: false,
                language: 'ru'
            });
        });
    }

    if ($(".bs-datepicker-year").length) {
        $(".bs-datepicker-year").each(function (index) {
            $(this).datepicker({
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years',
                todayHighlight: true,
                language: 'ru'
            });
        });
    }

    // if ($("#photo").length) {
    //     let video = document.getElementById("photo");
    //     let mediaDevices = navigator.mediaDevices;
    //     video.muted = true;
    //     mediaDevices
    //         .getUserMedia({
    //             video: true,
    //             audio: false,
    //         })
    //         .then((stream) => {
    //
    //             // Changing the source of video to current stream.
    //             video.srcObject = stream;
    //             video.addEventListener("loadedmetadata", () => {
    //                 video.play();
    //             });
    //         })
    //         .catch(alert);
    // }


    $(document).on("click", "#take-photo", function (event) {
        event.preventDefault();
        canvas.width = photo.videoWidth;
        canvas.height = photo.videoHeight;
        let ctx = canvas.getContext('2d');
        let video = document.getElementById("photo");
        ctx.drawImage(video, 0,0, canvas.width, canvas.height)
        let img_dataURI = canvas.toDataURL('image/png', 1);
        document.getElementById("my-data-uri").src = img_dataURI
    });


    $(document).on("click", ".delete", function (event) {
        $("#modalCenter").modal('show');
        let form = $(this).closest("form");
        event.preventDefault();
        $(".confirm-delete").click(function () {
            form.submit();
        })
    });

    $(document).on('change', '#year', function (event) {

        let year = $(this).val();

        $.ajax({
            url: "/get-speciality-by-year",
            type: "POST",
            data: {
                "_token": $('input[name="_token"]').val(),
                "year": year,
            },
            success:function(response){
                $("#speciality_id").prop("disabled", false);
                $("#speciality_id").html(response.result);
            },
        });
    });


    if ($("#phone").length) {
        let cleavePhone = new Cleave('#phone', {
            delimiters: ['+7 (', ') ', '-', '-'],
            blocks: [0, 3, 3, 2, 2],
        });
    }

    if ($("#snils").length) {
        let cleaveSnils = new Cleave('#snils', {
            delimiters: ['-', '-', ' '],
            blocks: [3, 3, 3, 2],
        });
    }
    if ($("#inn").length) {
        let cleaveInn = new Cleave('#inn', {
            blocks: [12],
        });
    }


    $("#equalAddress").change(function () {
        let checked = $(this).prop('checked');

        if (checked) {
            $("#registration").val($("#address").val());
        } else {
            $("#registration").val("");
        }
    });


    $("#studentAdult").change(function () {
        let checked = $(this).prop('checked');

        let $fields = [
            'surname',
            'name',
            'patron',
            'date_of_birth',
            'phone',
            'job',
            'kin',
            'series',
            'number',
            'date_of_issue',
            'issued_by',
            'department_code',
            'nationality',
            'registration'
        ];

        let field;
        if (checked) {
            $fields.forEach((el) => {

                field = '#' + el + '-parent';

                if (el == 'job') {
                    $(field).val('Студент');
                    return;
                }

                if (el == 'date_of_birth' || el == 'date_of_issue') {
                    $(field).datepicker(
                        "update",
                        new Date($("#"+el).val())
                    );
                    return;
                }

                if (el == 'kin') {
                    let newOption = new Option("Совершеннолетний ", "Совершеннолетний ", false, true);
                    $('#'+el).append(newOption).trigger('change');
                }

                $(field).val($("#"+el).val());

            });
        } else {
            $fields.forEach((el) => {

                field = '#' + el + '-parent';
                $(field).val('');

            });
        }

        // if (checked) {
        //     $("#registration").val($("#address").val());
        // } else {
        //     $("#registration").val("");
        // }
    });


    if ($("#country").length) {
        $("#country").suggestions({
            token: "6fc144c3728149bd183bf3c97f78444d2d0c9a9e",
            type: "country",
            onSelect: function (suggestion) {
                $("#nationality").val(suggestion.data.code);
            }
        });
    }


    if ($(".themes-container").length) {

        const themes = document.querySelector('.themes-container');
        var updateListItem = async function updateListItems() {
            const listItems = themes.querySelectorAll('.theme');
            let keys = '';
            listItems.forEach((el, index) => {
                el.setAttribute('order', `${index + 1}`);
                keys += el.getAttribute('id').replace('theme', '') + '=' + (index + 1) + '&';
            });

            keys = keys.slice(0, -1);
            let body = keys + '&_token=' + encodeURIComponent($("input[name='_token']").val());
            let lp = $('#learning_program_id').val();

            let response = await fetch('/api/update-theme-order/' + lp, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: body
            });

            let result = await response.json();

            if (result.code === 404 || result.code === 500) {
                showToast('danger', 'Ошибка', "При обновлении темы произошла ошибка");
            }

        }


        const sortable = new Sortable(themes, {
            draggable: '.theme',
            handle: '.theme-handle',
            swapAnimation: {
                duration: 400,
                easingFunction: 'ease-in-out',
                horizontal: false
            },
            mirror: {
                constrainDimensions: true,
            },
            plugins: [Plugins.ResizeMirror, Plugins.SwapAnimation],

        });

        sortable.on('sortable:stop', async (e) => {
            setTimeout(updateListItem, 10);

        });

        updateListItem();
        window.updateListItem = updateListItem;
    }


    if ($(".activities-container").length) {

        const activities = document.querySelectorAll('.activities-container');
        var updateListActivities = async function updateListActivities(theme) {
            let idTheme = theme.replace('theme', '');
            let themes = document.querySelector("#" + theme);
            const listItems = themes.querySelectorAll('.activities-container .activity');
            let keys = '';
            listItems.forEach((el, index) => {
                el.setAttribute('order', `${index + 1}`);
                if (el.getAttribute('id')) {
                    keys += el.getAttribute('id').replace('activity', '') + '=' + (index + 1) + '&';
                }
            });

            keys = keys.slice(0, -1);
            let body = keys + '&_token=' + encodeURIComponent($("input[name='_token']").val());

            let response = await fetch('/api/update-activity-order/' + idTheme, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: body
            });

            let result = await response.json();

            if (result.code === 404 || result.code === 500) {
                showToast('danger', 'Ошибка', result.message);
            }

        }

        function updateHours(themes) {
            themes.forEach((item) => {
                let themeContainer = document.querySelector("#" + item);
                const listItems = themeContainer.querySelectorAll('.activities-container .activity');
                let themeHours = $("#" + item).find('.card-action-hours');

                if (listItems.length === 0) {
                    themeHours.html('0');
                } else {
                    let countH = 0;
                    listItems.forEach((el, index) => {
                        countH += +$('#' + el.getAttribute('id') + ' .activity-hours').html();
                    });
                    themeHours.html(countH);
                }

            });
        }


        var updateDoubleActivities = async function updateDoubleActivities(oldTheme, newTheme) {

            let themes = [];
            themes.push(oldTheme, newTheme);
            let body = '';

            themes.forEach((item) => {
                let tempId = item.replace('theme', '');

                let themeContainer = document.querySelector("#" + item);
                const listItems = themeContainer.querySelectorAll('.activities-container .activity');

                if (listItems.length === 0) {
                    body += tempId + "[]=0&";
                    return;
                }

                let keys = '';
                listItems.forEach((el, index) => {
                    el.setAttribute('order', `${index + 1}`);
                    if (el.getAttribute('id')) {
                        body += tempId + "[]=" + el.getAttribute('id').replace('activity', '') + '+' + (index + 1) + '&';
                    }
                });
            });

            body = body.slice(0, -1);
            body = body + '&_token=' + encodeURIComponent($("input[name='_token']").val());

            let response = await fetch('/api/update-double-activity', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                body: body
            });

            let result = await response.json();

            if (result.code === 404 || result.code === 500) {
                showToast('danger', 'Ошибка', result.message);
            } else {
                updateHours(themes);
            }

        }


        const sortable2 = new Sortable(activities, {
            draggable: '.activity',
            handle: '.activity-handle',
            swapAnimation: {
                duration: 400,
                easingFunction: 'ease-in-out',
                horizontal: false
            },
            mirror: {
                constrainDimensions: true,
            },
            plugins: [Plugins.ResizeMirror, Plugins.SwapAnimation],
            // plugins: [Draggable]

        });


        sortable2.on('sortable:stop', async (e) => {

            let newTheme = e.data.newContainer.offsetParent.getAttribute('id');
            let oldTheme = e.data.oldContainer.offsetParent.getAttribute('id');
            if (newTheme === oldTheme) {
                setTimeout(()=> {
                    updateListActivities(newTheme)
                }, 10);
            } else {
                setTimeout(()=> {
                    updateDoubleActivities(oldTheme, newTheme);
                }, 10);


            }
        });

        // updateListActivities();
        // window.updateListActivities = updateListActivities;
    }


    $(document).on("change", ".file-upload" ,function(e) {
        let label	 = this.nextElementSibling,
            labelVal = this.innerHTML;

        // console.log(label, this);

        let fileType = this.files[0]["type"];
        let validImageTypes = [ "image/jpeg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            showToast('danger', 'Ошибка при загрузке файла', "Загрузите изображение в формате  .jpg, .png")
        } else {
            let fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length )
            else
                fileName = e.target.value.split( '\\' ).pop();


            if( fileName )
                // label.querySelector( 'span' ).innerHTML = fileName;
                label.style.color = '#71dd37';
            else
                label.innerHTML = labelVal;
        }
    });



    if ($("#chart").length) {
        function generateData(month, year) {
            let count = new Date(year, month, 0).getDate();
            let res;


            return res;
        }

        let months = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Март',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ]


        var options = {
            chart: {
                height: 200,
                type: "heatmap",
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false,
                    },
                    export: {
                        csv: {
                            filename: undefined,
                            columnDelimiter: ',',
                            headerCategory: '#',
                            headerValue: 'value',
                            dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                            }
                        },
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                },
            },
            colors: [
                "#696cff",
            ],
            plotOptions: {
                heatmap: {
                    shadeIntensity: 0.5,

                    colorScale: {
                        ranges: [{
                            from: 0,
                            to: 20,
                            name: 'low',
                            color: '#acb0ff'
                        }]
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            series: [],
            noData: {
                text: 'Загружаем данные...'
            },
            stroke: {
                width: 1
            },
            tooltip: {
                custom: function ({series, seriesIndex, dataPointIndex, w}) {
                    if (w.globals.seriesNames[seriesIndex] !== "") {
                        return series[seriesIndex][dataPointIndex] + " действий на " + (dataPointIndex + 1) + " " + (w.globals.seriesNames[seriesIndex]).substr(0, 3);
                    } else {
                        return "";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();


        var url = '/api/get-activity-log/?year=' + 2024;

        $.getJSON(url, function (response) {

            chart.updateSeries(response)

        });
    }
});
