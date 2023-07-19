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
                    <div class="row container d-flex justify-content-center mx-auto">
                        <div class="col-md-12">

                            <h1 class="mt-3">To-Do List</h1>
                            <form class="add-items" id="add-task-form">
                                @csrf
                                <input name="title" class="form-control todo-list-input" type="text" id="todo-title"
                                    placeholder="Enter title">
                                <textarea name="full_text" class="form-control mt-3" type="text" id="todo-full_text" placeholder="Enter full_text"></textarea>
                                <input type="file" id="todo-img" name="image"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <form id="imageForm" enctype="multipart/form-data">
        <input type="file" id="imageInput" name="image">
        <input type="text" id="formatInput" name="format">
        <button type="submit">Отправить</button>
    </form>
    <div id="imageContainer"></div> --}}
@endsection
@section('scripts')
    <script>
        //Подключение csrf токена ко всем ajax jQuery 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Отправка изображения и формата на сервер при отправке формы
            $('#imageForm').submit(function(e) {
                e.preventDefault(); // Предотвращаем отправку формы по умолчанию

                var formData = new FormData($(this)[0]); // Создаем объект FormData из формы
                $.ajax({
                    url: '/upload',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // При успешной отправке выводим изображение
                        $('#imageContainer').html('<img src="' + response.image_url +
                            '" alt="Uploaded Image">');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });




        // Загрузка списка задач ajax (если есть)
        var todos = [];
        updateTasksFromServer();

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
            } catch (error) {
                console.log(error);
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
        $('#add-task-form').submit(function(e) {
            e.preventDefault();
            addButton = document.getElementById("add-btn");

            addButton.disabled = true;
            const title = $('#todo-title').val();
            const full_text = $('#todo-full_text').val();
            const image = $('#todo-img').val();



            // addTaskForm = document.getElementById("add-task-form");

            formdata = {
                title: title,
                full_text: full_text,
                image: image,
            }

            console.log(formdata);
            $.ajax({
                url: "/todolist",
                type: "POST",
                data: formdata,
                success: function(response) {
                    var postAjax = response;
                    console.log(postAjax);
                    updateTasksFromServer();
                    $('#todo-title').val(''); //clear fields
                    $('#todo-full_text').val('');
                    $('#todo-img').val('');
                    addButton.disabled = false;

                    // $('#add-task-form').html('<img src="' + response.image_url +
                    //     '" alt="Uploaded Image">');
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
@endsection
