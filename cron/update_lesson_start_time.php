<?php
require_once('smtp.php');
require_once('db_connection.php');

$sql = "SELECT * FROM booking WHERE booking_date = CURDATE() AND (status = '1' OR status = '4') AND teacher_accept_status = '1' AND student_accept_status = '1' ORDER BY booking_date ASC";  
$result = mysqli_query($con, $sql);

echo "<pre>";
if(mysqli_num_rows($result)>0){
    
    $bookingArr = array();
    while($row = mysqli_fetch_assoc($result)){
        $booking_id = $row["id"];
        $teacher_id = $row["teacher_id"];
        $student_id = $row["student_id"];
        $lesson_id = $row["lesson_id"];
        $lesson_package_id = $row["lesson_package_id"];
        $booking_date = $row["booking_date"];
        $booking_time = $row["booking_time"];
        $lessonStartTime = $row["lesson_started_at"];

        
        if (strtotime(date('H:i')) <= strtotime($booking_time)) {
            
            $currentDtTime = date('Y-m-d H:i');
            $bookingDtTime = $booking_date." ".$booking_time;
            $date1 = new DateTime($currentDtTime);
            $date2 = new DateTime($bookingDtTime);
            $diff_mins = abs($date1->getTimestamp() - $date2->getTimestamp()) / 60;
            
            //echo $booking_id." == ".$booking_time." diff: ".$diff_mins.'<br>';
            
            if($lessonStartTime=='' && $diff_mins>=2 && $diff_mins<=60){
                $lesson_started_at = date('Y-m-d H:i:s');
                
                $updateSql = "UPDATE booking SET lesson_started_at = '$lesson_started_at' WHERE id = '$booking_id' "; 
                $update = mysqli_query($con, $updateSql);
                
                if($update){
                    echo 'start time updated of booking: '.$booking_id;
                }else{
                    echo 'N/A';
                }
            
            }
            
        }
        
    }
}else{
    echo "0 rows";
}


// Free result set
mysqli_free_result($result);

mysqli_close($con);

?>