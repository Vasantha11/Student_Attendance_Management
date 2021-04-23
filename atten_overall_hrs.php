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
                        <h1 class="page-head-line">Overall Attendance  
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
    <form action="atten_overall_hrs.php" method="post" id="signupForm1" class="form-horizontal">
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
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">From Date</label>
				<div class="col-sm-10">
				<input type="date" class="form-control" id="fromdate" name="fromdate" value="<?php echo date('Y-m-d'); ?>"  />
				</div>	</div>
				  <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">To Date</label>
				<div class="col-sm-10">
				<input type="date" class="form-control" id="todate" name="todate" value="<?php echo date('Y-m-d'); ?>"  />
				</div>	</div> 
				 <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">Days </label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="days" name="days"    />
				</div>	</div>
				  <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">Fine Amount</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="fine" name="fine"  />
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
	$days=$_POST['days'];
	$fine=$_POST['fine'];
    $rollno="";
	$acount=0;
	$scount=0;
	$dcnt=0;
    $namequery = $conn->query("select * from students   where course='$course' and acyear='$acyear' and studyyear='$studyyear'   and semester='$semester'  ");
    $namecount = $namequery->num_rows;
    $sno=1;
     $pquery = $conn->query("select distinct(papercode) as papercode from tblPapers   where papercode like '%".$course."%' and  studyyear='$studyyear'   and semester='$semester'  ");
	while($pars=$pquery->fetch_assoc()) 
	{
	$psql = $conn->query("select papername from tblPapers where papercode='".$pars['papercode']."'");
	$prs1=$psql->fetch_assoc();
	 $dcnt++;
	}
		
		 
	
	?>
  <link href="css/datatable/datatable.css" rel="stylesheet" />
	 
	
<div class="table-sorting table-responsive">   
   <table class="table table-striped table-bordered table-hover"   id="tSortable22" style="table-layout: fixed;  width: 100%;">
   <thead>
        <tr>
            <td colspan=<?php echo $dcnt+6;?> STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo $course."<br>".$studyyear  ; ?> 
             <?php echo  $semester." Section: ".$section; ?>
	        <?php echo " From:" .date("d-m-Y", strtotime($fromdate)); ?>
		  <?php echo " To:". date("d-m-Y", strtotime($todate)); ?>
		  
		  </td>	 
          
		    
            <input type="hidden" id="batch" name="batch" value="<?php echo $batch; ?>">

        </tr>

     
	 
	  
    
        <tr STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #0EE;">
        <th>S.No</th>
        
        <th>RollNo</th>
        <th>Student Name</th>
   <?php      
	 
	 
	 $pquery = $conn->query("select distinct(papercode) as papercode from tblPapers   where substring(papercode,1,9) like '%".$course."%' and  studyyear='$studyyear'   and semester='$semester' and section='A' order by papercode");
	while($pars=$pquery->fetch_assoc()) 
	{
	$psql = $conn->query("select distinct(papername) as papername from tblPapers where papercode='".$pars['papercode']."'");
	$prs1=$psql->fetch_assoc();
	 echo "<th style='word-wrap:break-word;'>". $prs1['papername']."</th>";
	  echo "<th style='word-wrap:break-word;'> %</th>";
	}
	 

	 
	?></th>
	
        
        <th style="word-wrap:break-word;">No.of Periods</th>
        <th>%</th>
        <th style="word-wrap:break-word;">Fine Amount</th>
        
        
    </tr>
	</thead>
	<tbody> 
    <?php
	date_default_timezone_get('Asia/Kolkata');
	$d=date('Y-m-d-H:i:s');
     $d1=date('Y-m-d');
     $rcptdate = date("d-m-Y", strtotime($d));
	 $scnt=0;$tfineamt=0;
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
                <td  style="word-wrap:break-word;" STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px;background-color: #EEE;" ><?php echo $rollno; ?> </td>
				 <td  style="word-wrap:break-word;" STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px;background-color: #EEE;" ><?php echo $prsname['studentname']; ?></td>
	<?php
	
	$pquery = $conn->query("select distinct(papercode) as papercode from tblPapers   where substring(papercode,1,9) like '%".$course."%' and  studyyear='$studyyear'   and semester='$semester' and section='A' order by papercode");
	while($pars=$pquery->fetch_assoc()) 
	{	
	$papercode= $pars['papercode'];
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
	$at= $preat+$c1+$c2+$c3+$c4+$c5+ $c6+$c7+$c8;	
		  	 
	$preat=$at; 	
	$thcnt=$thcnt+$hcnt	;			
	} 
	$finalat=$finalat+$at;
	$finalthcnt=$finalthcnt+$thcnt;
	if($at!=0)
	$percent=round(($at*100)/($thcnt),2);
	else
	$percent=0;
	echo "<td style='color:red;'><b>". $at."</b></td>";
	echo "<td style='color:blue;'><b>". $percent."%</b></td>";
	}
	if($finalat!=0)
	$percent=round(($finalat*100)/($finalthcnt),2);
	else
	$percent=0;
	echo "<td style='color:red;'><b>". $finalat."</b></td>";
	echo "<td style='color:blue;'><b>". $percent."%</b></td>";
	if($finalat-$days <0)
	{
	$fineamt= ($days-$finalat)*$fine;
	$tfineamt=$tfineamt+$fineamt;
	echo "<td style='color:blue;'><b>". $fineamt.".00</b></td>";
	$scnt++;
	}
	else
	echo "<td style='color:blue;'> </td>";	
	$finalat=0;
	 $finalthcnt=0;
	?>
		</tr>
	<?php
	
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
		 <td colspan=<?php echo $dcnt+6;?> align="center" STYLE="color: blue; font-family: Verdana; font-weight: bold; font-size: 25px;background-color: #EEE;"> <?php echo "No.of Students Fine to be Paid ". $scnt; ?>
			  <?php echo "Total Fine Amount: ".  $tfineamt; ?></td></tr>
      <tr><td colspan=<?php echo $dcnt+6;?> align="center">
                    <input type="button" name="bulkpost"   class="btn btn-success " style="height:50px;font-size:20px;" value="Export CSV(Excel) File"  onclick="exportTableToCSV('OverallAttendanceWithFine.csv')" >
                </td>
	</tr> 
	</tbody>
      </table>
	  </div>
 

</fieldset>
<script src="js/dataTable/jquery.dataTables.min.js"></script>
     <script>
         $(document).ready(function () {
             $('#tSortable22').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bInfo": true,
    "bAutoWidth": true });
	
         });
		 
	
    </script>
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