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
			
			 	 <tr>
			  <td><fieldset><label><input type="text" id="title" name="title" /></label></fieldset></td>
			  <td><fieldset><input type="text" id="description" name="description" /></fieldset></td>
			  <td><fieldset><input type="text" id="DEVID" name="DEVID" /></fieldset></td>
			  <td><fieldset><input type="text" id="AppID" name="AppID" /></fieldset></td>
			  <td><fieldset><input type="text" id="CertID" name="CertID" /></fieldset></td>
			  <td><fieldset><input type="text" id="RuName" name="RuName" /></fieldset></td>
			  <td><fieldset><input type="text" id="ebay_session_id" name="ebay_session_id" /></fieldset></td>
			  <td><fieldset><input type="text" id="key_type" name="key_type" /></fieldset></td>
			  <td><fieldset><input type="text" id="DEVID" name="DEVID" /></fieldset></td>
			</tr>

			</table>
			</div>
	
	
</div>
<?php echo $footer; ?>
