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

                    <body>
                        <h1>To-Do List</h1>
                        <div class="input-container">
                            <input type="text" id="todo-title" placeholder="Enter title">
                            <input type="text" id="todo-description" placeholder="Enter description">
                            <button id="add-btn" class="btn btn-primary">Add</button>
                        </div>
                        <div class="list-container">
                            <ul id="todo-list"></ul>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                        <script src="script.js"></script>
                    </body>

                    </html>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Загрузка списка задач из локального хранилища (если есть)
            let todos = JSON.parse(localStorage.getItem('todos')) || [];

            // Отображение списка задач
            function displayTodos() {
                $('#todo-list').empty();

                todos.forEach(function(todo, index) {
                    const listItem = $('<li>', {
                        class: 'list-item',
                        html: '<strong>Title:</strong> ' + todo.title + ': ' +
                            '<strong>Description:</strong> ' + todo.description
                    });

                    const deleteBtn = $('<span>', {
                        class: 'delete-btn ml-2',
                        html: '&#10006',
                        click: function() {
                            deleteTodo(index);
                        }
                    });

                    listItem.append(deleteBtn);
                    $('#todo-list').append(listItem);
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
                        description: description
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
        });
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
    </style>
@endsection
