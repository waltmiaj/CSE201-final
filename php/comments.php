<?php
# https://phpenthusiast.com/blog/develop-angular-php-app-getting-the-list-of-items

include_once("config.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
if(isset($postdata) && !empty($postdata))
{
  $title = mysqli_real_escape_string($conn, trim($request));
  $sql = "SELECT * FROM Comments where gTitle='".$title."'";
  $comments = [];

  if($result = mysqli_query($conn,$sql))
  {
    $cr = 0;
    while($row = mysqli_fetch_assoc($result))
    {
      $comments[$cr]['gTitle'] = $row['gTitle'];
      $comments[$cr]['Username'] = $row['Username'];
      $comments[$cr]['Comment'] = $row['Comment'];
      $cr++;
    }
    echo json_encode(['data'=>$comments]); 
    //http_response_code(400);
  }
  else
  {
    http_response_code(404);  
  }
}