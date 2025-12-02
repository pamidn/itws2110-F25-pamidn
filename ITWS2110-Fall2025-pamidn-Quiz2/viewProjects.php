<?php
include 'config.php';
$projects=$conn->query("SELECT * FROM projects");
while($p=$projects->fetch_assoc()){
    echo "<h3>".$p['name']."</h3>";
    echo "<p>".$p['description']."</p>";
    $members=$conn->query("SELECT u.firstName,u.lastName FROM users u JOIN projectMembership pm ON u.userId=pm.memberId WHERE pm.projectId=".$p['projectId']);
    $m=[];
    while($mem=$members->fetch_assoc()) $m[]=$mem['firstName']." ".$mem['lastName'];
    echo "Members: ".implode(", ",$m);
    echo "<hr>";
}
