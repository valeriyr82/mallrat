var PAGINATORSIZE = 7;
var AUTOCOMPLETEDATA = {malls:null,categories:null,vendors:null,realestates:null};
//var cntperpage = 15;
			var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
function addRecord()
 {
	//alert("hello");
 	var mall=document.getElementById("mall").value;
	//alert(mall);
	var store=document.getElementById("store").value;
	//alert(store);
	var event_name=document.getElementById("event_name").value;
	//alert(event_name);
	var event_desc=document.getElementById("event_desc").value;
	//alert(event_desc);
	var start_mm=document.getElementById("start_mm").value;
	//alert(start_mm);
	var start_dd=document.getElementById("start_dd").value;
	//alert(start_dd);
	var start_yy=document.getElementById("start_yy").value;
	//alert(start_yy);
	var end_mm=document.getElementById("end_mm").value;
	//alert(end_mm);
	var end_dd=document.getElementById("end_dd").value;
	//alert(end_yy);
	var end_yy=document.getElementById("end_yy").value;
	//alert(end_dd);
	var twitter_handle=document.getElementById("twitter_handle").value;
	//alert(twitter_handle);
	var twitter_Hashtag=document.getElementById("twitter_Hashtag").value;
	//alert(twitter_Hashtag);
	
if(event_name==''){
 			 document.getElementById('eve_error').innerHTML='Please Enter Event Name';
			 document.getElementById('event_name').style.border='2px solid red';
		return false;
}
else if(event_desc=='')	{
	 var error = document.getElementById('des_error').innerHTML='Please Enter Event Description';
	 			 document.getElementById('event_desc').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else if(start_mm=='')	{
	 var error = document.getElementById('month_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(start_dd=='')	{
	 var error = document.getElementById('month_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(start_yy=='')	{
	 var error = document.getElementById('month_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(end_mm=='')	{
	 var error = document.getElementById('endmonth_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(end_dd=='')	{
	 var error = document.getElementById('endmonth_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(end_yy=='')	{
	 var error = document.getElementById('endmonth_error').innerHTML='*';
	 //alert(error)
	 return false;
}
else if(twitter_handle=='')	{
	 var error = document.getElementById('twitter_error').innerHTML='*';
	 document.getElementById('twitter_handle').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else if(twitter_Hashtag=='')	{
	 var error = document.getElementById('hashtag_error').innerHTML='*';
	 document.getElementById('twitter_Hashtag').style.border='2px solid red';
	 //alert(error)
	 return false;
}
else{
	var url="code.php?mall="+mall+"&store="+store+"&event_name="+event_name+"&event_desc="+event_desc+"&start_mm="+start_mm+"&start_dd="+start_dd+"&start_yy="+start_yy+"&end_mm="+end_mm+"&end_dd="+end_dd+"&end_yy="+end_yy+"&twitter_handle="+twitter_handle+"&twitter_Hashtag="+twitter_Hashtag;
	//alert(url)
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
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			
			var res=obj.responseText;
			//alert(res);
			document.getElementById("res").innerHTML=res;
		}
	}
var stateevent = document.getElementById('add_new_event_modal_admin_popup').style.display;
//alert(stateevent);
if(stateevent=='block'){
	document.getElementById('add_new_event_modal_admin_popup').style.display='none';
}

var state = document.getElementById('save-form-content').style.display;
	//alert(state);
	if(state=='none'){
		//alert("enter in none");
		document.getElementById('save-form-content').style.display='block';
	} 
}
}
 
function div_sataus(divid)
{
	
var state = document.getElementById(divid).style.display;
//status==none
//alert(state);
if (state == 'block') 
  {
	document.getElementById(divid).style.display = 'none';
	
  }
  else {
    document.getElementById(divid).style.display = 'block';   

  }
}

function jobdetails(){
	if(document.getElementById("jobdetails").style.display = 'none'){
		document.getElementById("jobdetails").style.display = 'block';
		document.getElementById("eventdetails").style.display = 'none';
		document.getElementById("activeForm").value = 'jobdetailform';
	}else{
	  document.getElementById("jobdetails").style.display = 'none';	
	}
}

function eventdetails(){
	if(document.getElementById("eventdetails").style.display = 'none'){
		document.getElementById("jobdetails").style.display = 'none';
		document.getElementById("eventdetails").style.display = 'block';
		document.getElementById("activeForm").value = 'eventdetailform';
	}else{
	  document.getElementById("eventdetails").style.display = 'none';	
	}
}


function real_estate_popup(){
	if(document.getElementById("realestate_form").style.display = 'none'){
		document.getElementById("mall_form").style.display = 'none';
		document.getElementById("vandor_form").style.display = 'none';
		document.getElementById("store_form").style.display = 'none';
        document.getElementById("realestate_form").style.display = 'block';    
		document.getElementById("activeForm").value = 'real_estate';	
        
		document.getElementById("extadiv").style.display = 'block';
	}else{
	  document.getElementById("realestate_form").style.display = 'none';	
	}	
}

function mall_popup(){
	if(document.getElementById("mall_form").style.display = 'none'){
		/*$.ajax({
            type: "POST",
            url: '/common/getrealestatelist',
            cache: false,
//            data: {id: id, div:divid, fn: f},
            dataType: 'json',
            success: function(data){
				AUTOCOMPLETEDATA.malls = new Array();
				for(i = 0; i < data.length; i++) {
					AUTOCOMPLETEDATA.malls[i] = data[i].O_COMPANY;
				}
                // = data;
				//console.log(data);
				$("input#mall_real_estate").autocomplete({
					source: AUTOCOMPLETEDATA.malls,
					minLength: 0,
				}).focus(function(){
					$(this).autocomplete('search', "");
				});
            },
            error: function(){
            }
        });*/
		document.getElementById("mall_form").style.display = 'block';
		document.getElementById("vandor_form").style.display = 'none';
		document.getElementById("store_form").style.display = 'none';
		document.getElementById("realestate_form").style.display = 'none';
		document.getElementById("extadiv").style.display = 'none';
		document.getElementById("activeForm").value = 'mall';    
	}else{
	  document.getElementById("mall_form").style.display = 'none';
	}
}

function vandor_popup(){
	if(document.getElementById("vandor_form").style.display = 'none'){
		document.getElementById("mall_form").style.display = 'none';
		document.getElementById("vandor_form").style.display = 'block';
		document.getElementById("store_form").style.display = 'none';
		document.getElementById("realestate_form").style.display = 'none';
		document.getElementById("extadiv").style.display = 'block';
		document.getElementById("extadiv2").style.display = 'block';
        document.getElementById("activeForm").value = 'vendor';    
	}else{
	  document.getElementById("vandor_form").style.display = 'none';	
	}
}

function store_popup(){
	if(document.getElementById("store_form").style.display = 'none'){
		document.getElementById("mall_form").style.display = 'none';
		document.getElementById("vandor_form").style.display = 'none';
		document.getElementById("store_form").style.display = 'block';
		document.getElementById("realestate_form").style.display = 'none';
		document.getElementById("extadiv").style.display = 'block';
		document.getElementById("extadiv2").style.display = 'block';
        document.getElementById("activeForm").value = 'store';    
	}else{
	  document.getElementById("store_form").style.display = 'none';	
	}	
}


function div_status_new(id){
	//alert(id);
}

function deleteConfirm_state(divid,id,f)
{
	var state = document.getElementById(divid).style.display;
    
	//state==none
	if(state=='none'){
        
        $.ajax({
            type: "POST",
            url: '/account/deleteconfirm',
            cache: false,
            data: {id: id, div:divid, fn: f},
            dataType: 'html',
            success: function(msg){
                $('#'+divid).html(msg);
                document.getElementById(divid).style.display = 'block';
            },
            error: function(){
                $(divid).html('Error!');
            }
        });
		
	}
	else{
		//document.getElementById(id).style.display='none';
	}
}

function deleteId(id)
{
	//alert(id);	
	url = "deleteConfirm.php?id="+id;
	
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

function deleteRecord(id)
{
	url = "delete.php?id="+id;
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
			document.getElementById("res").innerHTML=res;
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
 
 
function editPopup(id)
{
	//alert(id);
	var state = document.getElementById(id).style.display;
	//alert(state);
	if(state == 'none'){
		document.getElementById(id).style.display='block';
	}else{
		document.getElementById(id).style.display='none';
	}
}

function editRecords(id){

//alert(id);

url = "edit.php?id="+id;
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
			document.getElementById("edit_event_modal_admin_popup").innerHTML=res;
		}
	}
}
function editPage(id)
{
			 var shopping_mall	= document.getElementById("shopping_mall1").value;
			 //alert(shopping_mall);
		     var store	=document.getElementById("store1").value;
			 //alert(store);
			 var event_name  =document.getElementById("event_name1").value;
			 //alert(event_name);
			 var event_desc	=document.getElementById("description_input1").value;
			 //alert(event_desc);
			 var start_mm	=document.getElementById("start_mm1").value;
			 //alert(start_mm);
			 var start_dd	=document.getElementById("start_dd1").value;
			 //alert(start_dd);
			 var start_yy	=document.getElementById("start_yy1").value;
			 //alert(start_yy);
			 var end_mm	=document.getElementById("end_mm1").value;
			 //alert(end_mm);
			 var end_dd	=document.getElementById("end_dd1").value;
			 //alert(end_yy);
			 var end_yy	=document.getElementById("end_yy1").value;
			 //alert(end_dd);
			 var twitter_handle	=document.getElementById("twitter_handle1").value;
			 //alert(twitter_handle);
			 var twitter_Hashtag	=document.getElementById("twitter_Hashtag1").value;
			 //alert(twitter_Hashtag);
			 
			 var url ="update.php?shopping_mall="+shopping_mall+"&store="+store+"&event_name="+event_name+"&event_desc="+event_desc+"&start_mm="+start_mm+"&start_dd="+start_dd+"&start_yy="+start_yy+"&end_mm="+end_mm+"&end_dd="+end_dd+"&end_yy="+end_yy+"&twitter_handle="+twitter_handle+"&twitter_Hashtag="+twitter_Hashtag+"&id="+id;
			// alert(url);
			 
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
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			
			var res=obj.responseText;
			//alert(res);
			document.getElementById("res").innerHTML=res;
		}
}
}
function countRecords()
{
	//alert("records is counted");	
	var url = "countRecords.php";
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
			document.getElementById("countRecords").innerHTML=res;
		}
}
}
function searchValue(value)
{
	var val =	document.getElementById(value).value;
	var url = "searchRecords.php?val="+val;
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
			document.getElementById("res").innerHTML=res;
		}
}
}
function searchValue_jobs(searchJobs){
	//alert(searchJobs);
	var searchJobs = document.getElementById(searchJobs).value;
	//alert(searchJobs);
	var url = "searchRecords.php?search_jobs="+searchJobs;
	
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

function resetRecords(reset_eve){
	
	var url = "resetRecords.php?reset_event="+reset_eve;
	
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
			document.getElementById("res").innerHTML=res;
		}
}
}
function resetJobs(reset_jobs){
	var url = "resetRecords.php?reset_jobs="+reset_jobs;
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
function pagination( page)
{
	
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
	obj.open("GET","code.php?pageid="+page,true);
	obj.send(null);
	obj.onreadystatechange=function()
	{
		if(obj.readyState==4)
		{
			
			var res=obj.responseText;
			document.getElementById("res").innerHTML=res;
		}
	}
}


function removeError(error)
{
document.getElementById(error).innerHTML='';
document.getElementById('event_name').style.border='none';
document.getElementById('event_desc').style.border='none';
document.getElementById('twitter_handle').style.border='none';
document.getElementById('twitter_Hashtag').style.border='none';

document.getElementById('txt_title').style.border='none';
document.getElementById('txt_jobRef').style.border='none';
document.getElementById('txtArDesc').style.border='none';
document.getElementById('txtArExp').style.border='none';
}

function resetPaginator(totalpagecnt, curpage, cntperpage) {
    paginatorHTML = "<table><tr>";
	paginatorHTML += "<td style='width:20%;'>Current  : ";
    if(totalpagecnt > 0) {paginatorHTML += "<SELECT id='pageselector' onchange='javascript:getpagedata(this.value)'>";for(i = 1; i <= totalpagecnt; i++){if(i == (parseInt(curpage))) {paginatorHTML += "<OPTION value='"+i+"' selected>"+i+"</OPTION>";} else {paginatorHTML += "<OPTION value='"+i+"'>"+i+"</OPTION>";}}paginatorHTML += "</SELECT>";} else {paginatorHTML += "<SELECT>";paginatorHTML += "<td style='width:20%;'><OPTION value='0'>0</OPTION>";paginatorHTML += "</SELECT>";}
	paginatorHTML += "</td><td align='center'>";
	if(totalpagecnt > 0) {
		if(curpage > 1) {
			paginatorHTML += "<span class='prev' onclick='javascript:gotoprevpage();'></span>";
		} else {
			paginatorHTML += "<span class='prev_disable'></span>";
		}
	}
    if(totalpagecnt <= PAGINATORSIZE + 1) { for (i = 1; i <= totalpagecnt; i++) { if(i == curpage) { paginatorHTML += "<span>"+i+"</span>"; } else {  paginatorHTML += "<a href='javascript:getpagedata("+i+")'>"+i+"</a>"; } }
    } else if(curpage < PAGINATORSIZE) {for (i = 1; i <= PAGINATORSIZE; i++) {if(i == curpage) { paginatorHTML += "<span>"+i+"</span>";} else {paginatorHTML += "<a href='javascript:getpagedata("+i+")'>"+i+"</a>";}}paginatorHTML += "...";paginatorHTML += "<a href='javascript:getpagedata("+totalpagecnt+")'>"+totalpagecnt+"</a>";
    } else if(curpage + PAGINATORSIZE > totalpagecnt) {paginatorHTML += "<a href='javascript:getpagedata(1)'>1</a>";paginatorHTML += "...";for (i = totalpagecnt - PAGINATORSIZE + 1; i <= totalpagecnt; i++) {if(i == curpage) {paginatorHTML += "<span>"+i+"</span>";} else {paginatorHTML += "<a href='javascript:getpagedata("+i+")'>"+i+"</a>";}}
    } else {paginatorHTML += "<a href='javascript:getpagedata(1)'>1</a>";paginatorHTML += "...";for (i = curpage - Math.floor(PAGINATORSIZE / 2); i <= curpage + Math.floor(PAGINATORSIZE / 2); i++) {if(i == curpage) {paginatorHTML += "<span>"+i+"</span>";} else {paginatorHTML += "<a href='javascript:getpagedata("+i+")'>"+i+"</a>";}}paginatorHTML += "...";paginatorHTML += "<a href='javascript:getpagedata("+totalpagecnt+")'>"+totalpagecnt+"</a>";}
	if(totalpagecnt > 0) {
		if(curpage < totalpagecnt) {
			paginatorHTML += "<span class='next' onclick='javascript:gotonextpage();'></span>";
		} else {
			paginatorHTML += "<span class='next_disable'></span>";
		}
	}
	paginatorHTML += "</td><td style='width:20%'>Items per page : ";
	paginatorHTML += "	<SELECT id='ippselector' onchange='javascript:countperpagechanged(this.value);'>";
		for(i = 25; i <=200 ; i+=25) {
			if(cntperpage == i) {
				paginatorHTML += "<option value='"+i+"' selected>"+i+"</option>";
			} else {
				paginatorHTML += "<option value='"+i+"'>"+i+"</option>";
			}
		}
		paginatorHTML += "</td></tr></table>";
	paginatorHTML += "	</SELECT>";
    $("#editrec").html(paginatorHTML);
}
function gotoprevpage() {
	var curpage = $("#pageselector").val();
	if(curpage > 1) {
		curpage--;
		getpagedata(curpage);
	}
}
function gotonextpage() {
	var curpage = $("#pageselector").val();
	curpage++;
	getpagedata(curpage);
}
function getpagedata(pagenum) {
    FUNCTIONLIST = {'all': getAccountData, 'active': getAccountData, 'activate': getAccountData, 
                    'pending':getAccountData, 'realestate':getRealstateData, 'mall':getMallData, 'vendor':getVendorData,'store':getStoreData,
					'event':getEventData, 'job':getJobData};
    STATUSLIST = {'all': 'res_1', 'active': 'res_2', 'activate': 'res_2', 'pending': 'res_3',
                    'realestate': 'res_4', 'mall': 'res_5', 'vendor': 'res_7', 'store':'res_8',
					'event':'res_c1','job':'res_c2'};
    currentstatus = $("#curcategory").val();
    FUNCTIONLIST[currentstatus](currentstatus,STATUSLIST[currentstatus], pagenum);
}
function countperpagechanged(cnt) {
    var cntperpage = cnt;
	$("#cntperpage").val(cnt);
	refechpage();
}
function refechpage() {
    if($("#pageselector")) {
        getpagedata($("#pageselector").val());
    }
}
SORTFIELDMAPPER = {"res1_status":"STATUS","res1_type":"ACCOUNTTYPE","res1_name":"ACCOUNTNAME","res1_activity":"UPDATED_ON",
"res2_status":"STATUS","res2_type":"ACCOUNTTYPE","res2_name":"ACCOUNTNAME","res2_activity":"UPDATED_ON",
"res3_status":"STATUS","res3_type":"ACCOUNTTYPE","res3_name":"FULLNAME","res3_activity":"UPDATED_ON",
"res4_status":"STATUS","res4_company":"O_COMPANY","res4_mallcnt":"MALLCNT","res4_gla":"TOTALGLA","res4_traffic":"O_STATE","res4_activity":"LASTACTIVITY",
"res5_status":"STATUS","res5_mallname":"mallname","res5_sqft":"sale_sqft","res5_fans":"fans","res5_sessions":"session_count","res5_city":"mgmt_city","res5_country":"us_can","res5_activity":"lastactivity",
"res7_status":"STATUS","res7_vendor":"ACCOUNT_NAME","res7_totalstores":"STORECNT","res7_category":"CATEGORY_NAME","res7_fans":"FANS","res7_activity":"lastactivity",
"res8_status":"STATUS","res8_vendor":"ACCOUNT_NAME","res8_mallname":"m.NAME","res8_category":"CATEGORY_NAME","res8_fans":"FANS","res8_activity":"lastactivity",
"resc1_eventname":"E.NAME","resc1_shoppingmall":"M.MALLNAME","resc1_startdate":"start_date","resc1_enddate":"end_date","resc1_atendees":"attending",
"resc2_jobrefno":"J.REF_NUMBER","resc2_jobtitle":"J.JOB_TITLE","resc2_shoppingmall":"M.MALLNAME","resc2_enddate":"closing_date","resc2_daysleft":"DAY_LEFT",
}

function getAccountData(status,divid,parampagenum)
    {
        $('#'+divid+' table').find("tr:gt(0)").remove();
		var cntperpage = $("#cntperpage").val();
        resetPaginator(0, 0, cntperpage);
        sortmode = $("#sortmode").val();
        selectedsortfield = $("#sortfield").val();
               
        if(selectedsortfield != "") {
            sortfield = SORTFIELDMAPPER[selectedsortfield];
        } else {
            sortfield = "";
        }
        $.ajax({
                async:false,
                url: '/account/getaccountdata',
                type: 'POST',
                //data: "status="+status,
                data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
                success: function(xmlStr) {
//console.log(xmlStr);
//                return;               
                data =jQuery.parseJSON(xmlStr);
                
                totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
                resetPaginator(totalpagecnt, data.curpage, cntperpage);
                
                $.each(data.result, function(i, item) {
                    var status_img='';
  

                    if(data.result[i].STATUS==0)status_img='activate.png';
                    else if(data.result[i].STATUS==1)status_img='panding1.png'; 
                    else if(data.result[i].STATUS==2)status_img='account.png'; 
                    else if(data.result[i].STATUS==3)status_img='account2.png'; 

                    var account_type='';
                    var link='';
                    if(data.result[i].ACCOUNTTYPE=='Real Estate') {
                        account_type='Realstate';   
                        link='<a href="/account/realestate/id/'+data.result[i].ID+'">View</a>';  
                    }
                    else if(data.result[i].ACCOUNTTYPE=='Mall') {
                        account_type='Mall'; 
                        link='<a href="/account/mall/id/'+data.result[i].ID+'">View</a>';      
                    }
					else if(data.result[i].ACCOUNTTYPE=='Vendor') {
                        account_type='Mall'; 
                        link='<a href="#'+data.result[i].ID+'">View</a>';      
                    }
					else if(data.result[i].ACCOUNTTYPE=='Store') {
                        account_type='Mall'; 
                        link='<a href="#">View</a>';      
                    }
                    else if(data.result[i].ACCOUNTTYPE=='Mall Rate') {
						account_type='Admin';  
						link='<a href="#">View</a>';
                    } else {
						link='<a href="#">View</a>';
					}
                    var str='<tr class="right_bottom_nav"><td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';

                    str+='<td scope="col">'+data.result[i].ACCOUNTTYPE+'</td>';
                    if(typeof data.result[i].ACCOUNTNAME != 'undefined'){
                        str+='<td scope="col">'+data.result[i].ACCOUNTNAME+'</td>';
                    } else {
                        str+='<td scope="col">'+data.result[i].FIRST_NAME+' '+data.result[i].LAST_NAME+'</td>';
                    }
                    str+='<td scope="col">'+data.result[i].UPDATED_ON+'</td>';
                    str+='<td><div class="edit_btn basic" onclick="editPopup(\'edit_event_modal_admin_popup\');">';
                    str+=link+'</div></td>';
                    str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data.result[i].ID+'\',\'delete\');"> <a href="#">delete</a> </div></td></tr>';

                    $('#'+divid+' table tr:last').after(str);
                });
        
                }
        });
    }

function getRealstateData(status, divid, parampagenum)
    {
        $('#'+divid+' table').find("tr:gt(0)").remove();
		var cntperpage = $("#cntperpage").val();
		resetPaginator(0, 0, cntperpage);
        sortmode = $("#sortmode").val();
        selectedsortfield = $("#sortfield").val();
               
        if(selectedsortfield != "") {
            sortfield = SORTFIELDMAPPER[selectedsortfield];
        } else {
            sortfield = "";
        }
        $.ajax({
                async:false,
                url: '/account/getaccountdata',
                type: 'POST',
                data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
                success: function(xmlStr) {
                //console.log(xmlStr);
                //return;  
                    data =jQuery.parseJSON(xmlStr);
                    
                    totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
                resetPaginator(totalpagecnt, data.curpage, cntperpage);
                
                $.each(data.result, function(i, item) {
                  var status_img='';
                  
                  
                  if(data.result[i].STATUS==0)status_img='activate.png';
                  else if(data.result[i].STATUS==1)status_img='panding1.png'; 
                  else if(data.result[i].STATUS==2)status_img='account.png'; 
                  else if(data.result[i].STATUS==3)status_img='account2.png'; 
                   
                 var str=' <tr class="right_bottom_nav">';
                str+='<td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';
                str+='<td scope="col">'+data.result[i].O_COMPANY+'</td>';
                str+='<td scope="col">'+data.result[i].MALLCNT+'</td>';
                str+='<td scope="col">'+data.result[i].TOTALGLA+'</td>';
                //str+='<td scope="col">'+data.result[i].O_STATE+'</td>';
                str+='<td scope="col">'+data.result[i].LASTACTIVITY+'</td>';
                str+='<td><div class="edit_btn basic" onclick="editPopup(\'edit_event_modal_admin_popup\'),editRecords('+data.result[i].REAL_ESTATE_ID+');">';
              str+='<a href="/account/realestate/id/'+data.result[i].ID+'">View</a></div></td>';
            str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data.result[i].ID+'\',\'realdelete\');"> <a href="#">Delete</a> </div></td></tr>';
                   
                    
                   
                    $('#'+divid+' table tr:last').after(str);
   
                }); 
        
                }
        });
    }
    
  function getMallData(status, divid, parampagenum)
    {
        $('#'+divid+' table').find("tr:gt(0)").remove();
		var cntperpage = $("#cntperpage").val();
		resetPaginator(0, 0, cntperpage);
        sortmode = $("#sortmode").val();
        selectedsortfield = $("#sortfield").val();
               
        if(selectedsortfield != "") {
            sortfield = SORTFIELDMAPPER[selectedsortfield];
        } else {
            sortfield = "";
        }
        $.ajax({
                async:false,
                url: '/account/getaccountdata',
                type: 'POST',
                data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
                success: function(xmlStr) {
                    //console.log(xmlStr);
                    //return;
                  
                    data =jQuery.parseJSON(xmlStr);
                    totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
                resetPaginator(totalpagecnt, data.curpage, cntperpage);
                $.each(data.result, function(i, item) {
                  var status_img='';
                  
                  
                  if(data.result[i].STATUS==0)status_img='activate.png';
                  else if(data.result[i].STATUS==1)status_img='panding1.png'; 
                  else if(data.result[i].STATUS==2)status_img='account.png'; 
                  else if(data.result[i].STATUS==3)status_img='account2.png'; 
                   
                var str='<tr class="right_bottom_nav">';
                str+='<td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';
                str+='<td scope="col">'+data.result[i].mallname+'</td>';
                str+='<td scope="col" >'+data.result[i].sale_sqft+'</td>';
                str+='<td scope="col">'+data.result[i].fans+'</td>';
                str+='<td scope="col">'+data.result[i].session_count+'</td>';
                str+='<td scope="col">'+data.result[i].mgmt_city+'</td>';
                str+='<td scope="col">'+data.result[i].us_can+'</td>';
                str+='<td scope="col">'+data.result[i].lastactivity+'</td>';
                str+='<td><div class="edit_btn basic" onclick="show_add_new_job_event_popup_closs(\'edit_event_modal_admin_popup\'),editRecords('+data.result[i].MALL_ID+');">';
              str+='<a href="/account/mall/id/'+data.result[i].ID+'">View</a></div></td>';
            str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data.result[i].ID+'\',\'malldelete\');"> <a href="#">Delete</a> </div></td></tr>';
                   
                    $('#'+divid+' table tr:last').after(str);
   
                }); 
        
                }
        });
    }
    
  function getVendorData(status, divid, parampagenum)
    {
        $('#'+divid+' table').find("tr:gt(0)").remove();
		var cntperpage = $("#cntperpage").val();
		resetPaginator(0, 0, cntperpage);
        sortmode = $("#sortmode").val();
        selectedsortfield = $("#sortfield").val();
               
        if(selectedsortfield != "") {
            sortfield = SORTFIELDMAPPER[selectedsortfield];
        } else {
            sortfield = "";
        }
        $.ajax({
			async:false,
			url: '/account/getaccountdata',
			type: 'POST',
			data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
			success: function(xmlStr) {
				//console.log(xmlStr);
				//return;
				data =jQuery.parseJSON(xmlStr);
				totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
				resetPaginator(totalpagecnt, data.curpage, cntperpage);
				$.each(data.result, function(i, item) {
					var status_img='';

					if(data.result[i].STATUS==0)status_img='activate.png';
					else if(data.result[i].STATUS==1)status_img='panding1.png'; 
					else if(data.result[i].STATUS==2)status_img='account.png'; 
					else if(data.result[i].STATUS==3)status_img='account2.png'; 

					var str='<tr class="right_bottom_nav">';
					str+='<td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';
					str+='<td scope="col">'+data.result[i].ACCOUNT_NAME+'</td>';
					str+='<td scope="col">'+data.result[i].STORECNT+'</td>';
					str+='<td scope="col" >'+data.result[i].CATEGORY_NAME+'</td>';
					str+='<td scope="col">'+data.result[i].FANS+'</td>';
					str+='<td scope="col">'+data.result[i].lastactivity+'</td>';
					str+='<td><div class="edit_btn basic" onclick="show_add_new_job_event_popup_closs(\'edit_event_modal_admin_popup\'),editRecords('+data.result[i].MALL_ID+');">';
					str+='<a href="/account/vendor/id/'+data.result[i].ID+'">View</a></div></td>';
					str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data.result[i].ID+'\',\'vendordelete\');"> <a href="#">Delete</a> </div></td></tr>';

					$('#'+divid+' table tr:last').after(str);
				}); 
			}
        });
        /*$.ajax({
                async:false,
                url: '/account/getaccountdata',
                type: 'POST',
                data: 'status=vendor',
                success: function(xmlStr) {
                  
                    data =jQuery.parseJSON(xmlStr);
                $.each(data, function(i, item) {
                  var status_img='';
                 
                   if(data[i].DELETED>0)status_img='account.png'; 
                  else if(data[i].DELETED==0)status_img='account2.png'; 
                   
                var str='<tr class="right_bottom_nav">';
                str+='<td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';
                str+='<td scope="col">'+data[i].NAME+'</td>';
                str+='<td scope="col">'+data[i].TOTAL_STORE+'</td>';    
                str+='<td scope="col">'+data[i].CATEGORY+'</td>';
               
               
                str+='<td scope="col">-</td>';  
                 str+='<td scope="col">'+data[i].UPDATED_ON+'</td>';   
                str+='<td><div class="edit_btn basic" onclick="show_add_new_job_event_popup_closs(\'edit_event_modal_admin_popup\'),editRecords('+data[i].ID+');">';
              str+='<a href="/account/vendor/id/'+data[i].ID+'">View</a></div></td>';
            str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data[i].ID+'\',\'vendordelete\');"> <a href="#">Delete</a> </div></td></tr>';
                                
                   
                    $('#'+divid+' table tr:last').after(str);
   
                }); 
        
                }
        });*/
    }  
    
  function getStoreData(status, divid, parampagenum)
    {
        $('#'+divid+' table').find("tr:gt(0)").remove();
		var cntperpage = $("#cntperpage").val();
		resetPaginator(0, 0, cntperpage);
        sortmode = $("#sortmode").val();
        selectedsortfield = $("#sortfield").val();
        if(selectedsortfield != "") {
            sortfield = SORTFIELDMAPPER[selectedsortfield];
        } else {
            sortfield = "";
        }
        $.ajax({
			async:false,
			url: '/account/getaccountdata',
			type: 'POST',
			data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
			success: function(xmlStr) {
				//console.log(xmlStr);
				//return;
				data =jQuery.parseJSON(xmlStr);
				totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
				resetPaginator(totalpagecnt, data.curpage, cntperpage);
				$.each(data.result, function(i, item) {
					var status_img='';

					if(data.result[i].STATUS==0)status_img='activate.png';
					else if(data.result[i].STATUS==1)status_img='panding1.png'; 
					else if(data.result[i].STATUS==2)status_img='account.png'; 
					else if(data.result[i].STATUS==3)status_img='account2.png'; 

					var str='<tr class="right_bottom_nav">';
					str+='<td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';
					str+='<td scope="col">'+data.result[i].ACCOUNT_NAME+'</td>';
					str+='<td scope="col">'+data.result[i].MALLNAME+'</td>';
					str+='<td scope="col" >'+data.result[i].CATEGORY_NAME+'</td>';
					str+='<td scope="col">'+data.result[i].FANS+'</td>';
					str+='<td scope="col">'+data.result[i].lastactivity+'</td>';
					str+='<td><div class="edit_btn basic" onclick="show_add_new_job_event_popup_closs(\'edit_event_modal_admin_popup\'),editRecords('+data.result[i].MALL_ID+');">';
					str+='<a href="/account/store/id/'+data.result[i].ID+'">View</a></div></td>';
					str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data.result[i].ID+'\',\'storedelete\');"> <a href="#">Delete</a> </div></td></tr>';

					$('#'+divid+' table tr:last').after(str);

				}); 
			}
        });
        /*$.ajax({
                async:false,
                url: '/account/getaccountdata',
                type: 'POST',
                data: 'status=store',
                success: function(xmlStr) {
                  
                    data =jQuery.parseJSON(xmlStr);
                $.each(data, function(i, item) {
                  var status_img='';
                  
                  
 
                   if(data[i].DELETED>0)status_img='account.png'; 
                  else if(data[i].DELETED==0)status_img='account2.png'; 
                   
                var str='<tr class="right_bottom_nav">';
                str+='<td scope="col" align="center"><img src="images/'+status_img+'" width="80" height="20" alt="" /></td>';
                str+='<td scope="col">'+data[i].STORE_NUMBER+'</td>';
                str+='<td scope="col">'+data[i].MALL+'</td>';    
                str+='<td scope="col">'+data[i].CATEGORY+'</td>';
               
               
                str+='<td scope="col">-</td>';  
                 str+='<td scope="col">'+data[i].UPDATED_ON+'</td>';   
                str+='<td><div class="edit_btn basic" onclick="show_add_new_job_event_popup_closs(\'edit_event_modal_admin_popup\'),editRecords('+data[i].ID+');">';
              str+='<a href="/account/store/id/'+data[i].ID+'">View</a></div></td>';
            str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+data[i].ID+'\',\'storedelete\');"> <a href="#">Delete</a> </div></td></tr>';
                                
                   
                    $('#'+divid+' table tr:last').after(str);
   
                }); 
        
                }
        });*/
    }  
    
function getEventData(status, divid, parampagenum)
{
	$('#'+divid+' table').find("tr:gt(0)").remove();

	var cntperpage = $("#cntperpage").val();
	resetPaginator(0, 0, cntperpage);
	sortmode = $("#sortmode").val();
	selectedsortfield = $("#sortfield").val();
		   
	if(selectedsortfield != "") {
		sortfield = SORTFIELDMAPPER[selectedsortfield];
	} else {
		sortfield = "";
	}
	$.ajax({
		async:false,
		url: '/content/getcontentdata',
		type: 'POST',
		//data: 'status='+status,
		data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
		success: function(xmlStr) {
			//console.log(xmlStr);
			//return;
			data =jQuery.parseJSON(xmlStr);
			totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
			resetPaginator(totalpagecnt, data.curpage, cntperpage);
			$.each(data.result, function(i, item) {
				var srcimage = item.IMAGE_URL;
				filename = srcimage.substring(srcimage.lastIndexOf('/')+1);
				dirpath = srcimage.substring(0, srcimage.length - filename.length);
				console.log(filename + " : " + dirpath);
				var str='<tr class="right_bottom_nav">';
				str+='<td scope="col" align="center"><img src="'+dirpath+"thumb_"+filename+'" width="71" height="42" alt="" /></td>';
				str+='<td scope="col">'+item.NAME+'</td>';
				str+='<td scope="col">'+item.MALLNAME+'</td>';
				str+='<td scope="col">'+item.start_date+' <!--January 18, 2012--></td>';
				str+='<td scope="col">'+item.end_date+'<!--January 20, 2012--></td>';
				str+='<td scope="col">'+item.attending+'</td>';
				str+='<td scope="col">-</td>';
				str+='<td scope="col"><span>NOW</span></td>';
				str+='<td><div class="edit_btn basic" onclick="show_add_new_job_event_popup_closs("'+item.ID+'"),div_sataus(\'\');">';
				str+='<a href="#">View</a></div></td>';
				str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+item.ID+'\',\'contentdelete\');"> <a href="#">delete</a> </div></td></tr>';
				$('#'+divid+' table tr:last').after(str);
			});
		}
	});
}  
    
function getJobData(status, divid, parampagenum)
{
	$('#'+divid+' table').find("tr:gt(0)").remove();

	var cntperpage = $("#cntperpage").val();
	resetPaginator(0, 0, cntperpage);
	sortmode = $("#sortmode").val();
	selectedsortfield = $("#sortfield").val();

	if(selectedsortfield != "") {
		sortfield = SORTFIELDMAPPER[selectedsortfield];
	} else {
		sortfield = "";
	}
	$.ajax({
		async:false,
		url: '/content/getcontentdata',
		type: 'POST',
		//data: 'status='+status,
		data: {status: status, pagenum: parampagenum, cntperpage:cntperpage, sortfield:sortfield, sortmode:sortmode, filterfield:"name", filtervalue:$("#searchValue").val()},
		success: function(xmlStr) {
			//console.log(xmlStr);
			//return;
			data =jQuery.parseJSON(xmlStr);
			totalpagecnt = Math.floor((data.totalcnt - 1) / cntperpage) + 1;
			resetPaginator(totalpagecnt, data.curpage, cntperpage);
			$.each(data.result, function(i, item) {
				var str='<tr class="right_bottom_nav">';
				str+='<td scope="col" align="center">'+item.REF_NUMBER+'</td>';
				str+='<td scope="col">'+item.JOB_TITLE+'</td>';
				str+='<td scope="col">'+item.MALLNAME+'</td>';
				str+='<td scope="col">-</td>';
				str+='<td scope="col">1264</td>';
				str+='<td scope="col">'+item.closing_date+'</td>';
				str+='<td scope="col">'+item.DAY_LEFT+'</td>';
				str+='<td><div class="edit_btn basic" onclick="hide_add_new_job_admin_modal_popup('+item.ID+'),div_sataus(\'\');">';
				str+='<a href="#">View</a></div></td>';
				str+='<td><div class="delete_btn" onclick="deleteConfirm_state(\'content_delete_popup\',\''+item.ID+'\',\'jobdelete\');"> <a href="#" >delete</a> </div></td></tr>';
				$('#'+divid+' table tr:last').after(str);
			});
		}
	});
}  
    
  function updateUserProfile(status)
    {
        
       
        var req_data='';
        if(status=='pass'){
            req_data='profile_pass='+status+'&newpassword='+$('#new_password').val()+'&oldpassword='+$('#old_password').val()+'&id='+$('#id').val(); 
            if($('#new_password').val()!=$('#retype_password').val())
                {
                    alert("Password didn't match'");
                    return;
                }
            if($('#new_password').val().length==0){
                alert("Password can't be blank'");
                return;
            }
        }
        else{
          req_data='profile_pass='+status+'&first_name='+$('#first_name').val()+'&last_name='+$('#last_name').val()+'&email='+$('#email').val()+'&id='+$('#id').val();
          
        }
            
        $.ajax({
                async:false,
                url: '/users/updateprofile',
                type: 'POST',
                data: 'profile_pass='+status+'&first_name='+$('#first_name').val()+'&last_name='+$('#last_name').val()+'&email='+$('#email').val()+'&id='+$('#id').val(),
                success: function(xmlStr) {
                  
                    data =jQuery.parseJSON(xmlStr);
                   if(data.success)
                    {
                        window.location.relod();
                    }else alert(data.msg);
        
                }
        });
    }  
 function deleteAccountRecord(id,method)
{
    document.getElementById('content_delete_popup').style.display='block';  
    $.ajax({
            type: "POST",
            url: '/account/'+method,
            cache: false,
            data: {id: id},
            
            success: function(msg){
                document.getElementById("res").innerHTML=msg;
               
            },
            error: function(){
                document.getElementById("res").innerHTML='Error!';
            }
            
            
        });
    var state =    document.getElementById('content_delete_successfull_popup').style.display;
            //alert(state);
            if(state == 'none')
            {
                document.getElementById('content_delete_successfull_popup').style.display='block';
            }else{
                document.getElementById('content_delete_successfull_popup').style.display='none';
            }
} 

function getAccountDetailsData(is_session){
   
    var xmlDoc;
     var d = [];
    var cdate=new Date();
    //jQuery.post('/index/getstatistics',{'year':cdate.getFullYear(),'month':cdate.getMonth(),'is_session':is_session, 'session_id':$('#session_id').val(), 'mall_id':$('#mall_id').val(), 'real_estate_id':$('#real_estate_id').val()},function(xmlStr){
      $.ajax({
                async:false,
                url: '/index/getstatistics',
                type: 'POST',
                data: 'datefrom='+$('#txtdateform').val()+'&dateto='+$('#txtdateto').val()+'&year='+cdate.getFullYear()+'&month='+cdate.getMonth()+'&is_session='+is_session+'&session_id='+$('#session_id').val()+'&mall_id='+$('#mall_id').val()+'&real_estate_id='+$('#real_estate_id').val(),
                success: function(xmlStr) {
                  
                          if (window.DOMParser) {
                            var parser = new DOMParser();
                            xmlDoc = parser.parseFromString(xmlStr,"text/xml");
                        }
                        else {
                            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                            xmlDoc.async = "false";
                            xmlDoc.loadXML(xmlStr);
                        }
                  if(is_session){
                    $('#total_mall_session').html(addCommas(getNodeValue(xmlDoc, "Total"))); 
                    $('#total_map_session').html(addCommas(getNodeValue(xmlDoc, "TotalDataSessionValue")));                    
                  }else{
                      $('#total_mall_download').html(addCommas(getNodeValue(xmlDoc, "Total")));   
                       $('#total_active_user').html(addCommas(getNodeValue(xmlDoc, "MonthUnique")));           
                       
                  }  
                  $('#total_fans').html(addCommas(getNodeValue(xmlDoc, "TotalFan")));               
                 //showGraph(xmlDoc,is_session); 
                
                  var total=getNodeValue(xmlDoc, "TotalDayData");
                 
                   
                 for(i=1;i<=total;i++){
                 d.push([i, getNodeValue(xmlDoc, "Day"+i)]);   
               }  
               //alert(d);
              // return d.join('-');     
                }
        });

      
      return d;
    
   // });
    
} 
function addNewAccountData()
{
	var formData = $('form#'+$('#activeForm').val()).serialize();
	console.log(formData);
	$.ajax({
		async:false,
		url: '/account/addaccount',
		type: 'POST',
		data: formData,
		success: function(xmlStr) {
			console.log(xmlStr);
			alert(xmlStr);
		}
	});

}
function addNewUserData()
    {
        var formData = $('form#userForm').serialize();
       
         $.ajax({
                async:false,
                url: '/users/adduser',
                type: 'POST',
                data: formData,
                success: function(xmlStr) {
					console.log(xmlStr);                  
                    alert(xmlStr);
                }
         });

    }
function addNewContentData()
{
	var formData = $('form#'+$('#activeForm').val()).serialize();
	console.log(formData);
	$.ajax({
		async:false,
		url: '/content/addcontent',
		type: 'POST',
		data: formData,
		success: function(xmlStr) {
			console.log(xmlStr);
			alert(xmlStr);
		}
	});
}
function getStoreListForCombo(mallid, target) {
	$.ajax({
		async:false,
		url: '/content/getstorelistforcombo',
		type: 'POST',
		data: "mallid="+mallid,
		dataType: 'JSON',
		success: function(result) {
			//console.log(result);
			var str='<select name="event_store" id="store">';
			if(typeof target != 'undefined') {
				$('#'+target).empty();
				$('#'+target).append("<option value=''>Select Store (Optional)</option>");
				$.each(result, function(i, item) {
					$('#'+target).append("<option value='"+item.id+"'>"+item.value+"</option>");
				});
				if(typeof $('#uniform-'+target) != 'undefined') {
					$('#uniform-'+target+' span').text("Select Store (Optional)");
				}
				console.log('log:'+$('#'+target).val()); 
			}
		}
	});
}


