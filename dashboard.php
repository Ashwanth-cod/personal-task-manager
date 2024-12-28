<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

print_r($_SESSION);

include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Taskio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" width="30" height="30" class="d-inline-block align-top" alt=""> Taskio
        </a>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="features.html">Features</a></li>
                <li class="nav-item active"><a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header Section -->
    <div class="jumbotron jumbotron-fluid bg-primary text-white">
        <div class="container">
            <h1 class="display-4">Welcome, </h1>
            <p class="lead">Manage your tasks, monitor your progress, and stay organized.</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 mb-4"><button class="btn btn-success btn-block" data-toggle="modal" data-target="#createTaskModal">Create Task</button></div>
            <div class="col-md-3 mb-4"><button class="btn btn-info btn-block" data-toggle="modal" data-target="#viewTaskModal">View Task</button></div>
            <div class="col-md-3 mb-4"><button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteTaskModal">Delete Task</button></div>
            <div class="col-md-3 mb-4"><button class="btn btn-warning btn-block" data-toggle="modal" data-target="#previousTaskModal">Previous Task</button></div>
        </div>
    </div>
    
    <!-- Modal for Create Task -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Create a New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="create_task.php" method="POST">
                        <div class="form-group">
                            <label for="taskTitle">Task Title</label>
                            <input type="text" class="form-control" id="taskTitle" name="taskTitle" placeholder="Enter task title" required>
                        </div>
                        <div class="form-group">
                            <label for="taskDescription">Description</label>
                            <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" placeholder="Enter task description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for View Task -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">View Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Enter Task ID to view the task details:</p>
                    <form method="POST" action="view_task.php">
                        <div class="form-group">
                            <label for="viewTaskId">Task ID</label>
                            <input type="number" class="form-control" id="viewTaskId" name="taskId" placeholder="Enter task ID">
                        </div>
                        <button type="submit" class="btn btn-info">View Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Task -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskModalLabel">Delete Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Enter the Task ID to delete:</p>
                    <form method="POST" action="delete_task.php">
                        <div class="form-group">
                            <label for="deleteTaskId">Task ID</label>
                            <input type="number" class="form-control" id="deleteTaskId" name="taskId" placeholder="Enter task ID">
                        </div>
                        <button type="submit" class="btn btn-danger">Delete Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Previous Task -->
    <div class="modal fade" id="previousTaskModal" tabindex="-1" role="dialog" aria-labelledby="previousTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previousTaskModalLabel">Previous Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Displaying details of the most recently completed task:</p>
                    <form method="POST" action="previous_task.php">
                        <button type="submit" class="btn btn-warning">View Previous Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-light text-center py-3">
        <p>&copy; 2024 Taskio. All rights reserved.</p>
    </footer>

    <!-- Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
