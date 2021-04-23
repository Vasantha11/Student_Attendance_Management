<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VSM Group of Institutions</title>
 
  

<?php
include("dbConfig.php");
session_start();
include("checklogin.php");
$errormsg= '';

$user=$_SESSION["username"];


?>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<link href="css/ui.css" rel="stylesheet" />
	<link href="css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />	
	<link href="css/datepicker.css" rel="stylesheet" />	
	   <link href="css/datatable/datatable.css" rel="stylesheet" />
	   
    <script src="js/jquery-1.10.2.js"></script>	
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   <script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
 
		 <script src="js/dataTable/jquery.dataTables.min.js"></script>
		
	
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;
 
    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
function exportTableToCSV(filename) {
	 
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
</script>
<script type="text/javascript">
$(document).ready(function(){
     $('#programcode').on('change',function(){
        var programcode= $(this).val();
        
        if(programcode){
            $.ajax({
                type:'POST',
                url:'ajaxDept.php',
                data:'programcode='+programcode,
                success:function(html){
                    $('#deptcode').html(html);
                }
            });
			$.ajax({
                type:'POST',
                url:'ajaxperiods.php',
                data:'ucoursesem='+programcode,
                success:function(html){     
                    $('#semester').html(html);
                }
            }); 
			$.ajax({
                type:'POST',
                url:'ajaxperiods.php',
                data:'ucourseyear='+programcode,
                success:function(html){     
                    $('#studyyear').html(html);
                }
            });			
        }else{
            $('#deptcode').html('<option value="">Select Program first </option>');
        }
    }); 
     $('#deptcode').on('change',function(){
        var deptcode= $(this).val();
       
        if(deptcode){
            $.ajax({
                type:'POST',
                url:'ajaxDept.php',
                data:'deptcode='+deptcode,
                success:function(html){
                var d= html.split(";")
                    $('#coursecode').html(d[0]);
                    $('#facultycode').html(d[1]);
                }
            });
			
        }else{
            $('#coursecode').html('<option value="">Select Department first </option>');
            $('#facultycode').html('<option value="">Select Department first </option>');
        }
    }); 
     $('#semester').on('change',function(){
        var facultycode= $('#facultycode').val();
       var studyyear= $('#studyyear').val();
       var semester= $('#semester').val();
       var coursecode= $('#coursecode').val();
	    
        var section= $('#section').val();
      var adate= $('#adate').val();
	  var acyear= $('#acyear').val();
        var semester= $(this).val();
        
        if(semester){
            $.ajax({
                type:'POST',
                url:'ajaxDept.php',
                data:{facultycode:facultycode,studyyear:studyyear,semester:semester,section:section,coursecode:coursecode},
                success:function(html){
                    
                    $('#papercode').html(html);
                }
            }); 
			
			
			
        }else{
            $('#papercode').html('<option value="">Select Course first </option>');
        }
    });  
	
    $('#facultycode').on('change',function(){
        var facultycode= $(this).val();
       
        if(facultycode){
            $.ajax({
                type:'POST',
                url:'ajaxDept.php',
                data:'facultycode='+facultycode,
                success:function(html){
                    $('#papercode').html(html);
                }
            }); 
        }else{
            $('#papercode').html('<option value="">Select Course first </option>');
        }
    }); 
	$('#studyyear').on('change',function(){
        var  year= $(this).val();
       var course = $('#programcode').val();
	    
        if(year){
            $.ajax({
                type:'POST',
                url:'ajaxperiods.php',
                data:'usdyear='+year+'&usdcourse='+course,
                success:function(html){   
					 
                    $('#semester').html(html);
                }
            });
        }else{
            $('#studyyear').html('<option value="">Select Study Year first </option>');
        }
    });
$('#papercode').on('change',function(){
        var  papercode= $(this).val();
       var course = $('#programcode').val();
	    
        if(papercode){
            $.ajax({
                type:'POST',
                url:'ajaxperiods.php',
                data:'papercode='+papercode+'&usdcourse='+course,
                success:function(html){   
			 	 	 
             if(html=="Practical") 
			{ 
 		
			$('.z').show();
			 
			}
			else
			{
			$('.z').hide();
			}
          }
        });
        }else{
            $('#studyyear').html('<option value="">Select Paper Code first </option>');
        }
    }); 	
 }); 
 </script> 
 
<!--//paymentHeders-->
<?php
include("headerEN.php");
?>	
</head>
<BODY >

 
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Subject based Attendance  
						</h1>
						 
						 

                    </div>
                </div>
				
				
				
    	<?php
		echo $errormsg;
		date_default_timezone_get('Asia/Kolkata');
            $d=date('Y-m-d-H:i:s');
            $d1=date('Y-m-d');
            $atdate= date("d-m-Y", strtotime($d));
		?>

                
<div class="row" style="margin-bottom:20px;">
<div class="col-md-12">

<fieldset class="scheduler-border" >
    <legend  class="scheduler-border">View Student List :</legend>
<?php 
$deptcode="";
$coursecode="";
$programcode="";
$batch="";
$studyyear="";
$semester="";
$section="";
 if(isset($_POST['deptcode']))
	$deptcode=$_POST['deptcode'];
if(  !isset($_POST['bulksearch']))
{
	
 ?>
    <form action="atten_subject_hrs.php" method="post" id="signupForm1" class="form-horizontal">
                        <div class="panel-body">
                        <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="acyear">Academic year</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="acyear" name="acyear" value="<?php
				 
				if(date('n')<=5) echo (date('Y')-1).'-'.(date('Y')); else echo (date('Y')).'-'.(date('Y')+1); ?>"  />
				</div>	</div>
			
                        
                        
                        <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="programcode"> Program Name</label>
                         	  <?php
					$sql = "select * from tblProgram "; 
					$rs_result = $conn->query ($sql); 
					echo "<div class='col-sm-10'> <select class='form-control' name='programcode' id='programcode'>";
					 
					echo " <option value=''>Select Program Code</option>";
					while ($row =  $rs_result->fetch_assoc()) {  ?>
					 <option  <?php  if ($programcode== $row['programcode'] ) echo 'selected' ;?>   value=<?php echo $row['programcode'];?> > <?php echo $row['programname'];?> </option>
                                  <?php        } 
mysqli_free_result ($rs_result);
					echo "</select></div>";
					?>
					</div>
				<div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="deptcode">Department Name</label>
                         	   
			 <?php
					$sql = "select * from tblDept   "; 
					$rs_result = $conn->query ($sql); 
					echo "<div class='col-sm-10'> <select class='form-control' name='deptcode' id='deptcode'>";
					 
					while ($row =  $rs_result->fetch_assoc()) {  ?>
					 <option  <?php  if ($deptcode== $row['deptcode'] ) echo 'selected' ;?>   value=<?php echo $row['deptcode'];?> > <?php echo $row['deptname'];?> </option>
                                  <?php        }
                                  mysqli_free_result ($rs_result);
					echo "</select></div>";
					?>				
					</div>	
					<div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="coursecode">CourseName</label>
                         	  <?php
					$sql = "select * from tblCourses "; 
					$rs_result = $conn->query ($sql); 
					echo "<div class='col-sm-10'> <select class='form-control' name='coursecode' id='coursecode' required>";
if(substr($coursecode,0,9)=="BTECH-HBS") 
   $coursecode1=substr($coursecode,0,5).substr($coursecode,9,4);

					  
					while ($row =  $rs_result->fetch_assoc()) { 

if(substr($coursecode,0,9)=="BTECH-HBS"){ ?>
					 <option  <?php  if ($coursecode1== $row['coursecode'] ) echo 'selected' ;?>   value=<?php echo $row['coursecode'];?> > <?php echo $row['coursename'];?> </option>
                                  <?php 
}
else
{ ?>
 <option  <?php  if ($coursecode== $row['coursecode'] ) echo 'selected' ;?>   value=<?php echo $row['coursecode'];?> > <?php echo $row['coursename'];?> </option>
<?php }
       }
                                  mysqli_free_result ($rs_result);
					echo "</select></div>";
					?>
					</div>	
					
					<div class="form-group">
							<label class="col-sm-4 control-label" style="text-align: left"  for="section">Section</label>
                         			 <div class='col-sm-10'> <select class='form-control' name='section' id='section'>
                         			 <?php if($studyyear!='') echo " <option value=$section>$section</option>"; ?>
						 <option value='A'>A</option>
						  <option value='B'>B</option>
						    <option value='C'>C</option>
						    <option value='D'>D</option>
						</select>
						</div>
					</div>	
				  <div class="form-group">
				<label class="col-sm-4 control-label"  style="text-align: left" for="studyyear">Study Year</label>
                         	  <?php
					echo "<div class='col-sm-10'> <select class='form-control' name='studyyear' id='studyyear'  required>";
					if($studyyear!="")
					echo " <option value='$studyyear'>$studyyear</option>";
					echo " <option value=''>Select Study Year</option>";
					echo " <option value='I Year'>I Year</option>";
					echo " <option value='II Year'>II Year</option>"; 
					echo " <option value='III Year'>III Year</option>";
                    echo " <option value='IV Year'>IV Year</option>";
					echo "</select></div>"; 
					?>
					</div>
					<div class="form-group">
				<label class="col-sm-4 control-label"  style="text-align: left" for="semester">Semester</label>
                         	  <?php
					echo "<div class='col-sm-10'> <select class='form-control' name='semester' id='semester'  required>";
					if($studyyear!="")
					echo " <option value='$semester'>$semester</option>";
					echo " <option value=''>Select Semester</option>";
					
					
					echo "</select></div>";
					?>
					</div>	
					  <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="facultycode">Subject/Paper Name</label>
                         	  <?php
							  $cc="";
                         	       if ($coursecode=="BTECH-CIVIL") $cc="CVL";
                         	       if ($coursecode=="BTECH-CSE") $cc="CSE";
                         	       if ($coursecode=="BTECH-MECH") $cc="MEC";
                         	       if ($coursecode=="BTECH-ECE") $cc="ECE";
                         	       if ($coursecode=="BTECH-EEE") $cc="EEE";
								   if ($coursecode=="DIPLO-DME") $cc="DME";
                         	       if ($coursecode=="DIPLO-DEC") $cc="DEC";
                         	       if ($coursecode=="DIPLO-DEE") $cc="DEE";


				    //   if (substr($coursecode,0,9)=="BTECH-HBS") $cc="HBS";
//if(substr($coursecode,0,9)=="BTECH-HBS") 
 //  $coursecode=substr($coursecode,0,5).substr($coursecode,9,4);
   //                                    if($cc=="HBS")
//{
//$sql = "SELECT papercode,papername  FROM tblPapers WHERE  studyyear= '".$_POST['studyyear']."' and semester= '".$_POST['semester']."'  and section= '".$_POST['section']."' and subjectcode like '%".substr($_POST["coursecode"],0,9)."%' and papercode like '%".substr($_POST['coursecode'],10,3)."%' ";


//}
//else
					$sql = "select * from tblPapers where subjectcode like '%$cc%' and studyyear='$studyyear' and semester='$semester' and section='$section'"; 
					$rs_result = $conn->query ($sql); 
					echo "<div class='col-sm-10'> <select class='form-control' name='papercode' id='papercode'   required >";
					 
					 
					while ($row =  $rs_result->fetch_assoc()) {  ?>
					 <option  <?php  if ($papercode== $row['papercode'] ) echo 'selected' ;?>   value=<?php echo $row[papercode];?> > <?php echo $row[papername];?> </option>
                                  <?php        }
                                  mysqli_free_result ($rs_result);
					echo "</select></div>";
					?>
					</div>
					<div style='display:none;' class='z'>
					<div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="batch">Lab Batch</label>
				 
				<?php
					echo "<div class='col-sm-10'> <select class='form-control' name='batch' id='batch'    >";
					if($batch!="")
					echo " <option value='$batch'>$batch</option>";
					echo " <option value=''>Select Lab Batch</option>";
					echo " <option value='Batch-I'>Batch-I</option>";
					echo " <option value='Batch-II'>Batch-II</option>"; 
					echo " <option value='Batch-III'>Batch-III</option>";
                    echo " <option value='Batch-IV'>Batch-IV</option>";
					echo "</select></div>"; 
					?>
				  
				</div>
			</div>				
					 <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">From Date</label>
				<div class="col-sm-10">
				<input type="date" class="form-control" id="fromdate" name="fromdate" value="<?php echo date('Y-m-d'); ?>"  />
				</div>	</div>
				  <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">To Date</label>
				<div class="col-sm-10">
				<input type="date" class="form-control" id="todate" name="todate" value="<?php echo date('Y-m-d'); ?>"  />
				</div>	</div> 
				
		 
		  <br>	
		 
					<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="id" value="<?php echo $deptcode;?>">
								<input type="hidden" name="action" value="<?php echo $action;?>">
								
									<button type="submit" name="bulksearch" class=  "btn btn-primary">Get Students List </button>
								</div>
							</div>
                         
                           
                           
                         
                           
                         </div>
							</form>
			

<?php
}
?>
<!--search by pin-->
<?php if(isset($_POST['bulkpost']))
{
        
    $course=$_POST['pcourse'];
    
    $date=$_POST['pdate'];
	 
    $branch=$_POST['pbranch'];
	$section=$_POST['psection'];
	 
    $studyyear=$_POST['pstudyyear'];
	$semester=$_POST['psemester'];	
	 
    $deptcode=$_POST['pdeptcode'];
	$papercode=$_POST['ppapercode'];
	$batch=$_POST['pbatch'];
	$prd=$_POST['pprds'];
	
	
	$prds=explode(" ",$prd);
	 
	$rno=array();
	$pat=array();
	 
 
	$i=0;
	foreach($_POST['prollno'] as $no){
		$rno[$i]= $no;
		$i++;
		 
	}
	
	$k=0;
	foreach($_POST['patn'] as $no){
		$pat[$k]= $no;
		$k++;
		 
	} 
	 
	$count=0; 
	  
	for($m=1;$m<sizeof($prds);$m++)
	{
	 
	for($j=0;$j<$i;$j++)
	{
	for($l=0;$l<$k;$l++)
	{
	 
	$vsql = $conn->query("select * from tblattendancehrs where rollno='".$rno[$j]."' and  adate='".date($date)."' ");
	if($rno[$j]	== $pat[$l])
	{
		 
	if($vsql->num_rows<=0)
	{	
	  
	if($prds[$m]==1) 
	 $sql= "insert into tblattendancehrs(adate,rollno,h1,pc1) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==2) 
	$sql= "insert into tblattendancehrs(adate,rollno,h2,pc2) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==3) 
	$sql= "insert into tblattendancehrs(adate,rollno,h3,pc3) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==4) 
	$sql= "insert into tblattendancehrs(adate,rollno,h4,pc4) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==5) 
	$sql= "insert into tblattendancehrs(adate,rollno,h5,pc5) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==6) 
	$sql= "insert into tblattendancehrs(adate,rollno,h6,pc6) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==7) 
	$sql= "insert into tblattendancehrs(adate,rollno,h7,pc7) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($prds[$m]==8) 
	$sql= "insert into tblattendancehrs(adate,rollno,h8,pc8) values('".$date."','".$rno[$j]."','a','".$papercode."')";
	if($conn->query($sql)==false)
      echo $conn->error;
	}
	else
	{
	 
    if($prds[$m]==1) 
	$sql= "update tblattendancehrs set h1 ='a',pc1='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==2) 
	$sql= "update tblattendancehrs set h2 ='a',pc2='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==3) 
	$sql= "update tblattendancehrs set h3 ='a',pc3='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==4) 
	$sql= "update tblattendancehrs set h4 ='a',pc4='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==5) 
	$sql= "update tblattendancehrs set h5 ='a',pc5='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==6) 
	$sql= "update tblattendancehrs set h6 ='a',pc6='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==7) 
	$sql= "update tblattendancehrs set h7 ='a',pc7='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==8) 
	$sql= "update tblattendancehrs set h8 ='a',pc8='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	$conn->query($sql);
	}
	break;
	}
	else if($vsql->num_rows<=0)
	{
	if($prds[$m]==1) 
	$sql= "insert into tblattendancehrs(adate,rollno,h1,pc1) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==2) 
	$sql= "insert into tblattendancehrs(adate,rollno,h2,pc2) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==3) 
	$sql= "insert into tblattendancehrs(adate,rollno,h3,pc3) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==4) 
	$sql= "insert into tblattendancehrs(adate,rollno,h4,pc4) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==5) 
	$sql= "insert into tblattendancehrs(adate,rollno,h5,pc5) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==6) 
	$sql= "insert into tblattendancehrs(adate,rollno,h6,pc6) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==7) 
	$sql= "insert into tblattendancehrs(adate,rollno,h7,pc7) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	if($prds[$m]==8) 
	$sql= "insert into tblattendancehrs(adate,rollno,h8,pc8) values('".$date."','".$rno[$j]."','p','".$papercode."')";
	$conn->query($sql);

	}
	else
	{
	 
    if($prds[$m]==1) 
	$sql= "update tblattendancehrs set h1 ='p',pc1='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==2) 
	$sql= "update tblattendancehrs set h2 ='p',pc2='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==3) 
	$sql= "update tblattendancehrs set h3 ='p',pc3='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==4) 
	$sql= "update tblattendancehrs set h4 ='p',pc4='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==5) 
	$sql= "update tblattendancehrs set h5 ='p',pc5='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==6) 
	$sql= "update tblattendancehrs set h6 ='p',pc6='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==7) 
	$sql= "update tblattendancehrs set h7 ='p',pc7='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	if($prds[$m]==8) 
	$sql= "update tblattendancehrs set h8 ='p',pc8='".$papercode."' where adate='".$date."' and  rollno='".$rno[$j]."'";
	$conn->query($sql);
	}
	}
	
	}
	
	}
	echo "<script language='javascript' type='text/javascript'>";
        echo "alert('  Attendance is posted!');";
        echo "</script>";
}
?>
<?php if(isset($_POST['bulksearch']))
{

    $course=$_POST['coursecode'];
    $programcode= $_POST['programcode'];
    $fromdate=$_POST['fromdate'];
	$todate=$_POST['todate'];
    $acyear=$_POST['acyear'];
	$deptcode=$_POST['deptcode'];
	$section=$_POST['section'];
	$studyyear=$_POST['studyyear'];
	$semester=$_POST['semester'];
	$papercode=$_POST['papercode'];
	$batch=$_POST['batch'];
    $rollno="";
	$acount=0;
	$scount=0;
	
    $namequery = $conn->query("select * from students   where course='$course' and acyear='$acyear' and studyyear='$studyyear'   and semester='$semester'  ");
    $namecount = $namequery->num_rows;
    $sno=1;
     
	$psql = $conn->query("select papername from tblPapers where papercode='$papercode'");
	$prs1=$psql->fetch_assoc();
	 
		$vsql = $conn->query("select distinct(adate) as adate from tblattendancehrs where (pc1='".$papercode."' or pc2='".$papercode."' or pc3='".$papercode."' or pc4='".$papercode."' or pc5='".$papercode."' or pc6='".$papercode."' or pc7='".$papercode."' or pc8='".$papercode."') and  adate>='".date($fromdate)."' and  adate<='".date($todate)."'  ");
	 $dcnt=0;
	 while($row1 = $vsql->fetch_assoc())
	 {
		 
		  $dcnt++;
	 }
		
		 
	
	?>
      
    <form method="post" class="form-inline"  name="bulkpayform" action="atten_subject_hrs.php"  >
    <table  border="1">
        <tr>
            <td colspan=<?php echo $dcnt+5;?> STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo $course."<br>".$studyyear  ; ?> 
             <?php echo  $semester." Section: ".$section; ?>
	        <?php echo " From:" .date("d-m-Y", strtotime($fromdate)); ?>
		  <?php echo " To:". date("d-m-Y", strtotime($todate)); ?>
		  
		  </td>	 
          
		    
            <input type="hidden" id="batch" name="batch" value="<?php echo $batch; ?>">

        </tr>

    <tr>
        <td colspan=<?php echo $dcnt+5;?> STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo $papercode." ".$prs1['papername'];?></td>
    </tr>
        <tr STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #0EE;">
        <th>S.No</th>
        
        <th>RollNo</th>
        <th>Student Name</th>
         
		<?php 
		$vsql = $conn->query("select distinct(adate) as adate from tblattendancehrs where (pc1='".$papercode."' or pc2='".$papercode."' or pc3='".$papercode."' or pc4='".$papercode."' or pc5='".$papercode."' or pc6='".$papercode."' or pc7='".$papercode."' or pc8='".$papercode."') and  adate>='".date($fromdate)."' and  adate<='".date($todate)."'  ");
	 $dcnt=0;
	 while($row1 = $vsql->fetch_assoc())
	 {
		  echo "<th>". date("d-m", strtotime($row1['adate']))."</th>";
		  $dcnt++;
	 }
		
		 
	
	?></th>
	
        
        <th>No.of Periods</th>
        <th>Percent%</th>
        
        
        
    </tr>
	 
        <?php
	date_default_timezone_get('Asia/Kolkata');
	$d=date('Y-m-d-H:i:s');
     $d1=date('Y-m-d');
     $rcptdate = date("d-m-Y", strtotime($d));
	$psql = $conn->query("select papertype from tblPapers where papercode='$papercode'");
	$prs1=$psql->fetch_assoc();
	if($prs1['papertype']=="Practical" and $batch !="")
	{
	$psql = $conn->query("select * from tbllabsections where papercode='$papercode' and batch='$batch' ");
	$prs=$psql->fetch_assoc();
	$rolls= $prs['rollnos'];
	$rnos=explode(",",$rolls);
	
	for($i=0;$i<sizeof($rnos);$i++)
	{
			$pat="";
			$pat='pat'.$rnos[$i];
	$psqlname = $conn->query("select studentname from tblstudents where rollno='$rnos[$i]'  ");
	$prsname=$psqlname->fetch_assoc();		
			?>
		<tr>
		       	
                <td><?php echo $sno; $sno++; ?></td>   
                <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px;background-color: #EEE;" ><?php echo $rnos[$i]; ?> </td>
				 <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px;background-color: #EEE;" ><?php echo $prsname['studentname']; ?></td>
				<?php
				
	$vsql = $conn->query("select distinct(adate) as adate from tblattendancehrs where (pc1='".$papercode."' or pc2='".$papercode."' or pc3='".$papercode."' or pc4='".$papercode."' or pc5='".$papercode."' or pc6='".$papercode."' or pc7='".$papercode."' or pc8='".$papercode."') and  adate>='".date($fromdate)."' and  adate<='".date($todate)."'  ");
	 
	$preat=0;
	$at=0;
	$c1=0; $c2=0;$c3=0;$c4=0;$c5=0;$c6=0;$c7=0;$c8=0;
	$thcnt=0;  
	 while($row1 = $vsql->fetch_assoc())
	{
	$hcnt=0;
	$vsql2 = $conn->query("select h1 from tblattendancehrs where (pc1='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'   ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	 
	if($row2['h1']=="p")
	$c1=1 ;
	else
	$c1=0 ;	
	}
	$vsql2 = $conn->query("select h2 from tblattendancehrs where (pc2='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	 
	if($row2['h2']=="p")
	$c2=1 ;
	else
	$c2=0 ;	
	}
	$vsql2 = $conn->query("select h3 from tblattendancehrs where (pc3='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'     ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h3']=="p")
	$c3=1 ;
	else
	$c3=0 ;
	}
	$vsql2 = $conn->query("select h4 from tblattendancehrs where (pc4='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h4']=="p")
	$c4=1 ;
	else
	$c4=0 ;
	}
	$vsql2 = $conn->query("select h5 from tblattendancehrs where (pc5='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h5']=="p")
	$c5=1 ;
	else
	$c5=0 ;
	}
	
	$vsql2 = $conn->query("select h6 from tblattendancehrs where (pc6='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h6']=="p")
	$c6=1 ;
	else
	$c6=0 ;
	}
	$vsql2 = $conn->query("select h7 from tblattendancehrs where (pc7='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h7']=="p")
	$c7=1 ;
	else
	$c8=0 ;
	}
	$vsql2 = $conn->query("select h8 from tblattendancehrs where (pc8='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rnos[$i]."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h4']=="p")
	$c8=1 ;
	else
	$c8=0 ;
	}
	$at= $preat+$c1+$c2+$c3+$c4+$c5+ $c6+$c7+$c8;	
		 if($at !=0)
		 echo "<td>". $at."</td>";
		 else
		 echo "<td>". $preat."</td>";	 
	$preat=$at; 	
	$thcnt=$thcnt+$hcnt	;			
	} 
	$percent=round(($at*100)/($thcnt),2);
	echo "<td>". $at."</td>";
	echo "<td>". $percent."</td>";
	?>
		</tr>
	<?php
	}
	
	}
	else
	{
        while($feemaster = $namequery->fetch_assoc())
        {
            $rollno=$feemaster['student_id'];
           
			$pat="";
			$pat='pat'.$rollno ;
	$psqlname = $conn->query("select studentname from tblstudents where rollno='$rollno'  ");
	$prsname=$psqlname->fetch_assoc();		
			?>
		<tr>
		       	
                <td><?php echo $sno; $sno++; ?></td>   
                <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px;background-color: #EEE;" ><?php echo $rollno; ?> </td>
				 <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px;background-color: #EEE;" ><?php echo $prsname['studentname']; ?></td>
				<?php
				
	$vsql = $conn->query("select distinct(adate) as adate from tblattendancehrs where (pc1='".$papercode."' or pc2='".$papercode."' or pc3='".$papercode."' or pc4='".$papercode."' or pc5='".$papercode."' or pc6='".$papercode."' or pc7='".$papercode."' or pc8='".$papercode."') and  adate>='".date($fromdate)."' and  adate<='".date($todate)."'  ");
	 
	$preat=0;
	$at=0;
	
	$thcnt=0;  
	 while($row1 = $vsql->fetch_assoc())
	{
	$c1=0; $c2=0;$c3=0;$c4=0;$c5=0;$c6=0;$c7=0;$c8=0;
	$hcnt=0;
	$vsql2 = $conn->query("select h1 from tblattendancehrs where (pc1='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'   ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	 
	if($row2['h1']=="p")
	$c1=1 ;
	else
	$c1=0 ;	
	}
	$vsql2 = $conn->query("select h2 from tblattendancehrs where (pc2='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	 
	if($row2['h2']=="p")
	$c2=1 ;
	else
	$c2=0 ;	
	}
	$vsql2 = $conn->query("select h3 from tblattendancehrs where (pc3='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'     ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h3']=="p")
	$c3=1 ;
	else
	$c3=0 ;
	}
	$vsql2 = $conn->query("select h4 from tblattendancehrs where (pc4='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h4']=="p")
	$c4=1 ;
	else
	$c4=0 ;
	}
	$vsql2 = $conn->query("select h5 from tblattendancehrs where (pc5='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h5']=="p")
	$c5=1 ;
	else
	$c5=0 ;
	}
	
	$vsql2 = $conn->query("select h6 from tblattendancehrs where (pc6='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h6']=="p")
	$c6=1 ;
	else
	$c6=0 ;
	}
	$vsql2 = $conn->query("select h7 from tblattendancehrs where (pc7='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h7']=="p")
	$c7=1 ;
	else
	$c7=0 ;
	}
	$vsql2 = $conn->query("select h8 from tblattendancehrs where (pc8='".$papercode."' ) and  adate='".$row1['adate']."' and rollno='".$rollno."'    ");
	if($vsql2->num_rows>0)
	{
	$hcnt++;
	$row2 = $vsql2->fetch_assoc();
	if($row2['h8']=="p")
	$c8=1 ;
	else
	$c8=0 ;
	}
	 
	$at= $preat+$c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8;	
		 if($at !=0)
		 echo "<td>". $at."</td>";
		 else
		 echo "<td>". $preat."</td>";	 
	$preat=$at; 	
	$thcnt=$thcnt+$hcnt	;			
	} 
	$percent=round(($at*100)/($thcnt),2);
	echo "<td>". $at."</td>";
	echo "<td>". $percent."</td>";
	?>
		</tr>
	<?php
	}
	
		    
   }

	 

		    ?>
       
        <input type="hidden"  id="sno" name="sno" value="<?php echo $sno;?>" >
        <input type="hidden" id="pcourse" name="pcourse" value="<?php echo $course;?>" >
        <input type="hidden"  id="pbatch" name="pbatch" value="<?php echo $batch;?>" >
        <input type="hidden" id="pbranch" name="pbranch" value="<?php echo $branch;?>" >
        <input type="hidden"  id="pdate" name="pdate" value="<?php echo $date;?>" >
         <input type="hidden"  id="psection" name="psection" value="<?php echo $section;?>" >
        <input type="hidden"  id="pstudyyear" name="pstudyyear" value="<?php echo $studyyear;?>" >
		 <input type="hidden"  id="psemester" name="psemester" value="<?php echo $semester;?>" >
		 <input type="hidden"  id="pdeptcode" name="pdeptcode" value="<?php echo $deptcode;?>" >
		 <input type="hidden"  id="ppapercode" name="ppapercode" value="<?php echo $papercode;?>" >
		  <input type="hidden"  id="pprds" name="pprds" value="<?php echo $prds;?>" >
		  <input type="hidden"  id="pprds" name="pprds" value="<?php echo $prds;?>" >
        <tr>
		 <td colspan=<?php echo $dcnt+5;?> align="center" STYLE="color: blue; font-family: Verdana; font-weight: bold; font-size: 25px;background-color: #EEE;"> <?php echo "No.of Days: ". $dcnt; ?>
			  <?php echo "  No.of Periods: ".  $thcnt; ?></td></tr>
      <tr><td colspan=<?php echo $dcnt+5;?> align="center">
                    <input type="button" name="bulkpost"   class="btn btn-success " style="height:50px;font-size:20px;" value="Export CSV(Excel) File"  onclick="exportTableToCSV('Attendance.csv')" >
                </td>
	</tr> 
      </table>
    </form>

</fieldset>
<?php 
	 
	}
?>
    <!--paymentform-->
<?php
if(isset($_GET['pay']) ) {
    $rollno = $_GET['rollno'];
    //echo $rollno;
    echo $rollno;
}
    ?>

	<style>
	td{
	align:right;
	}
	.search
	{

		padding-bottom:20px;
		font-weight:bold;
	}
        .req
        {
            color:red;
            font-weight: bold;
            font-size: 17px;
        }
	
	
	</style>
	
	

		</form>
 

</div>
</div>



</div>
</div>




		

<style>
#doj .ui-datepicker-calendar
{
display:none;
}

</style>


    <div id="footer-sec">
       VSM | Developed By : <a href="#" target="_blank">VSM</a>
    </div>
   
  
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>

    
</body>
</html>
<?php //} ?>