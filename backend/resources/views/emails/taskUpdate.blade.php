<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Status Updated</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .panel {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .footer {
            text-align: center;
            padding: 16px 0;
            background-color: #f3f4f6;
            color: #6b7280;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Task Status Updated</h1>
    <p>Hello,</p>
    <p>The status of the task <strong>{{ $task->title }}</strong> has been updated.</p>

    <div class="panel">
        <h3>Task Details</h3>
        <ul>
            <li><strong>Title:</strong> {{ $task->title }}</li>
            <li><strong>Description:</strong> {{ $task->description }}</li>
            <li><strong>Status:</strong> <span
                    style="color: {{ $task->status === 'completed' ? '#16a34a' : '#eab308' }}">{{ ucfirst($task->status) }}</span>
            </li>
            <li><strong>Priority:</strong> <span
                    style="color: {{ $task->priority === 'high' ? '#dc2626' : ($task->priority === 'medium' ? '#f97316' : '#0ea5e9') }}">{{ ucfirst($task->priority) }}</span>
            </li>
        </ul>
    </div>

    <a class="button" href="{{ url('/tasks/' . $task->id) }}">View Task</a>

    <p>Thanks,<br>{{ config('app.name') }}</p>

    <div class="footer">
        <p>If you have any questions, feel free to reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
