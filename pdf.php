<?php
$newa=[];
require('header.php');
require ('db_connect.php');
require('fpdf/fpdf.php');
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]!==true ){
    header("Location: bootstrapform.php");
}
$uniqueidb = $_SESSION['uniqueid'];
$gettingidfromurl=$_GET['userprojectid'];
$_GET=
ob_end_clean(); //    the buffer and never prints or returns anything.
ob_start();


$sql2 = "SELECT * FROM project_info WHERE `user_id` = '$uniqueidb' AND  `project_id` = '$gettingidfromurl' ";

   
     $results = $conn->query($sql2);

         if ($results->num_rows > 0) {
     
       
            while($row = $results->fetch_assoc()) {
                $user_projectid=$row['project_id'];
                $user_projectname=$row['project_name'];
                $user_projectmember=$row['project_member'];
                $user_projectduration=$row['project_duration'];
                $user_projecttechnology=$row['project_technologies'];


                $sql1 = "SELECT * FROM `project_skills` WHERE  `project_id` = '$user_projectid'  ";
                $result1 = $conn->query($sql1);
        
                 if ($result1->num_rows > 0) {
                    while($row = $result1->fetch_assoc()) {
                     $user=$row['user_project_skill'];
                     $newa[].=$user;
                     
                    }
                   $im=implode(",",$newa);
                   $newa=[];
                 }

            }
        }
            // echo $user_projectid;
            $title = "Project report";

$pdf = new FPDF();
$pdf->AddPage();
$pdf-> SetTitle($title);
$pdf->SetFont('Arial','B',16);
$w = $pdf->GetStringWidth($title)+6;
    $pdf->SetX((210-$w)/2);
    // Colors of frame, background and text
    $pdf->SetDrawColor(221,221,221,1);
    $pdf->SetFillColor(10,158,0,1);
    $pdf->SetTextColor(255,255,255,1);
    // Thickness of frame (1 mm)
    $pdf->SetLineWidth(1);
    // Title
    // Cell(width, height, content, border, nextline parametters, alignement[c - center], fill)
    $pdf->Cell($w, 9, $title, 1, 1, 'C', true);
    // Line break
    $pdf->Ln(10);

    $pdf->SetTextColor(0,0,0,1);
    $w = $pdf->GetStringWidth($user_projectname)+6;
    $pdf->SetX((125-$w)/2);
    $pdf->Cell(70, 10, 'Project name:', 1, 0, 'C');
    $pdf->Cell($w+30, 10, $user_projectname, 1, 1, 'C');

    $pdf->SetX((125-$w)/2);
    $pdf->Cell(70, 10, 'Project member:', 1, 0, 'C');
    $pdf->Cell($w+30, 10, $user_projectmember, 1, 1, 'C');

    $pdf->SetX((125-$w)/2);
    $pdf->Cell(70, 10, 'Project duration:', 1, 0, 'C');
    $pdf->Cell($w+30, 10, $user_projectduration, 1, 1, 'C');

    $pdf->SetX((125-$w)/2);
    $pdf->Cell(70, 10, 'Project Technologies:', 1, 0, 'C');
    $pdf->Cell($w+30, 10, $user_projecttechnology, 1, 1, 'C');

    $pdf->SetX((125-$w)/2);
    $pdf->Cell(70, 10, 'Skills used:', 1, 0, 'C');
    $pdf->Cell($w+30, 10, $im , 1, 1, 'C');

    $pdf->Image('1.jpeg', 130, 100, 40, 15, 'jpeg');
    $pdf->Output();
    ob_end_flush();
?>