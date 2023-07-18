@extends('auth.layouts')
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
                                <input class="form-control todo-list-input" type="text" id="todo-title"
                                    placeholder="Enter title">
                                <textarea class="form-control mt-3" type="text" id="todo-full_text" placeholder="Enter full_text"></textarea>
                                <button id="add-btn" class="btn btn-primary mt-3">Add</button>
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
    </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        // Загрузка списка задач ajax (если есть) 

        let todos = [];
        returnToArray = getTasks();
        returnToArray.then(result => {
            todos = result;
            displayTodos();
        });

        async function getTasks() {
            try {
                const response = await fetch("http://127.0.0.1:8000/todolist/alltasksjson");
                const data = await response.json();
                return data;
            } catch (error) {
                console.log(error);
                return [];
            }
        }

        // Отображение списка задач
        async function displayTodos() {
            $('#accordionToDo').empty();
            todos.forEach(function(todo, index) { //Add el in accordion
                const deleteBtn = '<span class="btn-close ms-auto" onclick="deleteTodo(' + index + ')"></span>';

                const listItem = $('<div>', { //template for create 1 todolist item
                    class: 'accordion-item mt-3 border-2 rounded-6',
                    html: `<h2 class="accordion-header" id="flush-heading${index}">
                    <button class="accordion-button collapsed text-break  rounded-pill" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse${index}" aria-expanded="false"
                        aria-controls="flush-collapse${index}">
                        <strong>${todo.title}</strong>${deleteBtn}
                        </button>
                </h2>
                <div id="flush-collapse${index}" class="accordion-collapse collapse"
                    aria-labelledby="flush-heading${index}" data-bs-parent="#accordionToDo">
                    <div class="accordion-body">
                        ${todo.full_text}
                        </div>
                </div>`
                });

                $('#accordionToDo').append(listItem);
            });

            // Сохранение списка задач в локальное хранилище
            //localStorage.setItem('todos', JSON.stringify(todos));
        }

        // Добавление новой задачи
        $('#add-btn').click(function() {
            const title = $('#todo-title').val();
            const full_text = $('#todo-full_text').val();

            if (title && full_text) {
                todos.push({
                    title: title,
                    full_text: full_text,
                });

                $('#todo-title').val('');
                $('#todo-full_text').val('');

                displayTodos();
            }
        });

        // Удаление задачи
        function deleteTodo(index) {
            todos.splice(index, 1);
            displayTodos();
        }


        // $(document).ready(function() {
        //     // Загрузка списка задач из локального хранилища (если есть)
        //     let todos = [];

        //     // Отображение списка задач
        //     function displayTodos() {
        //         $('#accordionToDo').empty();

        //         todos.forEach(function(todo, index) {
        //             const listItem = $('<li>', {
        //                 class: 'list-item',
        //                 html: '<strong>Title:</strong> ' + todo.title + ': ' +
        //                     '<strong>full_text:</strong> ' + todo.full_text
        //             });

        //             const deleteBtn = $('<span>', {
        //                 class: 'delete-btn ml-2',
        //                 html: '&#10006',
        //                 click: function() {
        //                     deleteTodo(index);
        //                 }
        //             });

        //             listItem.append(deleteBtn);
        //             $('#accordionToDo').append(listItem);
        //         });

        //         // Сохранение списка задач в локальное хранилище
        //         localStorage.setItem('todos', JSON.stringify(todos));
        //     }

        //     // Добавление новой задачи
        //     $('#add-btn').click(function() {
        //         const title = $('#todo-title').val();
        //         const full_text = $('#todo-full_text').val();

        //         if (title && full_text) {
        //             todos.push({
        //                 title: title,
        //                 full_text: full_text,
        //             });

        //             $('#todo-title').val('');
        //             $('#todo-full_text').val('');

        //             displayTodos();
        //         }
        //     });

        //     // Удаление задачи
        //     function deleteTodo(index) {
        //         todos.splice(index, 1);
        //         displayTodos();
        //     }

        //     displayTodos();
        // });

        $("#add-task-form").on("submit", function() {
            alert(123)

            $.ajax({
                url: "/process-request",
                type: "POST",
                data: {
                    $(this).serialize()
                },
                success: function(response) {
                    // Получение и обработка ответа сервера
                    var postAjax = response;
                    console.log(postAjax);
                }
            });

            // $.ajax({
            //     url: '',
            //     method: 'post',
            //     dataType: 'json',
            //     data: $(this).serialize(),
            //     success: function(data) {
            //         $('#message').html(data);
            //     }
            // });
            
        });

        // $("#submitBtn").click(function() {
        //     var name = $("#name").val();
        //     var age = $("#age").val();

        //     $.ajax({
        //         url: "/process-request",
        //         type: "POST",
        //         data: {
        //             name: name,
        //             age: age
        //         },
        //         success: function(response) {
        //             // Получение и обработка ответа сервера
        //             var postAjax = response;
        //             console.log(postAjax);
        //         }
        //     });
        // });
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
    <script>
        // var accordionButton = document.getElementsByClassName('accordion-button');

        // for (var i = 0; i < accordionButton.length; i++) {
        //     accordionButton[i].addEventListener('click', function() {
        //         // Collapse all elements
        //         for (var j = 0; j < accordionButton.length; j++) {
        //             accordionButton[j].classList.remove('collapsed');
        //         }

        //         // Toggle the clicked element
        //         this.classList.toggle('collapsed');
        //     });
        // }







        // (function($) {
        //     'use strict';
        //     $(function() {
        //         var todoListItem = $('.todo-list');
        //         var todoListInput = $('.todo-list-input');
        //         $('.todo-list-add-btn').on("click", function(event) {
        //             event.preventDefault();

        //             var item = $(this).prevAll('.todo-list-input').val();

        //             if (item) {
        //                 todoListItem.append(
        //                     "<li><div class='form-check'><label class='form-check-label'><input class='checkbox' type='checkbox'/>" +
        //                     item +
        //                     "<i class='input-helper'></i></label></div><i class='remove mdi mdi-close-circle-outline'></i></li>"
        //                 );
        //                 todoListInput.val("");
        //             }

        //         });

        //         todoListItem.on('change', '.checkbox', function() {
        //             if ($(this).attr('checked')) {
        //                 $(this).removeAttr('checked');
        //             } else {
        //                 $(this).attr('checked', 'checked');
        //             }

        //             $(this).closest("li").toggleClass('completed');

        //         });

        //         todoListItem.on('click', '.remove', function() {
        //             $(this).parent().remove();
        //         });

        //     });
        // })(jQuery);
    </script>
@endsection
