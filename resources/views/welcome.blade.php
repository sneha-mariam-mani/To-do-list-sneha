
<!DOCTYPE html>
<html>
<head>
    <title>My To-Do List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #FDD3DD;
        }

        .container {
            width: 400px;
            max-width: calc(100% - 70px);
            margin: 100px auto;
            background: white;
            padding: 25px;
            border: 4px solid #AD1E2F;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #AD1E2F;
        }

        .add-form {
            display: flex;
            gap: 10px;
        }

        input {
            flex: 1;
            min-width: 0;
            padding: 10px;
        }

        button {
            padding: 10px 12px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .add, .complete {
            background: #AD1E2F;
        }

        .edit {
            background: #E8788A;
        }

        .delete {
            background: #333333;
        }

        .task-list {
            padding-left: 20px;
        }

        .task-item {
            margin: 18px 0;
            overflow-wrap: anywhere;
        }

        .completed {
            text-decoration: line-through;
            color: gray;
        }

        .task-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }

        .task-actions form {
            display: inline;
        }

        .edit-form {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .edit-form input {
            width: 100%;
        }

        .error {
            color: #AD1E2F;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>My To-Do List</h1>

        @if ($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form class="add-form" action="/add" method="POST">
            @csrf

            <input
                type="text"
                name="task"
                placeholder="Enter a task"
                value="{{ old('task') }}"
                required
            >

            <button class="add" type="submit">Add</button>
        </form>

        <ul class="task-list">
            @foreach ($tasks as $index => $task)
                <li class="task-item">

                    @if ($editIndex !== null && $editIndex == $index)

                        <form class="edit-form"
                              action="/edit/{{ $index }}"
                              method="POST">
                            @csrf

                            <input
                                type="text"
                                name="task"
                                value="{{ $task['name'] }}"
                                required
                            >

                            <button class="edit" type="submit">
                                Save
                            </button>

                        </form>

                    @else

                        @if ($task['completed'])
                            <span class="completed">
                                {{ $task['name'] }}
                            </span>
                        @else
                            <span>{{ $task['name'] }}</span>
                        @endif

                        <div class="task-actions">

                            @if (!$task['completed'])
                                <form action="/complete/{{ $index }}"
                                      method="POST">
                                    @csrf
                                    <button class="complete" type="submit">
                                        Complete
                                    </button>
                                </form>
                            @endif

                            <a href="/edit/{{ $index }}">
                                <button class="edit" type="button">
                                    Edit
                                </button>
                            </a>

                            <form action="/delete/{{ $index }}"
                                  method="POST">
                                @csrf
                                <button class="delete" type="submit">
                                    Delete
                                </button>
                            </form>

                        </div>

                    @endif

                </li>
            @endforeach
        </ul>

    </div>
</body>
</html>
