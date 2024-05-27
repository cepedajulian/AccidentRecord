<?php
	
		
/**
 * Envia un SMS.
 * @param String $mje
 * @param String $numeroTelefono - caracteristica-nro(sin 0 ni 15) ej: 11-59709048
 * @return boolean
 */	
function sendSMS($mje, $numeroTelefono){
	$telefono = explode('-',$numeroTelefono);
	$caracteristica = $telefono[0];
	$numero = $telefono[1];
	if (!empty($caracteristica) && !empty($numero)){
		try {
			$CI =& get_instance();
			$CI->load->library('SMSC');
			$smsc = new SMSC('', '');
			$smsc->clean();
			$smsc->addNumero($caracteristica, $numero);
			$smsc->setMensaje($mje);
			if ($smsc->enviar()){
				$enviado = true;	
			}else{
				$enviado = false;	
			}
		}catch (Exception $e) {
			echo 'Error '.$e->getCode().': '.$e->getMessage();
			$enviado = false;
		}
	}else{
		$enviado = false;
	}
	return $enviado;
}

/**
 * Envia un Email.
 * @param String $to
 * @param String $subject
 * @param String $msg
 * 			mensaje texto html.
 * @param String $altMsg 
 * 			mensaje alternativo sin formato. 
 * @return boolean
 */
function sendEmail($to, $subject, $msg, $altMsg=null)
{
	$CI =& get_instance();
	$config = array (
			"mailtype" => "html",
			"charset" => "utf-8" );
	
	$CI->load->library('email', $config);
	$CI->load->helper('email');
	
	if (valid_email($to))
	{
		$email_from = $CI->config->item('email_from_dir');
		$email_from_name = $CI->config->item('email_from_name');
		
		$CI->email->from($email_from, $email_from_name);
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($msg);
		$CI->email->set_alt_message($altMsg);
		
		return $CI->email->send();
	}
	return false;
}