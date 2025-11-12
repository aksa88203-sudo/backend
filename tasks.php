<?php
include('connection.php');

// 🟢 ADD TASK
if (isset($_POST['addTask'])) {
  $taskName = trim($_POST['taskName']);
  $priority = $_POST['priority'];
  $timeframe = $_POST['timeframe'];

  if (!empty($taskName) && preg_match("/^[a-zA-Z\s]+$/", $taskName)) {
    $query = "INSERT INTO tasks (task_name, priority, timeframe) VALUES ('$taskName', '$priority', '$timeframe')";
    $result = mysqli_query($con, $query);

    if ($result) {
      echo "<script>alert('Task added successfully!');</script>";
    } else {
      echo "<script>alert('Database error: " . mysqli_error($con) . "');</script>";
    }
  } else {
    echo "<script>alert('Invalid data! Please enter a valid name.');</script>";
  }
}

// 🔄 UPDATE TASK
if (isset($_POST['updateTask'])) {
  $id = $_POST['id'];
  $taskName = trim($_POST['taskName']);
  $priority = $_POST['priority'];
  $timeframe = $_POST['timeframe'];

  if (!empty($taskName) && preg_match("/^[a-zA-Z\s]+$/", $taskName)) {
    $query = "UPDATE tasks SET task_name='$taskName', priority='$priority', timeframe='$timeframe' WHERE id=$id";
    $result = mysqli_query($con, $query);

    if ($result) {
      echo "<script>alert('Task updated successfully!'); window.location='apptask.php';</script>";
      exit();
    } else {
      echo "<script>alert('Update failed: " . mysqli_error($con) . "');</script>";
    }
  } else {
    echo "<script>alert('Invalid data!');</script>";
  }
}

// 🗑 DELETE TASK
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($con, "DELETE FROM tasks WHERE id=$id");
  header("Location: apptask.php");
  exit();
}

// ✅ MARK COMPLETE / INCOMPLETE
if (isset($_GET['complete'])) {
  $id = $_GET['complete'];
  mysqli_query($con, "UPDATE tasks SET completed = NOT completed WHERE id=$id");
  header("Location: apptask.php");
  exit();
}

// ✏ EDIT MODE (fetch existing task)
$editMode = false;
$editTask = null;
if (isset($_GET['edit'])) {
  $editMode = true;
  $id = $_GET['edit'];
  $resultEdit = mysqli_query($con, "SELECT * FROM tasks WHERE id=$id");
  $editTask = mysqli_fetch_assoc($resultEdit);
}

// 📋 FETCH ALL TASKS
$result = mysqli_query($con, "SELECT * FROM tasks ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🌸 Daily Task Planner</title>
  <style>
    * {margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;}
    body {background:linear-gradient(135deg,#a8edea,#fed6e3);display:flex;justify-content:center;align-items:center;min-height:100vh;}
    .container {background:#ffffffcc;width:400px;padding:30px;border-radius:20px;box-shadow:0 10px 25px rgba(0,0,0,0.1);text-align:center;}
    h1 {margin-bottom:20px;color:#444;}
    form {display:flex;flex-direction:column;gap:15px;}
    input,select,button {padding:10px;border:none;border-radius:12px;font-size:15px;}
    input,select {background:#f8f8f8;}
    button {background:linear-gradient(135deg,#a8edea,#fed6e3);cursor:pointer;transition:0.3s;}
    button:hover {transform:scale(1.05);}
    ul {list-style:none;margin-top:20px;max-height:220px;overflow-y:auto;padding:0;}
    li {background:#fff;margin:8px 0;padding:10px;border-radius:10px;display:flex;justify-content:space-between;align-items:center;}
    li.completed span{text-decoration:line-through;color:gray;}
    .actions button {margin-left:5px;padding:6px 10px;border:none;border-radius:8px;cursor:pointer;}
    .actions a {text-decoration:none;}
  </style>
</head>
<body>
  <div class="container">
    <h1>🌸 Daily Task Planner</h1>

    <!-- ADD or EDIT FORM -->
    <form method="POST" action="">
      <?php if ($editMode): ?>
        <input type="hidden" name="id" value="<?= $editTask['id'] ?>">
        <input type="text" name="taskName" value="<?= htmlspecialchars($editTask['task_name']) ?>" required>
        <select name="priority">
          <option value="low" <?= $editTask['priority']=='low'?'selected':'' ?>>Low Priority</option>
          <option value="medium" <?= $editTask['priority']=='medium'?'selected':'' ?>>Medium Priority</option>
          <option value="high" <?= $editTask['priority']=='high'?'selected':'' ?>>High Priority</option>
        </select>
        <select name="timeframe">
          <option value="daily" <?= $editTask['timeframe']=='daily'?'selected':'' ?>>Daily Task</option>
          <option value="weekly" <?= $editTask['timeframe']=='weekly'?'selected':'' ?>>Weekly Task</option>
        </select>
        <button type="submit" name="updateTask">Update Task</button>
        <a href="apptask.php"><button type="button">Cancel</button></a>
      <?php else: ?>
        <input type="text" name="taskName" placeholder="Enter your task..." required>
        <select name="priority">
          <option value="low">Low Priority</option>
          <option value="medium">Medium Priority</option>
          <option value="high">High Priority</option>
        </select>
        <select name="timeframe">
          <option value="daily">Daily Task</option>
          <option value="weekly">Weekly Task</option>
        </select>
        <button type="submit" name="addTask">Add Task</button>
      <?php endif; ?>
    </form>

    <!-- TASK LIST -->
    <ul>
      <?php while ($task = mysqli_fetch_assoc($result)): ?>
        <li class="<?= $task['completed'] ? 'completed' : '' ?>">
          <span><?= htmlspecialchars($task['task_name']) ?> (<?= $task['timeframe'] ?>)</span>
          <div class="actions">
            <a href="?complete=<?= $task['id'] ?>"><button>✅</button></a>
            <a href="?edit=<?= $task['id'] ?>"><button>✏</button></a>
            <a href="?delete=<?= $task['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?');"><button>🗑</button></a>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</body>
</html>