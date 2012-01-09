<?php
if(isset($_POST['message_sender_email'])) {
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "mathias.karstaedt@gmail.com";
    $email_subject = "Anfrage über mathiaskarstaedt.de";
    $error_message = "";
    $contents = array();
     
    $contents['message_sender_name'] = $_POST['message_sender_name']; // required
    $contents['message_sender_email'] = $_POST['message_sender_email']; // required
    $contents['message_body_phone'] = $_POST['message_body_phone']; 
    $contents['message_body_location'] = $_POST['message_body_location'];
    $contents['message_body_company_name'] = $_POST['message_body_company_name'];
    $contents['message_body_existing_website'] = $_POST['message_body_existing_website'];
    $contents['message_body_business'] = $_POST['message_body_business'];
    $contents['message_body_project_nature'] = $_POST['message_body_project_nature'];
    $contents['message_body_project_concept'] = $_POST['message_body_project_concept'];
    $contents['message_body_project_content'] = $_POST['message_body_project_content'];
    $contents['message_body_project_deadlines'] = $_POST['message_body_project_deadlines'];
    $contents['message_body_project_budget'] = $_POST['message_body_project_budget'];
    $contents['message_body_other_detail'] = $_POST['message_body_other_detail'];
     
    // validation expected data exists
    if(strlen(trim($contents['message_sender_name'])) == 0 ||
       strlen(trim($contents['message_sender_email'])) == 0) {
        $error_message .= '<li>Sie haben nicht alle benötigten Formularfelder ausgefüllt.</li>';      
    }

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	if(!preg_match($email_exp, $contents['message_sender_email'])) {
		$error_message .= '<li>Die von Ihnen angegebene Email-Adresse scheint nicht valid zu sein.</li>';
	}
	if(strlen($error_message) > 0) {
		//Fehler ausgeben
		$error_message = "<div class='error-message'><h2>Bitte berichtigen Sie folgende Fehler:</h2><ul>".$error_message."</ul></div>";
		$page = file_get_contents("pages/kontakt.html");
		$page = str_replace("<!-- ERRORMESSAGE -->", $error_message, $page);
		echo $page;
	} else {
		$email_message = "Anfragedetails:\n\n";

		function clean_string($string) {
			$bad = array("content-type","bcc:","to:","cc:","href");
			return str_replace($bad,"",$string);
		}

		foreach($contents as $key => $value) {
			$email_message .= $key.": ".clean_string($value)."\n";
		}

		// create email headers
		$headers = 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		@mail($email_to, $email_subject, $email_message, $headers); 
		
		//Erfolgsmeldung ausgeben
		$page = file_get_contents("pages/contactsuccess.html");
		echo $page;
	}
}
?>
