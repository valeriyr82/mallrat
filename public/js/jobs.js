// JavaScript Document
function addJobs()
{
	//alert("hello");
	var shop_name=document.getElementById("sel_shopmall").value;
	//alert(shop_name);
	var store_name=document.getElementById("sel_store").value;
	//alert(store_name);
	var title=document.getElementById("txt_title").value;
	//alert(title);
	var ref_number=document.getElementById("txt_jobRef").value;
	//alert(ref_number);
	var desc=document.getElementById("txtArDesc").value;
	//alert(desc);
	var experience=document.getElementById("txtArExp").value;
	//alert(experience);
	var mm=document.getElementById("mm").value;
	//alert(mm);
	var dd=document.getElementById("dd").value;
	//alert(dd);
	var yyyy=document.getElementById("yyyy").value;
	//alert(yyyy);
	
if(title=='')	{
	  document.getElementById('job_error').innerHTML='Please enter job title';
	 document.getElementById('txt_title').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else if(ref_number=='')	{
	  document.getElementById('ref_error').innerHTML='Please enter job reference number';
	 document.getElementById('txt_jobRef').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else if(desc=='')	{
	  document.getElementById('des_error_job').innerHTML='Please Enter Description';
	 document.getElementById('txtArDesc').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else if(experience=='')	{
	 var error = document.getElementById('exp_error').innerHTML='Please Enter Experience';
	 document.getElementById('txtArExp').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else if(mm=='')	{
	 var error = document.getElementById('job_month_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(dd=='')	{
	 var error = document.getElementById('job_day_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(yyyy=='')	{
	 var error = document.getElementById('job_year_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else{	

var url="jobs/insert.php?shop_name="+shop_name+"&store_name="+store_name+"&title="+title+"&ref_number="+ref_number+"&desc="+desc+"&experience="+experience+"&mm="+mm+"&dd="+dd+"&yyyy="+yyyy;
//alert(url);
var obj;
try
{
obj=new XMLHttpRequest();
}
catch(e)
{
try
{
obj=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e)
{
alert("Your browser not supported AJAX ");
}
}
obj.open("GET",url,true);
//alert(url);
obj.send(null);
obj.onreadystatechange=function()
{
if(obj.readyState==4)
{
var add=obj.responseText;
//alert(add);
document.getElementById("add").innerHTML=add;
}
}

var stateevent = document.getElementById('add_new_job_admin_modal_popup').style.display;
//alert(stateevent);
if(stateevent=='block')
{
	document.getElementById('add_new_job_admin_modal_popup').style.display='none';
}


var state = document.getElementById('save-form-content').style.display;
//state=none
if(state=='none'){
		document.getElementById('save-form-content').style.display='block';
	}
}
}

function deletenew_Id(id)
{
	//alert("delte id func"+id);	
	url = "jobs/deleteConfirm_new.php?id="+id;
	
	var obj;
	try
	{
		obj=new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			obj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			alert("Your browser not supported AJAX ");
		}
	}
	obj.open("GET",url,true);
	//alert(url);
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			
			var res=obj.responseText;
			//alert(res);
			document.getElementById("content_delete_popup").innerHTML=res;
		}
	}
}


function deletenew_Record(id)
{
	//alert("delete new records"+id)
	url = "jobs/delete_new.php?id="+id;
	var obj;
	try
	{
		obj=new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			obj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			alert("Your browser not supported AJAX ");
		}
	}
	obj.open("GET",url,true);
	//alert(url);
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			
			var res=obj.responseText;
			//alert(res);
			document.getElementById("add").innerHTML=res;
		}
	}
	
var state =	document.getElementById('content_delete_successfull_popup').style.display;
//alert(state);
if(state == 'none')
{
	document.getElementById('content_delete_successfull_popup').style.display='block';
}else{
	document.getElementById('content_delete_successfull_popup').style.display='none';
}
	
}


function editrecords_new(id)
{
	//alert(id);
	url = "jobs/edit_page.php?id="+id;
	//alert(url);
	
		var obj;
	try
	{
		obj=new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			obj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			alert("Your browser not supported AJAX ");
		}
	}
	obj.open("GET",url,true);
	//alert(url);
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			var update=obj.responseText;
			//alert(update);
			document.getElementById("edit_job_admin_modal_popup").innerHTML=update;
		}
	}
	
}

function edit_record_new(id)
{
	//alert("edit record new"+id);
	
	var state = document.getElementById('edit_job_admin_modal_popup').style.display;
	if (state == 'block') {
		 document.getElementById('edit_job_admin_modal_popup').style.display = 'none';
            } 
			else 
			{
                document.getElementById('edit_job_admin_modal_popup').style.display = 'block';
				 
            }
	//document.getElementById('simplemodal-overlay').style.position = '';
			//document.getElementById('simplemodal-overlay').style.opacity = 0.0;
	//alert(id);
var shop_name=document.getElementById("shop_name1").value;
//alert(shop_name);
var store_name=document.getElementById("store_name1").value;
//alert(store_name);
var title=document.getElementById("title1").value;
//alert(title);
var ref_number=document.getElementById("ref_number1").value;
//alert(ref_number);
var desc=document.getElementById("desc1").value;
//alert(desc);
var experience=document.getElementById("experience1").value;
//alert(experience);
var mm=document.getElementById("mm1").value;
//alert(mm);
var dd=document.getElementById("dd1").value;
//alert(dd);
var yyyy=document.getElementById("yyyy1").value;
//alert(yyyy);


var url="jobs/update.php?shop_name="+shop_name+"&store_name="+store_name+"&title="+title+"&ref_number="+ref_number+"&desc="+desc+"&experience="+experience+"&mm="+mm+"&dd="+dd+"&yyyy="+yyyy+"&id="+id;
//alert(url);
var obj;
try
{
obj=new XMLHttpRequest();
}
catch(e)
{
try
{
obj=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e)
{
alert("Your browser not supported AJAX ");
}
}
obj.open("GET",url,true);
//alert(url);
obj.send(null);
obj.onreadystatechange=function()
{
if(obj.readyState==4)
{
var res=obj.responseText;
//alert(res);
document.getElementById("add").innerHTML=res;

}

}
  
}
function deleteRecord_new(id)
{
	//alert("deleteRecord_new");
	url = "delete.php?delid="+id;
	var obj;
	try
	{
		obj=new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			obj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			alert("Your browser not supported AJAX ");
		}
	}
	obj.open("GET",url,true);
	//alert(url);
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			
			var res=obj.responseText;
			//alert(res);
			document.getElementById("add").innerHTML=res;
		}
	}
var state =	document.getElementById('content_delete_successfull_popup').style.display;
//alert(state);
if(state == 'none')
{
	document.getElementById('content_delete_successfull_popup').style.display='block';
}else{
	document.getElementById('content_delete_successfull_popup').style.display='none';
}

	
}