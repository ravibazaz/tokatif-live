<?php
require_once('smtp.php');
require_once('db_connection.php');

$sql = "SELECT * FROM booking WHERE booking_date = CURDATE() AND (status = '1' OR status = '4') AND teacher_email_notification_status = '0' ORDER BY booking_date ASC";  
$result = mysqli_query($con, $sql);

// Associative array
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
        $booking_amount = $row["booking_amount"];
        $communication_tool = $row["communication_tool"];
        $communication_account_id = $row["communication_account_id"];
        $status = $row["status"];
        
        if (strtotime(date('H:i')) <= strtotime($booking_time)) {
            $time_status = 'true';   
            
            $currentDtTime = date('Y-m-d H:i');
            $bookingDtTime = $booking_date." ".$booking_time;
            $date1 = new DateTime($currentDtTime);
            $date2 = new DateTime($bookingDtTime);
            $diff_mins = abs($date1->getTimestamp() - $date2->getTimestamp()) / 60;
            
        }else{
            $time_status = 'false';
            $diff_mins= '';
        }

        $bookingArr[] = array(
                            'booking_id'=>$booking_id,
                            'teacher_id'=>$teacher_id,
                            'student_id'=>$student_id,
                            'lesson_id'=>$lesson_id,
                            'lesson_package_id'=>$lesson_package_id,
                            'booking_date'=>$booking_date,
                            'booking_time'=>$booking_time,
                            'current_time'=>date('H:i'),
                            'time_status'=>$time_status,
                            'time_difference'=>$diff_mins,
                            'booking_amount'=>$booking_amount,
                            'communication_tool'=>$communication_tool,
                            'communication_account_id'=>$communication_account_id,
                            'status'=>$status
                        );
    }
    
    //print_r($bookingArr);
    
    $html = '';
    
    foreach($bookingArr as $val){
        $time_difference = $val['time_difference'];
        $student_id = $val['student_id'];
        $teacher_id = $val['teacher_id'];
        $lesson_id = $val['lesson_id'];
        $booking_id = $val['booking_id'];
        $booking_date = $val['booking_date'];
        $booking_time = $val['booking_time'];
        
        $datetime = date("jS F, Y", strtotime($booking_date)).' at '.$booking_time;
        
        //echo "zzzzzzz ".$time_difference; exit(); 
        
        if($time_difference>0 && $time_difference>=30){ 
            $stu_sql = "SELECT name,email FROM registrations WHERE id = $student_id ";  
            $stu_result = mysqli_query($con, $stu_sql);
            
            $studentName = '';
            $studentEmail = '';
            if(mysqli_num_rows($stu_result)>0){
                while($stu_row = mysqli_fetch_assoc($stu_result)){
                    $studentName .= $stu_row["name"];
                    $studentEmail .= $stu_row["email"];
                }
            }
            
            

            $t_sql = "SELECT name,email FROM registrations WHERE id = $teacher_id ";  
            $t_result = mysqli_query($con, $t_sql);
            $teacherName = '';
            $teacherEmail = '';
            if(mysqli_num_rows($t_result)>0){
                while($t_row = mysqli_fetch_assoc($t_result)){
                    $teacherName .= $t_row["name"];
                    $teacherEmail .= $t_row["email"];
                }
            }
            
            
            $subject = 'Your lesson with '.$studentName.' will start on '.$datetime; 
            
            $base_url = "http://" . $_SERVER['SERVER_NAME'] ."/lesson-detail/". $lesson_id; 
            
            $html .= 'Hi, <b>'.$teacherName.'</b><br><br>';
            $html .= 'Just a friendly reminder to let you know that you have a lesson with '.$studentName.' on '.$datetime.'. For more details, please click on the button below: <br>';
            $html .= 'Student: '.$studentName.'<br>'; 
            $html .= 'Lesson ID: '.$lesson_id.'<br>';
            $html .= 'Lesson Date/Time: '.date("jS F, Y", strtotime($booking_date)).'/'.$booking_time.'<br><br>'; 
            $html .= '<a href="'.$base_url.'">View Lesson Details</a><br><br>';
            $html .= 'Kind regards,<br>Tokatif Team';
            
            echo $time_difference."<br>";
            /*echo "stu:: ".$studentName." ".$studentEmail."<br>";
            echo "tea:: ".$teacherName." ".$teacherEmail."<br>";
            echo $subject."<br>";
            echo $html."<br>";*/
            
            $to = $teacherEmail;
            $toName = $teacherName;
          
            $sendEmailStatus = send_smtp_mail($to, $toName, $subject, $html);
            
            if($sendEmailStatus == 1){ 
                $action = 'Lesson start notification has been sent.';
                $created_at = date('Y-m-d H:i:s');
                
                $lessonLogInsert = "INSERT INTO lesson_log (lesson_id, lesson_package_id, teacher_id, student_id, booking_id, action, lesson_accept_reject, created_at) 
                                                    VALUES ('".$lesson_id."', '".$order_id."', '".$teacher_id."', '".$student_id."', '".$booking_id."', '".$action."', '0', '".$created_at."')";
                        
                $lessonLogInsertResult = mysqli_query($con, $lessonLogInsert); 
                
                $updateSql = "UPDATE booking SET teacher_email_notification_status = '1' WHERE id = '$booking_id' "; 
                $update = mysqli_query($con, $updateSql);
                
                if($update){
                    echo 'Email has been sent & teacher email notification status updated.';
                }else{
                    echo 'Email has been sent & teacher email notification status not updated!!';
                }
                
            }else{
                echo 'Email not sent!!';
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