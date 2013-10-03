<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AP_MALLRAT_MALL_ACCOUNT_VIEW</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!-- dialog box css start -->
<link type='text/css' href='css/demo.css' rel='stylesheet' media='screen' />
<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.17.custom.css" rel="stylesheet" />	

<link href="css/watermarkify.css" rel="stylesheet" type="text/css" />
<link href="css/uniform.default.css" rel="stylesheet" type="text/css" />
<!-- dialog box css end -->
</head>
<?php
include('config.php');
?>
<!-- dialog box js start -->
<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='js/basic.js'></script>
<!-- JQUERY DATEPACKER JQUERY FILES START -->
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="js/watermarkify.0.6.js"></script>
<!-- JQUERY DATEPICKER JQUERY END -->
<!-- dialog box js end -->
<script language="javascript" src="functions/function.js"></script>
<script language="javascript" src="js/jobs.js"></script>
<script src="js/jquery.uniform.js" type="text/javascript" charset="utf-8"></script> 
<script src="static/scripts/base.js"></script>
<script src="static/scripts/chart.js"></script>
<script src="static/scripts/initialize.js"></script>
<script>
		$(document).ready(function() {
			if ($.browser.msie  && parseInt($.browser.version, 10) === 8) {
				// IE8 doesn't like Canvas.
			} else {
			
				var d1 = [];
			    for (var i = 0; i <= 10; i += 1)
			        d1.push([i, parseInt(Math.random() * 250)]);

			    var d3 = [];
			    for (var i = 0; i <= 10; i += 0.4)
			        d3.push([i, parseInt(Math.random() * 140)]);
			        
				var d4 = [];
			    for (var i = 0; i <= 10; i += 0.6)
			        d4.push([i, Math.sqrt(i * 10)]);
			    
			    var d5 = [];
			    d5 = [ [0, 42], [1, 50], [2, 65], [3, 76], [4, 77], [5, 180], [6, 199], [7, 220], [8, 240], [9, 340], [10, 398] ];
			    
				$.plot($("#chart-demo"), 
					[
						{
							label: "DR NU",
							data: d5,
							lines: { show: true, fill: 0.4 },
							color: "#8AB4B5",
							hoverable: true
						},
						{
							label: "Pattern.dk",
							data: d1,
							lines: { show: true, lineWidth: 4 },
							color: "#FC354C"
						},
						{
							label: "Pouteria",
							data: d3,
							lines: { show: true, lineWidth: 2 },
							color: "#1E2528"
						},
						{
							label: "Halifaxed.com",
							data: d4,
							lines: { show: true, lineWidth: 2 },
							color: "#008C83"
						}
					], 
						
						{
							series	:	{ lines: { show: true }, points: { show: true }, curvedLines: { active: true } },
							grid	:	{ hoverable: true, clickable: true },
							legend	:	{ show: false },
							yaxis	:	{ position: "right" }
						}
				);
				
				$("#chart-demo").tooltipColor();
			
			}
			
		});
	</script>
<script type="text/javascript" charset="utf-8">
  $(function(){
	$("input#mallhours, input#closed").uniform(); 
  });
</script>

<script type="text/javascript">

  $(document).ready(function() {
    $("#content").tabs();
	$(".fields").watermarkify();
  });


$(function(){
$("#search_box_job").hide();
$("#event12").click(function(){
$("#add").hide();
$("#res").show();
$("#search_box_job").hide();
$("#search_box_event").show();

/*$("#content").find(".left_nav").removeClass("left_nav").addClass("left_nav_active1");
$("#content").find(".left_nav_active1").removeClass("left_nav_active1").addClass("left_nav");*/
});

/*$("#left_nav_active").mouseover(function(){
$("#content").find(".left_nav_active").removeClass("left_nav_active").addClass("remove_color");
})
$("#left_nav_active").mouseout(function(){
$("#content").find(".remove_color").removeClass("remove_color").addClass("left_nav_active");
})

$("#left_nav").mouseover(function(){
$("#content").find(".left_nav").removeClass("left_nav").addClass("remove_color1");
})

$("#left_nav").mouseout(function(){
$("#content").find(".remove_color1").removeClass("remove_color1").addClass("left_nav");
})*/


$("#job12").click(function(){
$("#res").hide();
$("#add").show();
$("#search_box_job").show();
$("#search_box_event").hide();

/*$("#content").find(".left_nav").removeClass("left_nav").addClass("left_nav_active1");
$("#content").find(".left_nav_active").removeClass("left_nav_active").addClass("left_nav");*/

$("#paging_event").hide();
});
});



function activeImage(id)
{
	document.getElementById(id).style.backgroundImage = "url(images/add_content_cal.png)";
	document.getElementById('add_button_active').style.backgroundImage ="url(images/add_content_buttton.png)";
}
function activeImage_help(id)
{
	document.getElementById(id).style.backgroundImage = "url(images/rollover03.png)";
	document.getElementById('add_button_active').style.backgroundImage ="url(images/add_content_buttton.png)";
}
</script>
<style type="text/css">
#fl {	
	background:url(images/add_content_cal_active.png);
	width:114px;
	height:127px;
	cursor:pointer;
}
#fl:hover {	
	background:url(images/rollover01.png);
	width:114px;
	height:127px;
	cursor:pointer;
}
#fr {
	background:url(images/help_wanted.png);
	width:167px;
	height:138px;
	cursor:pointer;
}
#fr:hover {
	background:url(images/rollover02.png);
	width:167px;
	height:138px;
	cursor:pointer;
}
</style>
<body>
<!-- popups start here -->
<div class="faded_bg" id="add_new_job_event_popup" style="display:none;">
	<div class="popups_edit1">
    	<div class="popup_top"></div>
        <div class="popup_bottom">
            <div class="popup_mid">
            	<div class="popup_baord_strip">
                	<div class="popup_baord_left"></div>
                    <div class="popup_baord_mid"></div>
                    <div class="popup_baord_right" onclick="div_sataus('add_new_job_event_popup')">
						<a href="#"><img src="images/close_popup.png" alt="" /></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="popup_box_patttern">
	           	    <div class="popup_paper_strip">
                    	<div class="add_content_inner">
                    		<div class="fl" id="fl" onclick="activeImage('fl')">&nbsp;</div>
                            <div class="fr" id="fr" onclick="activeImage_help('fr')">&nbsp;</div>
                            <div class="clear"></div>
                            <div class="lets_add_heading">Lets add some new content!</div>
                            <div class="add_button_active" id="add_button_active" onclick="div_sataus('add_new_job_event_popup')"><a href="#">add</a></div>
                        </div>
                  </div>
                </div>
			</div>
		</div>
    </div>
</div>	
<!-- popups end here -->
<!-- EDIT EVENT POPUP FOR ADD NEW EVENT -->
<div id="edit_event_modal_admin_popup" class="popups">
</div>
<!-- EDIT EVENT POPUP END --> 

<!-- EDIT JOB FOR EDIT EVENT -->
<div id="edit_job_admin_modal_popup" class="popups"></div>
<!-- EDIT JOB FOR EDIT EVENT  END-->  

<!-- CONFIRM DELETE POPUP -->
<div id="content_delete_popup" class="popups" style="display:none"></div>
<!-- CONFIRM DELETE POPUP -->
<!-- DELETE SUCCESSFULL POPUP -->
<div class="faded_bg" id="content_delete_successfull_popup" style="display:none;">
<div class="popups_edit1">
    	<div class="popup_top"></div>
        <div class="popup_bottom">
            <div class="popup_mid">
            	<div class="popup_baord_strip">
                	<div class="popup_baord_left"></div>
                    <div class="popup_baord_mid"></div>
                    <div class="popup_baord_right">
<a href="#" onclick="div_sataus('content_delete_successfull_popup')"><img src="images/close_popup.png" alt="" /></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="popup_box_patttern">
	           	    <div class="popup_paper_strip">
                    	<div class="add_content_inner">
                            <div class="lets_add_heading">Delete successful!</div>
          <div class="add_button"><a href="#" onclick="div_sataus('content_delete_successfull_popup')">close</a></div>
                        </div>
                  </div>
                </div>
			</div>
		</div>
    </div>
</div><!--faded_bg ends-->


<!-- DELETE SUCCESS FULLPOPUP -->

<!--SAVE FORM SUCCESAS START-->
<div class="faded_bg" id="save-form-content" style="display:none;">
<div class="popups_edit1">
  <div id="saved_successfully_popup" class="popups">
    <div class="popup_top"></div>
    <div class="popup_bottom">
      <div class="popup_mid">
        <div class="popup_baord_strip">
          <div class="popup_baord_left"></div>
          <div class="popup_baord_mid"></div>
          <div class="popup_baord_right" onclick="div_sataus('save-form-content')"> <a href="#"><img src="images/close_popup.png" alt="" /></a> </div>
          <div class="clear"></div>
        </div>
        <div class="popup_box_patttern">
          <div class="popup_paper_strip">
            <div class="add_content_inner">
              <div class="lets_add_heading">Form saved successfully!</div>
              <div class="add_button" onclick="div_sataus('save-form-content')"><a href="#" onclick="countRecords();">close</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div><!--faded_bg ends-->
<!-- SAVE FORM SUCCESS END -->

<!-- ADD NEW EVENT POPUP -->

<script type="text/javascript">
$(function() {
		$('#txtcal').datepicker({
    onSelect: function(dateText, inst) {
        var pieces = dateText.split('/');
        $('#start_mm').val(pieces[0]);
        $('#start_dd').val(pieces[1]);
        $('#start_yy').val(pieces[2]);
    }
})
});
$(function() {
		$('#txtcal2').datepicker({
    onSelect: function(dateText, inst) {
        var pieces = dateText.split('/');
        $('#end_mm').val(pieces[0]);
        $('#end_dd').val(pieces[1]);
        $('#end_yy').val(pieces[2]);
    }
})
$("#searchValue").keypress(function(e){
 if(e.which == 13)
 $("#search_img").click();
});
});

$(function() {
	$( "#edit_jobimg" ).datepicker({
	 onSelect: function(dateText, inst) {
     var pieces = dateText.split('/');
       $('#mm').val(pieces[0]);
        $('#dd').val(pieces[1]);
        $('#yyyy').val(pieces[2]);
		}
})
});

</script>

<!-- ======================================== ADD NEW EVENT START ======================================================== -->
<div id="add_new_event_modal_admin_popup" class="faded_bg" style="display:none;">
<div class="popups_edit">
    <div class="popup_top"></div>
    <div class="popup_bottom">
      <div class="popup_mid">
        
        <div class="popup_box_patttern">
          <div class="popup_paper_strip">
              <div class="event_popup_inner">
              <div class="popup_baord_strip" style="height:21px;">
          <div class="popup_baord_left" style="height:21px;"><h1>Request <strong>Mall Transfer</strong></h1></div>
          <div class="popup_baord_right" style="height:21px;"> <a href="#" onclick="div_sataus('add_new_event_modal_admin_popup')"><img src="images/close_popup.png" alt="" /></a></div>
          <div class="clear"></div>
        </div>
            
                 <div class="lets_add_heading">&nbsp;</div>
               
                <div class="event_con">
                    
                 	
                    <div class="text_area">
                    
                     <textarea onclick="removeError('des_error')" cols="0" id="event_desc" name="event_desc " class="description_input fields" title="
Experience" rows="0"></textarea>
                    
                    
                    
                    </div>
                    
                    
                    <div class="datearea">
                    
                	   <div style="margin:5px 0;" class="left_side_mall">
                       <table cellspacing="0" cellpadding="0" border="0" class="datetable" style="margin:20px 0 0 0;">
                              <tbody><tr>
                                <td colspan="3"><div style=" width:100%; margin:5px 0 0 0;" class="lets_add_heading">House of Operation</div></td>
                               
                              </tr>
                              <tr>
                                <td>Monday</td>
                                <td>
                                <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <td>Tuesday</td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                               <tr>
                                <td>Wednesday</td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                              
                              <tr>
                                <td>Thursday</td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                               
                              
                            </tbody></table>
                       <table cellspacing="0" cellpadding="0" border="0" class="datetable" style="margin:20px 0 0 0;">
                              <tbody>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                             <tr>
                                <td>Friday</td>
                               <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                               <tr>
                                <td>Saturday</td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                               <tr>
                                <td>Sunday</td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                                <td>
                                 <select name="">
                                    <option>Open Time</option>
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="3">Same as Mall Hours <input name="" type="checkbox" value="" id="mallhours" /></td>
                              </tr>
                            </tbody></table>
						<div class="clear"></div>
                        
                        <div class="telephoneNumver_area">
                        
                        	<input type="text" value="" class="telephone fields" title="Customer Service" name="">
                            <input type="text" value="" class="telephone fields"  title="Customer Service" name="">
                            <select name="" accesskey="cat_1" style="width:238px; height:31px; border: 1px solid #DDDDDD; color: #D0CFCF;">
                    	        <option>Category*</option>
                            </select>
                        </div>
                     </div>
                
                      
                
                    </div>
                    
                    
                    
                    <div class="clear"></div>
                    <div onclick="div_sataus('add_new_event_modal_admin_popup')" class="cancel_btn fl"><a href="#">cancel</a></div>
							
                <div onclick="return addRecord()" class="save_btn fr"><!--  <input name="save" class="simplemodal-close"  type="button" id="save" value="save" onclick="addRecord();" />-->         <a class="savef" href="#">save</a> </div>
                    
                 </div>
             
                    <div class="clear"></div>
               
                 </div>
                 
              
          	</div>
          
          </div>
        </div>
      </div>
    </div>
</div>	

<!-- ======================================== ADD NEW EVENT START END ======================================================== --> 


 <!-- ========================================ADD NEW JOB START ========================================================= -->
<div id="add_new_job_admin_modal_popup" class="faded_bg" style="display:none;">
<div class="popups_edit">
    	<div class="popup_top"></div>
        <div class="popup_bottom">
            <div class="popup_mid">
            	<div class="popup_baord_strip">
                	<div class="popup_baord_left"></div>
                    <div class="popup_baord_mid"></div>
                    <div class="popup_baord_right" >
						<a href="#"  onclick="div_sataus('add_new_job_admin_modal_popup')"><img src="images/close_popup.png" alt="" /></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="popup_box_patttern">
	           	    <div class="popup_paper_strip">
                    	<div class="event_popup_inner">
                            <div class="add_event_heading">Add New Job</div>
							<div class="select_box_outer fl">
								<div class="padding01">Select Shopping Mall</div>
								<div>
									<select id="sel_shopmall" name="sel_shopmall">
										<option>-please select-</option>
                                        <?php
										$sql="Select shop_name,id from add_new_job_admin_modal";
										$res=mysql_query($sql);
										while($result=mysql_fetch_array($res))
										{										
										?>
										<option value="<?php echo $result['id'];?>"><?php echo $result['shop_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="select_box_outer fr">
								<div class="padding01">Select Store</div>
								<div>
									<select id="sel_store" name="sel_store">
										<option>-please select-</option>
                                        <?php
										$sql="Select store_name,id from add_new_job_admin_modal";
										$res=mysql_query($sql);
										while($result=mysql_fetch_array($res))
										{										
										?>
										<option value="<?php echo $result['id'];?>"><?php echo $result['store_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="clear"></div>
							<div class="padding01">Job Title <span id="job_error" style="color:#FF0000;"></span></div>
							<div><input type="text" class="event_input" id="txt_title" name="txt_title" onclick="removeError('job_error')"/></div>
							<div class="padding01">Job Reference Number (if applicable) <span id="ref_error" style="color:#FF0000;"></span></div>
							<div><input type="text" class="event_input" id="txt_jobRef" name="txt_jobRef" onclick="removeError('ref_error')"/></div>
							<div class="padding01">Description <span id="des_error_job" style="color:#FF0000;"></span></div>
							<div><textarea rows="0" class="description_input" cols="0" id="txtArDesc" name="txtArDesc" onclick="removeError('des_error_job')"></textarea></div>
							<div class="padding01">Experience <span id="exp_error" style="color:#FF0000;"></span></div>
							<div><textarea rows="0" class="description_input" cols="0" id="txtArExp" name="txtArExp" onclick="removeError('exp_error')"></textarea></div>
							<div class="padding01">Closing Date (if applicable, otherwise your post will be up for 60 days)</div>
							<div class="start_date_outer">
								<div><input type="text" class="start_date_input" id="mm" value="" name="mm"/></div>
								<div class="padding01">MM</div>
							</div>
							<div class="start_date_sep"><span id="job_month_error" style="color:#FF0000;"></span><img src="images/date_sep.png" alt="" /></div>
							<div class="start_date_outer">
								<div><input type="text" class="start_date_input" id="dd" name="dd"/></div>
								<div class="padding01">DD</div>
							</div>
							<div class="start_date_sep"> <span id="job_month_error" style="color:#FF0000;"></span><img src="images/date_sep.png" alt="" /></div>
							<div class="start_date_outer">
								<div><input type="text" class="start_date_input" id="yyyy" name="yyyy"/></div>
								<div class="padding01">YYYY</div>
							</div>
							<div class="calender_icon"> <span id="job_month_error" style="color:#FF0000;"></span>
                            <input name="btn_img" type="image" src="images/calender_icon.png" id="edit_jobimg" onclick="removeError('job_month_error')" />
                           <!-- <a href="#"><img src="images/calender_icon.png" alt="" /></a>-->
                            
                            </div>
							<div class="clear"></div>
							<div class="cancel_btn fl" onclick="div_sataus('add_new_job_admin_modal_popup')"><a href="#">cancel</a></div>
							<div class="save_btn fr" onclick="return addJobs();"><a href="#" >save</a></div>
							<div class="clear"></div>
                        </div>
                  </div>
                </div>
			</div>
		</div>
  </div>
  </div>
<!-- ========================================ADD NEW JOB START END ========================================================= -->


<!-- wrapper start here -->
<div id="wrapper">
  <!-- header start here -->
  <div id="header">
    <div class="logo"><a href="http://ajtechbd.com/projects/php/mallrat/" title="mall rat"><img src="images/logo.png" width="160" height="39" alt="mall rate logo" /></a></div>
    <div class="header_right">
      <div class="header_nav">
       <ul>
          <li><a href="http://ajtechbd.com/projects/php/mallrat/index.php"><span>Dashboard</span></a></li>
          <li><a href="ap_mallrat_accounts_list.php"><span>Accounts</span></a></li>
          <li><a href="ap_mallrat_users_list.php"><span>Users</span></a></li>
          <li ><a href="#"><span>MapBuilder</span></a></li>
          <li><a href="#"><span>Designer</span></a></li>
          <li><a href="ap_mallrat_contact.php"><span>Content</span></a></li>
          <li><a href="#"><span>Data</span></a></li>
          <li><a href="#"><span>Billing</span></a></li>
        </ul>
      
      
      
        
      </div>
    </div>
    <div class="right_mail_logout_box">
      <ul>
        <li><a href="#">Logout</a></li>
        <li><a href="#">Mall Rat</a></li>
      </ul>
      <div class="user">
      <ul class="menu">
              <li class="menu-item-first"><a href="#">Edward Bishop</a>
                 <ul class="sub-menu">
                    <li><a href="ap_mallrat_mall_profile_view.php">Profile</a></li>
                    <li class="last_menu"><a href="#">Account</a></li>


                   
                  </ul>
              </li>
             
          
            </ul>
      	
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <!-- header end here -->
  <!-- content start here -->
  
  <div id="content">
   <div class="content_left_line">
   	<div class="content_right_line">
    	<div class="conent_con">
        	<div class="bradcrumb">
             <p>Accounts > Simon Property Group</p>
            </div>
            
            
            <div class="company_name_con">
        	<h2>Simon Property Group</h2>
            <ul>
            	<li><a href="#">262349</a></li>
            </ul>
        </div>
        	
            <div class="groupProperty ">
            
            <div class="col_1">
            	<ul>
                	<li>11,437 <span >Active Users this month</span></li>
                    <li style="margin: 0pt 0pt 0pt 1.5% ! important;">37 <span>Total Fans</span></li>
                    <li style="margin-right: 0px ! important; float: right ! important;">250 <span>Malls</span></li>
                </ul>
                    
                    </div>
            <div class="col_2">
          	   <ul>
               
                <li style="margin: 0pt 0pt 0pt 0.5% ! important;">233 <span>Map Sessions this month</span></li>
                    <li style="margin: 0pt 0pt 0pt 1.3% ! important;">150 <span>Avg. Map Sessions per month</span></li>
                    <li class="last" style="margin-right: 0px ! important; float: right ! important;">12,356 <span>Total Map Sessions</span></li>
                 
                </ul>
            </div>
            
            	<!--<ul>
                	<li>11,437 <span >Active Users this month</span></li>
                    <li>37 <span>Total Fans</span></li>
                    <li style="margin-left:1px!important; ">250 <span>Malls</span></li>
                    
                    <li>233 <span>Map Sessions this month</span></li>
                    <li style="margin-left:0px!important; margin-right:6px!important;">150 <span>Avg. Map Sessions per month</span></li>
                    <li class="last" style="margin-left:0px!important">12,356 <span>Total Map Sessions</span></li>
                </ul>-->
            </div>
            
            <div class="groupProperty_date">
            	<div class="groupProperty_date_left">
                <ul>
            	<li>Date Range</li>
                <li><input name="" type="text"   class="dateinput"/></li>
                <li>To</li>
                <li><input name="" type="text"   class="dateinput"/></li>
            	</ul>
            </div>
                <div class="groupProperty_date_right_das">
                <ul>
            	<li><a href="#">Apply</a></li>
                <li><a href="#">Current Month</a></li>
                <li><a href="#">3 Months</a></li>
                <li><a href="#">YTD</a></li>
                <li><a href="#">All</a></li>
            	</ul>
            </div>
            	
            </div>
            
            <div class="grap_con">
       	    <!--<img src="images/Shape13.png" width="1250" height="320" />-->
	        	<div id="chart-demo" style="height: 400px; width: 100%;"></div>
         
            </div>
            
             <div class="mallaccount_con">
             
             <div class="mallaccount_left">
       	    	<h1>Mall Information</h1>
                <input name="" type="text"  class="info_box fields" value="" title="Shopping Mall Name"/>
                 <input name="" type="text"  class="info_box fields" value="" title="Address 1"/>
                  <input name="" type="text"  class="info_box fields" value="" title="Address 2"/>
                   <input name="" type="text"  class="info_box fields" value="" title="City"/>
                    <input name="" type="text"  class="info_box fields" value="" title="Province/State"/>
                    <input name="" type="text"  class="info_box fields" value="" title="Postal/Zip Code"/>
                    <select name="Country" class="country">
                    	<option>Country</option>
                    </select>
                    
                    <div class="customer_con">
                    <input name="" type="text"  class="security fields" value="" title="Customer Service"/>
                    <input name="" type="text"  class="security fields" value="" title="Security Number"/>
                    <input name="" type="text"  class="security fields" value="" title="Latitude"/>
                    <input name="" type="text"  class="security fields" value="" title="Longitude"/>
                    </div>
                    <input name="" type="text"  class="info_box fields" value="" title="Website"/>
                    
                    
                    <select name="Country" class="country">
                    	<option>Real Estate Company</option>
                    </select>
                    
                   <div class="save_con" style="width:180px; overflow:hidden; margin:0 auto; clear:both;"> <input name="" type="image"  class="save_button" value="Save"/></div>
              </div>
              
             <div class="mallaccount_right">
       	    	<table cellpadding="0" cellspacing="0" border="0" class="datetable">
                  <tr>
                    <td><h2>Normal Hours</h2></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Monday</td>
                    <td>
                    <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Tuesday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                    <td>Wednesday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>Thursday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                    <td>Friday</td>
                   <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                    <td>Saturday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                    <td>Sunday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Closing Time</option>
                    </select>
                    </td>
                  </tr>
                  
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="datetable">
                  <tr>
                    <td width="10px"></td>
                    <td><h2>Holiday Hours</h2></td>
                   <td colspan="2">
                   
                   <div class="datearea">
                	  <div class="left_side1" >
                    <label><input type="text" name="start_mm" id="start_mm" maxlength="2"  class="start_date_input fields" onclick="removeError('des_error')" title="Start Date" /></label>
                 
                    <label><input type="text" name="start_dd" id="start_dd" maxlength="2" class="start_date_input" value=""/></label>
                 
                    <label><input type="text" name="start_yy" id="start_yy" maxlength="4"class="start_date_input" value=""/></label>
                  
                  <div class="calender_icon">
                      <span id="month_error" style="color:#FF0000;"></span>
                      <input name="btn_img" type="image" src="images/calender_bg.png" id="txtcal" onclick="removeError('month_error')" style="margin:-3px 0 0 0!important"/>
                  </div>
                </div>
                      <div class="left_side1" style="margin-left:2px">
                      
                      <label><input type="text" name="end_mm" id="end_mm" class="start_date_input fields"  title="End Date"/></label>
                      <label> <input type="text" name="end_dd" id="end_dd" class="start_date_input" /></label>
                       <label> <input type="text" name="end_yy" id="end_yy" class="start_date_input" /></label>
                        <div class="calender_icon">
                        <span id="endmonth_error" style="color:#FF0000;"></span>
                         <input name="btn_img" type="image" src="images/calender_bg.png" id="txtcal2" onclick="removeError('endmonth_error')"style="margin:-3px 0 0 0!important"/>
                         </div>
                  
                  
                </div>
                    </div>
                    
                   
                   </td>
                  </tr>
                  <tr>
                  <td></td>
                    <td>Monday</td>
                    <td>
                    <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                  <tr>
                  <td></td>
                    <td>Tuesday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                   <td></td>
                    <td>Wednesday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                  
                  <tr>
                  <td></td>
                    <td>Thursday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                   <td></td>
                    <td>Friday</td>
                   <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                   <td></td>
                    <td>Saturday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                   <tr>
                   <td></td>
                    <td>Sunday</td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>
                     <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                  </tr>
                  
                </table>

              </div>
              
              <div class="mallaccount_right">
       	    	<table cellpadding="0" cellspacing="0" border="0" class="datetable" style="width:48.5%!important;">
                  
                  <tr >
                    <td colspan="4"><h2>Holidays and Special Dates</h2></td>
                  </tr>
                  
                  <tr>
                    <td height="22px"><strong>Good Friday</strong></td>
                    <td height="22px">04-07-2012</td>
                    <td height="22px">10:00am to 5:00pm</td>
                    <td height="22px"><img src="images/close.png" width="16" height="16" /></td>
                  </tr>
                   <tr>
                    <td height="22px"><strong>Easter Sunday</strong></td>
                     <td>04-07-2012</td>
                    <td>10:00am to 5:00pm</td>
                    <td><img src="images/close.png" width="16" height="16" /></td>
                  </tr>
                  <tr>
                    <td height="22px"><strong>Easter Monday</strong></td>
                    <td>04-07-2012</td>
                    <td>10:00am to 5:00pm</td>
                    <td><img src="images/close.png" width="16" height="16" /></td>
                  </tr>
                  
                   
                   
                   
                  
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="datetable" style="width:48.5%!important;">
                  
                  <tr>
                    <td colspan="4">&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td colspan="4"><input name="" type="text"  value=""  class="holiday fields" title="Holiday or Special Date Name"/></td>
                  </tr>
                   <tr>
                    <td colspan="4"><input name="" type="text" value="" class="date-box2 fields" title="Date" /></td>
                  </tr>
                  <tr>
                    <td>
                    <select name="" style=" margin:0 0 0 10px;">
                    	<option>Open Time</option>
                    </select></td>
                    <td>
                    <select name="">
                    	<option>Open Time</option>
                    </select>
                    </td>
                    <td>Closed</td>
                    <td><input name="" type="checkbox" value="" id="closed" /></td>
                  </tr>
                  
                    <tr>
                    <td colspan="4"><input name="" type="image"  class="save_button"  style="margin-bottom:11px!important;"value="Save"/></td>
                  </tr>
                    
                   
                  
                </table>
               
              </div>
            </div>
            
            
            <div class="status_con">
            	<div style="display:block;" class="right_nav" id="res">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
              <tr class="right_top_nav">
                <td width="15%" scope="col" style="padding-left:20px!important;">Store Name</td>
                <td width="33%" scope="col">Description</td>
                <td width="20%" scope="col">Category</td>
                <td width="10%" scope="col">Phone</td>
                <td width="10%" scope="col">Floor</td>
                <td width="7%">&nbsp;</td>
              </tr>
                <tr class="right_bottom_nav">
                <td scope="col" style="padding-left:20px!important;">The Equipment Connection</td>
                <td scope="col">Macy's captures the spirit of America as the nation's department...</td>
                <td scope="col">Footwear, Jewllery & Accessories</td>
                <td scope="col">123-123-1234</td>
                <td scope="col">1</td>
                <td> <div onclick="editPopup('edit_event_modal_admin_popup'),editRecords('145');" class="edit_btn basic"> <a href="#">View</a>  </div> </td>
            
        </tr>
           		<tr class="right_bottom_nav" >
                <td scope="col" style="padding-left:20px!important;">The Equipment Connection</td>
                <td scope="col">Macy's captures the spirit of America as the nation's department...</td>
                <td scope="col">Footwear, Jewllery & Accessories</td>
                <td scope="col">123-123-1234</td>
                <td scope="col">2</td>
                
            <td> <div onclick="editPopup('edit_event_modal_admin_popup'),editRecords('145');" class="edit_btn basic"> <a href="#">View</a>  </div> </td>
        </tr>
            
            </tbody>
            </table>
          </div>
            </div>
        	
        </div>
        
        
    </div>
   </div>
   
  </div>
  <!-- content end here -->
</div>
<!-- wrapper end here -->
</body>
</html>