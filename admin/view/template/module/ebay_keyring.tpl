<?php echo $header; ?>
<STYLE TYPE="text/css">
<!--

.loading {
	background-image:url('view/image/ebay/load.gif') !important;
	color:#ccc !important; 
	-moz-box-shadow: 0 0 0 #fff !important;
	-webkit-box-shadow: 0 0 0 #fff !important;
}

fieldset {
    overflow:hidden;
    border:0;
    height:30px;   
    margin:3px 0;
}

.effect {
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
    }         
fieldset label {
        display:block;
        width:190px;
        float:left;
        font-weight:700;
        color:#666;
        line-height:2.2em;
}
fieldset input {
        float:left;
        border:1px solid #ccc; 
        height: 20px;
        padding:3px;
        width:190px;
        font-size:12px;
}	

fieldset select {
        float:left;
        border:1px solid #ccc; 
        height: 30px;
        padding:3px;
        width:190px;
        font-size:12px;
}	
a.cssEbayButton:hover {
        border:1px solid #333;
    }
a.cssEbayButton {        
	font-size: 12px;
	background: #fff no-repeat 4px 5px;
	display: inline-block;
	padding: 5px 20px 6px;
	color: #333;
	border:1px solid #ccc;
	text-decoration: none;
	font-weight: bold;
	line-height: 1.2em;
	border-radius: 15px;
	-moz-border-radius: 15px;
	-webkit-border-radius: 15px;
	-moz-box-shadow: 0 1px 3px #999;
	-webkit-box-shadow: 0 1px 3px #999;
	position: relative;
	cursor: pointer;
	outline:none;
	}
-->
</STYLE>

<script type="text/javascript">
	// <![CDATA[
	$(document).ready(function(){			
		$("#r0").hide();
		$("#r1").hide();
		$("#r2").hide();
		$("#r3").hide();
		$("#r4").hide();
	});	
// ]]>
</script>  
<div id="content">

<div class="breadcrumb">

  <?php foreach ($breadcrumbs as $breadcrumb) { ?>

  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>

  <?php } ?>

</div>

<?php if ($error_warning) { ?>

<div class="warning"><?php echo $error_warning; ?></div>

<?php } ?>

<div class="box">

  <div class="heading">

    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>

    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>

  </div>
  <div class="content">
  <div id="tabs" class="htabs"><a href="#tab-keys">Keys</a><a href="#tab-settings">Settings</a><a href="#tab-configure">Configure</a></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div id="tab-keys">
		<div id="addkeys">
			<a href="<?php echo $addkey; ?>">Add Key</a>
			</div>
		<table class="form">
			<thead>
			  <th><fieldset><label>title</label></fieldset></th>
			  <th><fieldset>description</fieldset></th>
			  <th><fieldset>DEVID</fieldset></th>
			  <th><fieldset>AppID</fieldset></th>
			  <th><fieldset>CertID</fieldset></th>
			  <th><fieldset>RuName</fieldset></th>
			  <th><fieldset>ebay_session_id</fieldset></th>
			  <th><fieldset>key_type</fieldset></th>
			  <th><fieldset>token</fieldset></th>
			</thead>
			<?php
			foreach($keys as $key){
				?>
			 <tr>
			  <td><fieldset><label><?php echo $key['title']; ?></label></fieldset></td>
			  <td><fieldset><?php echo $key['description']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['DEVID']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['AppID']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['CertID']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['RuName']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['ebay_session_id']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['key_type']; ?></fieldset></td>
			  <td><fieldset><?php echo $key['token']; ?></fieldset></td>
			</tr>
				<?php
			}
			?>
			
			</table>
			</div>
	<div id="tab-settings">
		<table class="form">
			 <tr>
			  <td><fieldset><label><?php echo $entry_site_id; ?></label></fieldset></td>
			  <td><fieldset><select name="ebay_site_id" id="ebay_site_id" class="effect">
				  <?php if ($ebay_site_id == 100) { ?>
				  <option value="0">United States</option>
				  <option value="100" selected="selected">Ebay Motors</option>
				  <?php } else { ?>
				  <option value="0" selected="selected">United States</option>
				  <option value="100">Ebay Motors</option>
				  <?php } ?>
				</select></fieldset></td>
			</tr>
			 <tr>
			  <td><fieldset><label><?php echo $entry_app_mode; ?></label></fieldset></td>
			  <td><fieldset><select name="ebay_app_mode" class="effect" id="ebay_app_mode">
				  <?php if ($ebay_app_mode == 0) { ?>
				  <option value="1">Sandbox</option>
				  <option value="0" selected="selected">Production</option>
				  <?php } else { ?>
				  <option value="1" selected="selected">Sandbox</option>
				  <option value="0">Production</option>
				  <?php } ?>
				</select></fieldset></td>
			</tr>
			
						
			<tr>
			  <td><fieldset><label><?php echo $entry_status; ?></label></fieldset></td>
			  <td><fieldset><select name="ebay_status" class="effect">
				  <?php if ($ebay_status) { ?>
				  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				  <option value="0"><?php echo $text_disabled; ?></option>
				  <?php } else { ?>
				  <option value="1"><?php echo $text_enabled; ?></option>
				  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				  <?php } ?>
				</select></fieldset></td>
			</tr>
		</table>
	</div>
	<div id="tab-configure">
		<table class="form">	
        <tr>
          <td><fieldset><label>Authorize Extension:</label></fieldset></td>
          <td><a  id="button_auth" onclick="goAuthExtension('<?php echo $ebay_auth_url; ?>')" class="cssEbayButton"><span>Authorize</span></a></td>
		</tr>	  
        <tr>
          <td><fieldset><label>Fetch Token:</label></fieldset></td>
          <td><a  id="button0" onclick="fetchEbayToken('<?php echo $ebay_fetchtoken_url; ?>')" class="cssEbayButton"><span>Fetch Token</span></a></td>
		</tr>
        <tr id="r0">
          <td></td>
          <td><div id='ajaxDiv0'></div></td>
        </tr>	
        <tr>
          <td><fieldset><label>Install API:</label></fieldset></td>
          <td><a  id="button1" onclick="ajaxGetApi('<?php echo $ebay_api_url; ?>')" class="cssEbayButton"><span>Install API</span></a></td>
		</tr>
        <tr id="r1">
          <td></td>
          <td><div id='ajaxDiv1'></div></td>
        </tr>		
		<tr>		
			<td><fieldset><label>Install Check:</label></fieldset></td>
			<td><a  id="button2" onclick="ajaxGetEbayTime('<?php echo $ebay_time_url; ?>')" class="cssEbayButton"><span>eBay Time</span></a></td>
        </tr> 
        <tr id="r2">
          <td></td>
          <td><div id='ajaxDiv'></div></td>
        </tr>	
         <tr>
          <td><fieldset><label>Download Categories:</label></fieldset></td>
          <td><a id="button3" onclick="downloadCatProcess('<?php echo $ebay_cat_url; ?>')" class="cssEbayButton"><span>Download</span></a></td>
        </tr>             
        <tr id="r3">
          <td></td>
          <td><div id='ajaxDiv2'></div></td>
        </tr>
        <tr id="r4">
          <td></td>
          <td><div id='progressbar' style="height: 20px;width: 400px" ></div></td>
        </tr>
		</table>
	</div>
	
</div>
<?php echo $footer; ?>

<script type="text/javascript"><!--

function goAuthExtension(a){
 var ebay_app_mode = document.getElementById('ebay_app_mode').value;
 var ebay_serial_key = document.getElementById('ebay_serial_key').value;
 var ebay_domain_name = document.getElementById('ebay_domain_name').value;	
 var query_str = "&ebay_app_mode=" +  ebay_app_mode + "&ebay_serial_key=" + ebay_serial_key + "&ebay_domain_name=" + ebay_domain_name;
 window.open(a + query_str);
}

function ajaxGetEbayTime(a){
	$("#r2").show();
	$("#button2").addClass('loading');
	var ajaxRequest;  // The variable that makes Ajax possible!
	var passedurl = a;
	var ajaxDisplay = document.getElementById('ajaxDiv');
	//var ajaxDisplay = document.getElementById('txtMsg');
	ajaxDisplay.innerHTML = "Please Wait....";
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser does not support AJAX call");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			$("#r2").hide(6000);
			$("#button2").removeClass('loading');
		}
	}
	
	
	var ebay_site_id = document.getElementById('ebay_site_id').value;
	
	var ebay_app_mode = document.getElementById('ebay_app_mode').value;
	
	var querystring = "&ebay_site_id=" + ebay_site_id + "&ebay_app_mode=" + ebay_app_mode;

	ajaxRequest.open("GET",passedurl + querystring, true);
	ajaxRequest.send(null); 
}

function ajaxGetApi(a){
	$("#r1").show();
	$("#button1").addClass('loading');
	var ajaxRequest;  // The variable that makes Ajax possible!
	var passedurl = a;
	var ajaxDisplay = document.getElementById('ajaxDiv1');

	ajaxDisplay.innerHTML = "Please Wait....";
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser does not support AJAX call");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			$("#r1").hide(6000);
			$("#button1").removeClass('loading');
		}
	}
	
	ajaxRequest.open("GET",passedurl, true);
	ajaxRequest.send(null); 
}

function downloadCatProgress(m,msg) {
		$("#progressbar").progressbar({ value: m });
		var ajaxDisplay = document.getElementById('ajaxDiv2');
		ajaxDisplay.innerHTML = msg;
		if( m == 100 ){
		$("#progressbar").hide('slow');
		
		$("#button3").attr("onClick","downloadCatProcess('<?php echo $ebay_cat_url; ?>');");
		$("#button3").removeClass('loading');
		$("#r3").hide(6000);
		$("#r4").hide('slow');
		}
}

function downloadCatProcess(a) {
		$("#r3").show();
		$("#r4").show();
		$("#button3").removeAttr("onclick");

		$("#button3").addClass('loading');
		
		var passedurl = a;

		var ebay_site_id = document.getElementById('ebay_site_id').value;

		var ebay_app_mode = document.getElementById('ebay_app_mode').value;

		var	querystring = "&ebay_site_id=" + ebay_site_id + "&ebay_app_mode=" + ebay_app_mode;

		var url_to_call = passedurl + querystring;

			$("#progressbar").show();
			var starting_msg = "Please wait....";
			downloadCatProgress(0,starting_msg);
			var iframe = document.createElement("iframe");
			iframe.src = url_to_call;
			iframe.style.display = "none";
			document.body.appendChild(iframe);
 

				
}

function fetchEbayToken(a) {
	$("#r0").show();
	$("#button0").addClass('loading');
	
	 var ebay_app_mode = document.getElementById('ebay_app_mode').value;
	 var ebay_serial_key = document.getElementById('ebay_serial_key').value;
	 var ebay_domain_name = document.getElementById('ebay_domain_name').value;	
	 var query_str = "&ebay_app_mode=" +  ebay_app_mode + "&ebay_serial_key=" + ebay_serial_key + "&ebay_domain_name=" + ebay_domain_name;
	
	var ajaxRequest;  // The variable that makes Ajax possible!
	var passedurl = a + query_str;
	var ajaxDisplay = document.getElementById('ajaxDiv0');

	ajaxDisplay.innerHTML = "Please Wait....";
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser does not support AJAX call");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			$("#r0").hide(6000);
			$("#button0").removeClass('loading');
		}
	}
	
	
	ajaxRequest.open("GET",passedurl, true);
	ajaxRequest.send(null);
}

function disableBtn(btnID, newText) {

    var btn = document.getElementById(btnID);
        btn.disabled = true;
        btn.value = newText;
}

function enableBtn(btnID, newText) {

    var btn = document.getElementById(btnID);
        btn.disabled = false;
        btn.value = newText;

}

//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 
