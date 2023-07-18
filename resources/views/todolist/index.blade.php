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
                            {{ json_encode($tasks) }}
                        </div>
                    @endif
                    <div class="row container d-flex justify-content-center">
                        <div class="col-md-12">

                            <h1 class="mt-3">To-Do List</h1>
                            <form class="add-items" id="add-task-form">
                                @csrf
                                <input name="title" class="form-control todo-list-input" type="text" id="todo-title"
                                    placeholder="Enter title">
                                <textarea name="full_text" class="form-control mt-3" type="text" id="todo-full_text" placeholder="Enter full_text"></textarea>
                                <input type="file" name="image" class="form-control todo-list-input mt-3">
                            </form>
                            <button id="add-btn" class="btn btn-primary mt-3">Add</button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Загрузка списка задач ajax (если есть)

        var todos = [];
        updateTasksFromServer();
        // setInterval(() => {
        //     updateTasksFromServer();
        // }, 5000);

        async function updateTasksFromServer() {
            arr = [];
            try {
                const response = await fetch("http://127.0.0.1:8000/todolist/tasks");
                const responseFROMjson = await response.json();
                for (const [key, task] of Object.entries(responseFROMjson)) {
                    arr[task.id] = task;
                }
                todos = arr;
                displayTodos();
                // return arr;
            } catch (error) {
                console.log(error);
                // return [];
            }
        }

        // Отображение списка задач
        async function displayTodos() {
            $('#accordionToDo').empty(); //clear accordion
            todos.forEach(task => {
                id = task.id;
                //template for create 1 todolist item
                const deleteBtn = '<span class="btn-close ms-auto" onclick="deleteTodo(' + id + ')"></span>';
                const listItem = $('<div>', {
                    class: 'accordion-item mt-3 border-2 rounded-6',
                    html: `<h2 class="accordion-header" id="flush-heading${id}">
                        <button class="accordion-button collapsed text-break  rounded-pill" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse${id}" aria-expanded="false"
                            aria-controls="flush-collapse${id}">
                            <strong>${task.title}</strong>${deleteBtn}
                            </button>
                        </h2>
                        <div id="flush-collapse${id}" class="accordion-collapse collapse"
                            aria-labelledby="flush-heading${id}" data-bs-parent="#accordionToDo">
                            <div class="accordion-body">
                                ${task.full_text}
                            </div>
                        </div>`
                });
                $('#accordionToDo').append(listItem);
            });
        }

        //Delete task
        function deleteTodo(index) {
            $.ajax({
                url: ("/todolist/" + index),
                type: "DELETE",
                success: function(response) {
                    // Получение и обработка ответа сервера
                    console.log(response);
                    delete todos[index];
                    updateTasksFromServer();
                },
            });
        };

        // Add new task on click
        $('#add-btn').click(function() {
            const title = $('#todo-title').val();
            const full_text = $('#todo-full_text').val();

            $('#todo-title').val('');
            $('#todo-full_text').val('');

            formdata = {
                title: title,
                full_text: full_text,
                // _token: '{!! csrf_token() !!}'
            }

            console.log(formdata);
            $.ajax({
                url: "/todolist",
                type: "POST",
                data: formdata,
                success: function(response) {
                    // Получение и обработка ответа сервера
                    var postAjax = response;
                    console.log(postAjax);
                    updateTasksFromServer();
                }
            });
        }); //Add button click
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
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@endsection
