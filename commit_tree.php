<?php $options = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT'])); 
session_start();
require "check_logged_in.php";
require "config.php";

$tid = $_SESSION['TEAM_ID'];
$github_repo_query = mysqli_query($con,"SELECT GITHUB_LINK FROM TEAM WHERE ID='$tid'");
while($row = mysqli_fetch_assoc($github_repo_query)) {
    $link = $row['GITHUB_LINK'];
}

$context = stream_context_create($options); 
$json_string = file_get_contents($link."commits", false, $context); 
$parsed_json = json_decode($json_string, false);
echo "<!DOCTYPE html><html><head><meta charset=\"UTF-8\">  </meta><style>
p {
    text-indent: 50px;
}
</style></head><body>";
foreach($parsed_json as $commit)
{
   echo $commit->commit->author->date . '<br>';
   echo "<p>Név: " . $commit->commit->author->name . '</p>';
   echo "<p>Üzenet: " . $commit->commit->message . '</p>';

}
echo "</body></html>";
?>
