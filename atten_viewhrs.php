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
$msg="";
$errormsg= '';
$programcode="";
$course="";
$coursecode="";
$studyyear="";
$semester="";
$section="";
$deptcode="";
$acyear="";
$cc="";
$i=0;
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
        for(var i=1; i<=8;i++)
					{
				var x="p"+i;		    
			  document.getElementById(x).disabled = false;
			  document.getElementById(x).checked = false;
					}
        if(semester){
            $.ajax({
                type:'POST',
                url:'ajaxDept.php',
                data:{facultycode:facultycode,studyyear:studyyear,semester:semester,section:section,coursecode:coursecode},
                success:function(html){
                    
                    $('#papercode').html(html);
                }
            }); 
			$.ajax({
                type:'POST',
                url:'ajaxperiods.php',
                data:{studyyear:studyyear,semester:semester,section:section,coursecode:coursecode,adate:adate,acyear:acyear},
                success:function(html){
					  
                    var a = html.split(",");
                    for(var i=0; i<a.length;i++)
					{
					if(parseInt(a[i])==1)
					{
						 document.getElementById("p1").disabled = true;
						  document.getElementById("p1").checked = true;
					}
					 if(parseInt(a[i])==2)
					 {
						 document.getElementById("p2").disabled = true;
						  document.getElementById("p2").checked = true;
					 }
					 if(parseInt(a[i])==3)
					 {
						 document.getElementById("p3").disabled = true;
						  document.getElementById("p3").checked = true;
					 }
					 if(parseInt(a[i])==4)
						{
						 document.getElementById("p4").disabled = true;
						  document.getElementById("p4").checked = true;
					 }
					 if(parseInt(a[i])==5)
						{
						 document.getElementById("p5").disabled = true;
						  document.getElementById("p5").checked = true;
					 }
					 if(parseInt(a[i])==6)
						 {
						 document.getElementById("p6").disabled = true;
						  document.getElementById("p6").checked = true;
					 }
					 if(parseInt(a[i])==7)
						 {
						 document.getElementById("p7").disabled = true;
						  document.getElementById("p7").checked = true;
					 }
					 if(parseInt(a[i])==8)
						 {
						 document.getElementById("p8").disabled = true;
						  document.getElementById("p8").checked = true;
					 }
					 
					}
					
				
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
                        <h1 class="page-head-line">View Day-wise Attendance  
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
<?php if(  !isset($_POST['bulksearch']))
{
 ?>
    <form action="atten_viewhrs.php" method="post" id="signupForm1" class="form-horizontal">
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
				<label class="col-sm-4 control-label" style="text-align: left" for="deptcode">DepartmentName</label>
                         	   
			 <?php
					$sql = "select * from tblDept where programcode= '$programcode' "; 
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
				<label class="col-sm-4 control-label" style="text-align: left" for="adate">Date</label>
				<div class="col-sm-10">
				<input type="date" class="form-control" id="adate" name="adate" value="<?php echo date('Y-m-d'); ?>"  />
				</div>	</div>
				<!-- <div class="form-group">
				<label class="col-sm-4 control-label" style="text-align: left" for="acyear">Periods</label>
				<div class="col-sm-10">
				1: <input type="checkbox" name="p[]" id="p1" value="1" style="width:20px;height:20px;"  /> &nbsp;&nbsp;

				2: <input type="checkbox" name="p[]" id="p2" value="2" style="width:20px;height:20px;" /> &nbsp;&nbsp; 

				3: <input type="checkbox" name="p[]" id="p3" value="3" style="width:20px;height:20px;" />  &nbsp;&nbsp;

				4: <input type="checkbox" name="p[]" id="p4" value="4" style="width:20px;height:20px;" /><br>
				
				5: <input type="checkbox" name="p[]" id="p5" value="5" style="width:20px;height:20px;" /> &nbsp;&nbsp;

				6: <input type="checkbox" name="p[]" id="p6" value="6" style="width:20px;height:20px;" /> &nbsp;&nbsp;

				7: <input type="checkbox" name="p[]" id="p7" value="7" style="width:20px;height:20px;" /> &nbsp;&nbsp;

				8: <input type="checkbox" name="p[]" id="p8" value="8" style="width:20px;height:20px;" />
				</div>	</div>  -->
				
		 
		 <input type="hidden" name="no" id="no" value=<?php echo $i;?> > <br>	
		 
					<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="id" value="<?php echo $deptcode;?>">
								<input type="hidden" name="action" value="<?php echo $action;?>">
								
									<button type="submit" name="bulksearch" class="btn btn-primary">View Attendance </button>
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
	$course=$_POST['pcoursecode'];
    $programcode= $_POST['programcode'];
    $date=$_POST['pdate'];
    $acyear=$_POST['pacyear'];
	$deptcode=$_POST['pdeptcode'];
	$section=$_POST['psection'];
	$studyyear=$_POST['pstudyyear'];
	$semester=$_POST['psemester'];
	$papercode=$_POST['ppapercode'];
	$deptcode=$_POST['pdeptcode'];
    $rollno="";
	$acount=0;
	$scount=0;
	
    $namequery = $conn->query("select * from students where course='$course' and acyear='$acyear' and studyyear='$studyyear'   and semester='$semester'");
    $namecount = $namequery->num_rows;
    $sno=1;
	
     
}
?>
<?php if(isset($_POST['bulksearch']))
{
	date_default_timezone_get('Asia/Kolkata');
    $d=date('Y-m-d-H:i:s');
    $d1=date('Y-m-d');
    $rcptdate = date("d-m-Y", strtotime($d));
    $course=$_POST['coursecode'];
    $programcode= $_POST['programcode'];
    $date=$_POST['adate'];
    $acyear=$_POST['acyear'];
	$deptcode=$_POST['deptcode'];
	$section=$_POST['section'];
	$studyyear=$_POST['studyyear'];
	$semester=$_POST['semester'];
	$papercode=$_POST['papercode'];
    $rollno="";
	$acount=0;
	$scount=0;
	
    $namequery = $conn->query("select * from students where course='$course' and acyear='$acyear' and studyyear='$studyyear'   and semester='$semester'");
    $namecount = $namequery->num_rows;
    $sno=1;
     while($feemaster = $namequery->fetch_assoc())
        {
            $rollno=$feemaster['student_id'];
            $pat="";
			$pat='pat'.$rollno;
	     
	     $vsql = $conn->query("select * from tblattendancehrs  where rollno='".$rollno."' and  adate='".date($date)."' ");
		 $rsrow=$vsql->fetch_assoc();
            
         $vsql0 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc1']."' ");
		 $rsrows0=$vsql0->fetch_assoc();
		 $vsql1 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc2']."' ");
		 $rsrows1=$vsql1->fetch_assoc();
		 $vsql2 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc3']."' ");
		 $rsrows2=$vsql2->fetch_assoc();
		 $vsql3 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc4']."' ");
		 $rsrows3=$vsql3->fetch_assoc();
		 $vsql4 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc5']."' ");
		 $rsrows4=$vsql4->fetch_assoc();
		 $vsql5 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc6']."' ");
		 $rsrows5=$vsql5->fetch_assoc();
		 $vsql6 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc7']."' ");
		 $rsrows6=$vsql6->fetch_assoc();
		 $vsql7 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc8']."' ");
		 $rsrows7=$vsql7->fetch_assoc();
		 
		$namequery1 = $conn->query("select * from tblextstudents where studentno='".$rollno."'");
        $rs1= $namequery1->fetch_assoc();
		$namequery2 = $conn->query("select * from tblstudents where rollno='".$rollno."'");
        $rs= $namequery2->fetch_assoc();
		 
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="a") and ($rsrow['h5']=="a")and ($rsrow['h6']=="a") and  ($rsrow['h7']=="a") and  (($rsrow['h8']=="a") or ($rsrow['h8'] == NULL)  ))and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్,వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="a") and ($rsrow['h5']=="a")and ($rsrow['h6']=="a") and  ($rsrow['h7']=="p") and  (($rsrow['h8']=="p")    ))and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం మరియు మధ్యాహ్నం మొదటి రెండు పిరియడ్స్ కళాశాలకు హాజరు కాలేదు  --ప్రిన్సిపాల్,వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="a") and ($rsrow['h5']=="a")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p"))  and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం మరియు మధ్యాహ్నం మొదటి పిరియడ్ కళాశాలకు హాజరు కాలేదు  --ప్రిన్సిపాల్,వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="a") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p"))  and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్,వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}	
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="p") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p"))  and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం మొదటి మూడు పిరియడ్స్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్,వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="a")and ($rsrow['h3']=="p") and  ($rsrow['h4']=="p") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p")) and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం మొదటి రెండు పిరియడ్స్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్, వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="a") and ($rsrow['h2']=="p")and ($rsrow['h3']=="p") and  ($rsrow['h4']=="p") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p"))  and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం మొదటి  పిరియడ్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్, వియస్ఎం కళాశాల,రామచంద్రాపురం";
		} 
        else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="p") and ($rsrow['h2']=="a")and ($rsrow['h3']=="p") and  ($rsrow['h4']=="p") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p"))  and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం రెండవ  పిరియడ్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్, వియస్ఎం కళాశాల,రామచంద్రాపురం";
		}  
		else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="p") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="p") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p") ) and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం రెండు,మూడు  పిరియడ్స్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్, వియస్ఎం కళాశాల,రామచంద్రాపురం";
		} 
		else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="p") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="a") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p"))  and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం రెండు,మూడు మరియు నాలుగు పిరియడ్స్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్, వియస్ఎం కళాశాల,రామచంద్రాపురం";
		} 
		else
        if(((substr($rs['gender'],0,1)=="M") or (substr($rs['gender'],0,1)=="m")) and (($rsrow['h1']=="p") and ($rsrow['h2']=="a")and ($rsrow['h3']=="a") and  ($rsrow['h4']=="a") and ($rsrow['h5']=="p")and ($rsrow['h6']=="p") and  ($rsrow['h7']=="p")     )and (strlen($rs1['fphno'])==10))
        {
			 
			$msg="మీ అబ్బాయి ఈ రోజు ఉదయం రెండు,మూడు మరియు నాలుగు పిరియడ్స్ కళాశాలకు హాజరు కాలేదు --ప్రిన్సిపాల్, వియస్ఎం కళాశాల,రామచంద్రాపురం";
		} 		
	//$apiKey = urlencode('aquxVzinILo-rwUJeSTcH0fj00miPqX76r13gVXoJq');
	//$apiKey = urlencode('zpzBaW2HRB0-kbabjWktClpWpULaTMF2Evl4ZCQWFy');
	// Message details
	if($msg!="")
	{
		
	$username = "mkolla@gmail.com";
   	$hash = "c801ff577cbe7d1f98f4fc9e3a1cfd0f3fbe514ec6a011a9bd2353ce9172ab48";
	$numbers = array($rs1['fphno']);
	$sender = urlencode('VSMCOL');
	$message = rawurlencode(unicodeMessageDecode("మీ ".$gender."ఈ రోజు ".$fnan."కళాశాలకు హాజరు కాలేదు-VSM,Ph:7729972282"));
    echo "మీ ".$gender."ఈ రోజు ".$fnan."కళాశాలకు హాజరు కాలేదు.-VSM,Ph:7729972282";     
	$numbers = implode(',', $numbers);
         
	// Prepare data for POST request
	//$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message,"unicode" =>true, "test" => '1');
     
    if(isset($_POST['confirm'])) 
	 $data = array('username' => $username,'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message,"unicode" =>true     );
    else
	 $data = array('username' => $username,'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message,"unicode" =>true , "test" => '1'    );	
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	//echo $response;
	$responseArray = json_decode($response, true);
	if(isset($_POST['confirm']))     
	$cost = $responseArray['cost'];
	else 
	$cost=0;
	$responseArray = $responseArray['messages'];
 
	echo "Student No:".$rno[$j]. " PhoneNo: " ;
	foreach($responseArray as $key => $value)
	{
      echo $value['recipient'] . '<br>';
    }
	
	$namequery11 = $conn->query("select * from tblsmscredits where  adate='".date($date)."' and program='".$_SESSION['programcode']."'  ");
	if($namequery11->num_rows>0)
	{
	 $sql= "update tblsmscredits set debits= debits+ ".$cost." where adate='".date($date)."' and program='".$_SESSION['programcode']."'";
	  $conn->query($sql);
	}
	else
	{
	$sql= "insert into tblsmscredits(program,adate,debits ) values('".$_SESSION['programcode']."','".$date."','".$cost."')";
	$conn->query($sql);
	}
	$count++;
	$msg="";
	$numbers="";
    } 
		 
             
 			
		}
	

       ?>
    <form method="post" class="form-inline"  name="bulkpayform" action="atten_viewhrs.php"  >
    <table  border="1">
        <tr>
            <td colspan=2 STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo $course ; ?></td>
			<td colspan=1 STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo  $studyyear  ; ?></td>
            <td colspan=1 STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo  $semester ; ?></td>
			<td colspan=1 STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo $section  ; ?></td>
	    
	 <td colspan=5 STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 17px; background-color: #EEE;"><?php echo date("d-m-Y", strtotime($date));; ?></td>
			 
          
		    
            <input type="hidden" id="batch" name="batch" value="<?php echo $batch; ?>">

        </tr>

    <tr>
        <td colspan="3">List of Students & Attendance</td>
    </tr>
        <tr STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #0EE;">
        <th>S.No</th>
        
        <th>RollNo</th>
       
          <?php  
			 
    for ($i=1;$i<=8;$i++) {
		    
            echo "<th>Period ". $i."</th>";
	}
	 
	?> 
        
        
        
    </tr>
	 
        <?php
		$namequery = $conn->query("select * from students where course='$course' and acyear='$acyear' and studyyear='$studyyear'   and semester='$semester'");
        while($feemaster = $namequery->fetch_assoc())
        {
            $rollno=$feemaster['student_id'];
             
            $pat="";
			 
            date_default_timezone_get('Asia/Kolkata');
            $d=date('Y-m-d-H:i:s');
            $d1=date('Y-m-d');
            $rcptdate = date("d-m-Y", strtotime($d));
            
			$pat='pat'.$rollno;
	     
	     $vsql = $conn->query("select * from tblattendancehrs  where rollno='".$rollno."' and  adate='".date($date)."' ");
		 $rsrow=$vsql->fetch_assoc();
            ?>
	<tr>
		       	
                <td><?php echo $sno; $sno++; ?></td>   
               <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > <?php echo $rollno; ?>    </td>
<?php
         $vsql0 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc1']."' ");
		 $rsrows0=$vsql0->fetch_assoc();
		 $vsql1 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc2']."' ");
		 $rsrows1=$vsql1->fetch_assoc();
		 $vsql2 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc3']."' ");
		 $rsrows2=$vsql2->fetch_assoc();
		 $vsql3 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc4']."' ");
		 $rsrows3=$vsql3->fetch_assoc();
		 $vsql4 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc5']."' ");
		 $rsrows4=$vsql4->fetch_assoc();
		 $vsql5 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc6']."' ");
		 $rsrows5=$vsql5->fetch_assoc();
		 $vsql6 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc7']."' ");
		 $rsrows6=$vsql6->fetch_assoc();
		 $vsql7 = $conn->query("select * from  tblPapers where papercode='".$rsrow['pc8']."' ");
		 $rsrows7=$vsql7->fetch_assoc();
		 
		 
             
 			 if($rsrow['h1']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h1'].' '. $rsrows0['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h1']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h1'].' '  .'  </td> '; 
				 
			    }
			 if($rsrow['h2']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h2'].' '. $rsrows1['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h2']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h2'].' '. '  </td> '; 
				 
			    }
				
			 if($rsrow['h3']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h3'].' '. $rsrows2['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h3']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h3'].' '.  '  </td> '; 
				 
			    }
				 if($rsrow['h4']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h4'].' '. $rsrows3['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h4']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h4'].' '.  '  </td> '; 
				 
			    }
				 if($rsrow['h5']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h5'].' '. $rsrows4['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h5']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h5'].' '.  '  </td> '; 
				 
			    }
				 if($rsrow['h6']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h6'].' '. $rsrows5['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h6']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h6'].' '. '  </td> '; 
				 
			    }
				 if($rsrow['h7']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h7'].' '. $rsrows6['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h7']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h7'].' '.  '  </td> '; 
				 
			    }
				 if($rsrow['h8']=="p")
			   {
			 
				echo' <td  STYLE="color: green; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" > '. $rsrow['h8'].' '. $rsrows7['papername'] .'   </td>  ';
			   
			   } 
			   else if($rsrow['h8']=="a") 
				{
				 
			   echo ' <td  STYLE="color: red; font-family: Verdana; font-weight: bold; font-size: 15px; background-color: #EEE;" >'. $rsrow['h8'].' '.  '  </td> '; 
				 
			    }
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
		  <input type="hidden"  id="pacyear" name="pacyear" value="<?php echo $acyear;?>" >
        <tr>
      <td colspan=10 align="center">
                   <input type="button" name="bulkpost"   class="btn btn-success" style="height:50px;font-size:20px;" value="Export CSV(Excel) File"  onclick="exportTableToCSV('DayAttendance.csv')" >
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