<?php
include 'config.php';
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$newProjectId = null;

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $name=$_POST['name'];
    $description=$_POST['description'];
    $members=$_POST['members'];

    $stmt=$conn->prepare("SELECT * FROM projects WHERE name=?");
    $stmt->bind_param("s",$name);
    $stmt->execute();
    if($stmt->get_result()->num_rows>0){
        echo "<p style='color:red;'>Project with this name already exists.</p>";
    } else {
        $stmt=$conn->prepare("INSERT INTO projects (name,description) VALUES (?,?)");
        $stmt->bind_param("ss",$name,$description);
        $stmt->execute();
        $newProjectId=$stmt->insert_id;

        $stmt=$conn->prepare("INSERT INTO projectMembership (projectId, memberId) VALUES (?,?)");
        foreach($members as $m){
            $stmt->bind_param("ii",$newProjectId,$m);
            $stmt->execute();
        }
        echo "<p style='color:green;'>Project added successfully.</p>";
    }
}

$users=$conn->query("SELECT userId, firstName, lastName FROM users");

$projects=$conn->query("SELECT * FROM projects");
?>
<h2>Add a Project</h2>
<form method="post">
Project Name: <input type="text" name="name" required><br>
Description: <textarea name="description" required></textarea><br>
Members:<br>
<?php while($u=$users->fetch_assoc()): ?>
<input type="checkbox" name="members[]" value="<?php echo $u['userId']; ?>">
<?php echo $u['firstName']." ".$u['lastName']; ?><br>
<?php endwhile; ?>
<input type="submit" value="Add Project">
</form>

<h2>All Projects</h2>
<?php
while($p=$projects->fetch_assoc()){
    // Highlight if it’s the newly added project
    $style = ($p['projectId']==$newProjectId) ? "background-color: #ffff99; padding:10px;" : "padding:10px;";
    echo "<div style='$style'>";
    echo "<h3>".$p['name']."</h3>";
    echo "<p>".$p['description']."</p>";
    $members=$conn->query("SELECT u.firstName,u.lastName FROM users u JOIN projectMembership pm ON u.userId=pm.memberId WHERE pm.projectId=".$p['projectId']);
    $m=[];
    while($mem=$members->fetch_assoc()) $m[]=$mem['firstName']." ".$mem['lastName'];
    echo "Members: ".implode(", ",$m);
    echo "</div><hr>";
}
?>
