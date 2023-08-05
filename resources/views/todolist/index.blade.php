@extends('auth.layouts')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ваш To-Do List</div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            Рады, что вы снова вернулись)
                            {{-- {{ json_encode($tasks) }} --}}
                        </div>
                    @endif
                    <div class="row container d-flex justify-content-center mx-auto px-0">
                        <div class="col-md-12 px-0">

                            <div id="filter-tags" class="w-full flex px-8 flex-wrap mt-8">

                                @foreach (['granny', 'cats', 'dogs'] as $mark_name)
                                    <a href="#" class="m-2">
                                        {{ $mark_name }}</a>
                                @endforeach

                                <a href="#" class="m-2">
                                    <button
                                        class="text-green-600 h-12 flex items-center rounded-2xl justify-center uppercase font-semibold px-8 border border-green-600 hover:border-white hover:bg-green-600 hover:text-white transition duration-300 ease-in-out"
                                        data-ripple-dark="true">
                                        Add new mark
                                    </button>
                                </a>

                            </div>

                            <h1 class="mt-3">To-Do List</h1>
                            <form enctype="multipart/form-data" method="post" class="add-items" id="add-task-form">
                                <input name="title" class="form-control todo-list-input" type="text" id="todo-title"
                                    placeholder="Enter title">
                                <textarea name="full_text" class="form-control mt-3" type="text" id="todo-full_text" placeholder="Enter full_text"></textarea>
                                <input type="file" id="todo-img" name="todo-img"
                                    class="form-control todo-list-input mt-3" accept="image/png, image/gif, image/jpeg">
                                <button id="add-btn" class="btn btn-success mt-3 w-50 mx-auto d-block">Add in to-do
                                    list</button>
                            </form>
                            <div class="list-container">
                                <div class="accordion accordion-flush" id="accordionToDo">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed rounded-pill border-bottom-0"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Accordion Item #1
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse mt-3 w-full"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionToDo">
                                        <div class="accordion-body rounded-pill bg-success bg-opacity-50 text-light">
                                            Placeholder content for this accordion</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="tryImage">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        //Подключение csrf токена ко всем ajax jQuery 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Начальная загрузка списка задач ajax (если есть)
        var tasks = [];
        var tags
        updateTasksFromServer();

        // При вызове кладет обновленные данные о задачах в переменную tasks и вызывает recreateAllTasks()
        async function updateTasksFromServer() {
            arr = [];
            try {
                const response = await fetch("/todolist/tasks");
                const responseFROMjson = await response.json();
                for (const [key, task] of Object.entries(responseFROMjson)) {
                    arr[task.id] = task;
                }
                tasks = arr;
                recreateAllTasks();
            } catch (error) {
                console.log(error);
            }
        }

        function recreateAllFilterTags() {
            $("#filter-tags").empty();

        }

        // Отображение задач в HTML


        function recreateAllTasks() {
            accordion = $('#accordionToDo')
            accordion.empty(); //clear accordion
            tasks.forEach(task => {
                buildedTask = BuildTask(task);
                accordion.append(buildedTask); //add builded element
            })
        }

        function BuildTask(task) {
            const id = task.id;
            console.log(task.img_src);

            //template for create 1 todolist item
            const taskImgIfExists = task.img_src ?
                `<a href="${task.img_src}"><img enctype="multipart/form-data" src="${ImgThumbinalURL(task.img_src, id)}"></a>` :
                ``;
            const taskStageBtn = (task.completed ?
                `<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" onclick="makeTaskСompleted(${id})">` :
                `<input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" onclick="makeTaskUncompleted(${id})" checked>`
                // `<span class="btn-complete text-danger" onclick="makeTaskСompleted(${id})">Make task completed</span>` :
                // `<span class="btn-uncomplete text-success" onclick="makeTaskUncompleted(${id})">Make task uncompleted</span>`
            );
            const menuBtns =
                `<div class="ms-auto btn-group">
                        ${taskStageBtn}
                        <span class="btn-edit" onclick="prepareEditTask(${id})"></span>
                        <span class="btn-close" onclick="deleteTask(${id})"></span>
                    </div>`;

            const buildedTask = $('<div>', {
                class: 'accordion-item mt-3 border-2 rounded-6',
                html: `<h2 class="accordion-header" id="flush-heading${id}">
                        <button class="accordion-button collapsed text-break  rounded-pill" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse${id}" aria-expanded="false"
                            aria-controls="flush-collapse${id}">
                            <strong>${task.title}</strong>${menuBtns}
                            </button>
                        </h2>
                        <div id="flush-collapse${id}" class="accordion-collapse collapse px-0"
                            aria-labelledby="flush-heading${id}" data-bs-parent="#accordionToDo">
                            <div class="accordion-body px-0">
                                ${taskImgIfExists}
                                <span>${task.full_text}</span>
                            </div>
                        </div>`
            });

            return buildedTask;
        }

        function makeTaskСompleted(index) {
            formData = new FormData();
            formData.append("completed", 0);
            fetch('/todolist/' + index, {
                    method: "post",
                    dataType: "json",
                    headers: {
                        "x-csrf-token": $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Ошибка HTTP: " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    tasks[index].completed = 0;
                    recreateAllTasks();
                })
                .catch(err => console.error(err))
        }

        function makeTaskUncompleted(index) {
            formData = new FormData();
            formData.append("completed", 1);
            fetch('/todolist/' + index, {
                    method: "post",
                    dataType: "json",
                    headers: {
                        "x-csrf-token": $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Ошибка HTTP: " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    tasks[index].completed = 1;
                    recreateAllTasks();
                })
                .catch(err => console.error(err))
        }

        function ImgThumbinalURL(img_path, task_id) {
            imgOrigName = ((/\/\d*\/(.*\.png)$/).exec(img_path))[1];
            imgThumbName = "thumbnail_" + imgOrigName;
            prefix = "/task-img/" + task_id + "/thumbnails/";
            imgThumbPath = prefix + imgThumbName;
            return imgThumbPath;
        }

        //Delete task
        function deleteTask(index) {
            fetch("/todolist/" + index, {
                    method: "DELETE"
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Ошибка HTTP: " + response.status);
                    }
                    return response.json();
                })
                .then(response => {
                    console.log(response);
                    updateTasksFromServer();
                })
                .catch(error => {
                    console.error(error);
                });
        };

        $('.accordion-button .accordion-header').click(function(event) {
            if ($(event.target).is('input')) {
                event.stopPropagation();
            }
        });





        function prepareEditTask(index) {

            prevTaskTitle = $("#flush-heading" + index + ">button>strong").text();
            prevTaskFullText = $("#flush-collapse" + index + ">.accordion-body>span").text();
            editingFormClass = `editing-form${index}`;
            document.querySelector("#flush-heading" + index).parentElement.innerHTML = `
            <form enctype="multipart/form-data" method="post" class="d-flex justify-content-center flex-column rounded-4 p-4 bg-warning bg-opacity-25
            ${editingFormClass}" id="edit-task-form">
                <div>
                    <h2 class="my-auto">
                        <em>Editing task</em>
                    </h2>
                </div>
                <input name="title" class="form-control task-list-input" type="text" id="new-task-title"
                    placeholder="Enter title" value="${prevTaskTitle}">
                <textarea name="full_text" class="form-control mt-3" type="text" id="new-task-full_text" placeholder="Enter full_text">${prevTaskFullText}</textarea>
                <input type="file" id="new-task-img" name="task-img"
                    class="form-control task-list-input mt-3" accept="image/png, image/gif, image/jpeg">
                <div class="mx-auto btn-group mt-3">
                    <button id="btn-cancel-editing" class="btn btn-light text-black mx-auto d-block">
                        Cancel changes
                    </button>
                    <button id="add-btn" class="btn btn-warning text-white mx-auto d-block">
                        Save task
                    </button>
                </div>
            </form>`;

            $(".btn-cancel-editing").click((e) => {
                recreateAllTasks();
            })

            //Повесить обработчик sumbmit кнопки сразу после создания формы
            $("." + editingFormClass).submit(function(e) {
                e.preventDefault();
                const input = $(this)[0].querySelector('#new-task-img').files[0];
                formData = new FormData($(this)[0]);
                console.log(formData);
                fetch('/todolist/' + index, {
                        method: "post",
                        dataType: "json",
                        headers: {
                            "x-csrf-token": $('meta[name="csrf-token"]').attr('content')
                        },
                        body: formData,
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Ошибка HTTP: " + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        updateTasksFromServer();
                    })
                    .catch(err => console.error(err))
            })
        };


        // Add new task on click
        $('#add-task-form').submit(function(e) {
            e.preventDefault();

            addButton = document.getElementById("add-btn");
            addButton.disabled = true;

            formData = new FormData($(this)[0]);

            console.log(formData);
            fetch('/todolist', {
                    method: 'POST',
                    dataType: "json",
                    headers: {
                        "x-csrf-token": $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Ошибка HTTP: " + response.status);
                    }
                    return response.json();
                })
                .then(response => {
                    console.log(response);
                    updateTasksFromServer();
                    $('#todo-title').val(''); //clear fields
                    $('#todo-full_text').val('');
                    $('#todo-img').val('');
                    addButton.disabled = false;
                })
                .catch(error => {
                    console.log({
                        ERROR: error
                    });
                    setTimeout(() => {
                        addButton.disabled = false;
                    }, 5000);
                });
        }); //Add new task on click

        function compare_currTask_With_newTask(task_id, newTask) {
            currTask = tasks[task_id];
            keysForCompare = ["id", "title", "full_text", "img_src", "completed"];
            taskOnlyChangedKeys = {};
            keysForCompare.forEach(key => {
                if (!(currTask[key] == newTask[key])) {
                    taskOnlyChangedKeys[key] = newTask[key];
                }
            })
            return taskOnlyChangedKeys;
        }
    </script>
    <style>
        body {
            margin: 20px;
        }

        .list-container {
            margin-top: 30px;
        }

        .list-item {
            margin-bottom: 10px;
        }

        .delete-btn {
            cursor: pointer;
        }

        .accordion-button::after {
            margin-left: 2px;
        }

        .accordion-item {
            border-radius: 50px;
        }

        .btn-edit {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: 0.25em 0.25em;
            color: #000;
            background: transparent url(https://www.svgrepo.com/show/509191/pencil.svg) center/1em auto no-repeat;
            border: 0;
            border-radius: 0.375rem;
            opacity: .5;
        }

        .btn-edit-off {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: 0.25em 0.25em;
            color: #000;
            background: transparent url(https://www.svgrepo.com/show/509191/pencil.svg) center/1em auto no-repeat;
            border: 0;
            border-radius: 0.375rem;
            opacity: .5;
        }

        .btn-completed {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: 0.25em 0.25em;
            color: #000;
            background: transparent url(https://www.svgrepo.com/show/509191/pencil.svg) center/1em auto no-repeat;
            border: 0;
            border-radius: 0.375rem;
            /* opacity: .5; */
        }

        .btn-save {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: 0.25em 0.25em;
            color: #000;
            background: transparent url(https://www.svgrepo.com/show/522264/save-floppy.svg) center/1em auto no-repeat;
            border: 0;
            border-radius: 0.375rem;
            opacity: .5;
        }

        .btn-save:hover,
        .btn-edit:hover,
        .btn-edit-off:hover {
            opacity: 1;
        }
    </style>
@endsection
