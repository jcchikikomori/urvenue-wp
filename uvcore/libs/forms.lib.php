<?php

$uvlib_formtemplates = array(
	"formsheaders" => array(
		"method" => "post",
		"action" => $uvlib_global["sendformurl"],
		"successmsg" => "<big>Success! Your information has been submitted.</big><small>Your reservation request does not guarantee entry into the venue.</small>",
		"hiddenfields" => array(
			"venueid" => $uvlib_global["uvvenueid"],
			"ettstate" => "1",
			"sourceid" => "110458069",
			"uvserver" => $uvlib_global["uvserver"],
			"resdate" => "{resdate}"
		)
	),
	"default" => array(
		"restypeid" => array(
			"handle" => "restypecheckboxes"
		),
		"resdate" => array(
			"handle" => "resdate",
			"label" => "Date",
			"name" => "resddate",
			"type" => "text",
			"placeholder" => "Select a Date",
			"required" => true,
			"error" => "Please select a date",
			"extraattr" => "class='uvjs-resdatepicker' readonly",
 		),
		"firstname" => array(
			"handle" => "input",
			"label" => "First Name",
			"name" => "firstname",
			"type" => "text",
			"required" => true,
			"error" => "Please specify your first name"
		),
		"lastname" => array(
			"handle" => "input",
			"label" => "Last Name",
			"name" => "lastname",
			"type" => "text",
			"required" => true,
			"error" => "Please specify your last name"
		),
		"email" => array(
			"handle" => "input",
			"label" => "Email",
			"name" => "email",
			"type" => "text",
			"required" => true,
			"valtype" => "email",
			"error" => "We need your email address to contact you",
			"valtypeerror" => "Your email address must be in the format of name@domain.com"
		),
		"phone" => array(
			"handle" => "input",
			"label" => "Phone",
			"name" => "phone",
			"type" => "text",
			"required" => true,
			"error" => "Please specify your phone",
		),
		"ptotal" => array(
			"handle" => "input",
			"label" => "# Guests",
			"name" => "ptotal",
			"type" => "number",
			"required" => true,
			"error" => "Please specify the number of guests",
			"extraattr" => "min='1'",
			"maxwidth" => 250
		),
		"instructions" => array(
			"handle" => "textarea",
			"label" => "Instructions",
			"name" => "instructions",
			"required" => false,
			"extraattr" => "rows='3'"
		)
	)
);

$uvlib_formfields_structure = array(
	"simplelabel" => array(
		"input" => "<div class='uv-inputcont' {fieldparentstyle}><label>{label}</label><input type='{type}' name='{name}' value='' {extraattrs} {validateattrs}></div>",
		"textarea" => "<div class='uv-inputcont' {fieldparentstyle}><label>{label}</label><textarea name='{name}' {extraattrs} {validateattrs}></textarea></div>",
		"resdate" => "<div class='uv-inputcont' {fieldparentstyle}><label>{label}</label><input type='{type}' name='{name}' value='' placeholder='{placeholder}' {extraattrs} {validateattrs} data-maxdate='" . date("Y-m-d", strtotime("+90 days")) . "'></div>"
	)
);








