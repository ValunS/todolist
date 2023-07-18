@extends('auth.layouts')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">To-Do List</div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            Рады, что вы снова вернулись)
                        </div>
                    @endif
                    <div class="row container d-flex justify-content-center">
                        <div class="col-md-12">
                            {{-- <div class="card px-3">
                                <div class="card-body">
                                    <h4 class="card-title">Awesome Todo list</h4>
                                    <div class="add-items d-flex"> <input type="text"
                                            class="form-control todo-list-input"
                                            placeholder="What do you need to do today?"> <button
                                            class="add btn btn-primary font-weight-bold todo-list-add-btn">Add</button>
                                    </div>
                                    <div class="list-wrapper">
                                        <ul class="d-flex flex-column-reverse todo-list">
                                            <li>
                                                <div class="form-check"> <label class="form-check-label"> <input
                                                            class="checkbox" type="checkbox"> For what reason would it be
                                                        advisable. <i class="input-helper"></i></label> </div> <i
                                                    class="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                            <li class="completed">
                                                <div class="form-check"> <label class="form-check-label"> <input
                                                            class="checkbox" type="checkbox" checked=""> For what reason
                                                        would it be advisable for me to think. <i
                                                            class="input-helper"></i></label> </div> <i
                                                    class="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                            <li>
                                                <div class="form-check"> <label class="form-check-label"> <input
                                                            class="checkbox" type="checkbox"> it be advisable for me to
                                                        think about business content? <i class="input-helper"></i></label>
                                                </div> <i class="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                            <li>
                                                <div class="form-check"> <label class="form-check-label"> <input
                                                            class="checkbox" type="checkbox"> Print Statements all <i
                                                            class="input-helper"></i></label> </div> <i
                                                    class="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                            <li class="completed">
                                                <div class="form-check"> <label class="form-check-label"> <input
                                                            class="checkbox" type="checkbox" checked=""> Call Rampbo <i
                                                            class="input-helper"></i></label> </div> <i
                                                    class="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                            <li>
                                                <div class="form-check"> <label class="form-check-label"> <input
                                                            class="checkbox" type="checkbox"> Print bills <i
                                                            class="input-helper"></i></label> </div> <i
                                                    class="remove mdi mdi-close-circle-outline"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="accordion accordion-flush" id="accordionToDo">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            Accordion Item #1
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionToDo">
                                        <div class="accordion-body">Placeholder content for this accordion</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                            aria-controls="flush-collapseTwo">
                                            Accordion Item #2
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionToDo">
                                        <div class="accordion-body">Placeholder content for this accordion</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                                            aria-controls="flush-collapseThree">
                                            Accordion Item #3
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionToDo">
                                        <div class="accordion-body">Placeholder content for this accordion</div>
                                    </div>
                                </div>
                            </div> --}}

                            <h1 class=" mt-3">To-Do List</h1>
                            <div class="add-items">
                                <input class="form-control todo-list-input" type="text" id="todo-title"
                                    placeholder="Enter title">
                                <textarea class="form-control mt-3" type="text" id="todo-description" placeholder="Enter description"></textarea>
                            </div class="add-items d-flex">
                            <div><button id="add-btn" class="btn btn-primary mt-3">Add</button></div>
                            <div class="list-container">
                                <div class="accordion accordion-flush" id="accordionToDo">

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Accordion Item #1
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionToDo">
                                            <div class="accordion-body">Placeholder content for this accordion</div>
                                        </div>
                                    </div>

                                </div>
                            </div>






                            {{-- <h1 class=" mt-3">To-Do List</h1>
                            <div class="add-items">
                                <input class="form-control todo-list-input" type="text" id="todo-title"
                                    placeholder="Enter title">
                                <textarea class="form-control mt-3" type="text" id="todo-description" placeholder="Enter description"></textarea>
                            </div class="add-items d-flex">
                            <div><button id="add-btn" class="btn btn-primary mt-3">Add</button></div>
                            <div class="list-container">
                                <ul id="todo-list"></ul>
                            </div> --}}
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
        // Загрузка списка задач из локального хранилища (если есть)
        let todos = [];

        // Отображение списка задач
        function displayTodos() {
            $('#accordionToDo').empty();

            todos.forEach(function(todo, index) { //Add el in accordion
                const deleteBtn = '<span class="btn-close ms-auto" onclick="deleteTodo(' + index + ')"></span>';
                //     class: 'delete-btn ms-auto',
                //     html: '&#10006',
                //     click: function() {
                //         deleteTodo(index);
                //     }
                // });

                const listItem = $('<div>', {
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
                        ${todo.description}
                        </div>
                </div>`
                });


                //listItem.append(deleteBtn);
                $('#accordionToDo').append(listItem);
            });

            // Сохранение списка задач в локальное хранилище
            localStorage.setItem('todos', JSON.stringify(todos));
        }

        // Добавление новой задачи
        $('#add-btn').click(function() {
            const title = $('#todo-title').val();
            const description = $('#todo-description').val();

            if (title && description) {
                todos.push({
                    title: title,
                    description: description,
                });

                $('#todo-title').val('');
                $('#todo-description').val('');

                displayTodos();
            }
        });

        // Удаление задачи
        function deleteTodo(index) {
            todos.splice(index, 1);
            displayTodos();
        }

        displayTodos();

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
        //                     '<strong>Description:</strong> ' + todo.description
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
        //         const description = $('#todo-description').val();

        //         if (title && description) {
        //             todos.push({
        //                 title: title,
        //                 description: description,
        //             });

        //             $('#todo-title').val('');
        //             $('#todo-description').val('');

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
