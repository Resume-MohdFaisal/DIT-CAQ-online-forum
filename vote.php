<?php

include "_dbconnent.php";

$userid = $_SESSION['sno'];
$thread_id = $_POST['thread_id'];
$type = $_POST['type'];

// Check entry within table
$query = "SELECT COUNT(*) AS cntpost FROM votes WHERE thread_id=".$thread_id." and userid=".$userid;

$result = mysqli_query($con,$query);
$fetchdata = mysqli_fetch_array($result);
$count = $fetchdata['cntpost'];


if($count == 0){
    $insertquery = "INSERT INTO votes(userid,thread_id,type) values(".$userid.",".$thread_id.",".$type.")";
    mysqli_query($con,$insertquery);
}else {
    $updatequery = "UPDATE votes SET type=" . $type . " where userid=" . $userid . " and thread_id=" . $thread_id;
    mysqli_query($con,$updatequery);
}


// count numbers of like and unlike in post
$query = "SELECT COUNT(*) AS cntLike FROM votes WHERE type=1 and thread_id=".$thread_id;
$result = mysqli_query($con,$query);
$fetchlikes = mysqli_fetch_array($result);
$totalLikes = $fetchlikes['cntLike'];

$query = "SELECT COUNT(*) AS cntUnlike FROM votes WHERE type=0 and thread_id=".$thread_id;
$result = mysqli_query($con,$query);
$fetchunlikes = mysqli_fetch_array($result);
$totalUnlikes = $fetchunlikes['cntUnlike'];


$return_arr = array("likes"=>$totalLikes,"unlikes"=>$totalUnlikes);

echo json_encode($return_arr);