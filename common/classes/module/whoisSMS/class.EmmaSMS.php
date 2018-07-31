<?php
class EmmaSMS {

	var $Args;
	var $Host;
	var $Port;
	var $Path;
	var $errMsg;

	function EmmaSMS() {
		$this->Args = array();
		$this->Host = "www.whoisweb.net";
		$this->Port = 80;
	}

	function login($id, $pass) {
		$this->Args['Id'] = $id;
		$this->Args['Pass'] = $pass;
	}

	function send($To, $From, $Message, $Date='', $SmsType='') {
		if(is_array($To)) $this->Args['To'] = implode(",",$To);
		else $this->Args['To'] = $To;
		$this->Args['From'] = $From;
		$this->Args['Message'] = $Message;
		$this->Args['Date'] = $Date;
        $this->Args['SmsType'] = $SmsType;

		$this->setURL("http://www.whoisweb.net/emma/API/EmmaSend_All.php");
		foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);
		$res = $this->xmlrpc_send('EmmaSend', $args);

		if($res['Code'] != '00') return $this->setError($res['CodeMsg']);
		else return $res;
	}

	function setURL($url) {
		if(!$m = parse_url($url)) return $this->setError("파싱이 불가능한 URL입니다.");

		$this->Host = $m['host'];
		$this->Port = ($m['port']) ? $m['port'] : 80;
		$this->Path = ($m['path']) ? $m['path'] : "/";
		return true;
	}

	function point() {
		$this->setURL("http://www.whoisweb.net/emma/API/EmmaSend_All.php");
		foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);
		$res = $this->xmlrpc_send('EmmaPoint', $args);

		if($res['Code'] != '00') return $this->setError($res['CodeMsg']);
		else return $res['Point'];
	}

	function statistics ($year, $month) {
		if (!checkdate ($month, 1, $year)) return $this->setError("날짜가 잘못되었습니다.");

		$this->Args['date'] = $year."-".$month;

		$this->setURL("http://www.whoisweb.net/emma/API/EmmaSend_All.php");
		foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);
		$res = $this->xmlrpc_send('EmmaStatistic', $args);

		if($res['Code'] != '00') return $this->setError($res['CodeMsg']);
		else {
			$this->Point = $res['Point'];
			return $res['Statistics'];
		}
	}

	function xmlrpc_send($func, $args) {

		$server = new xmlrpc_client($this->Path, $this->Host, $this->Port);
		//$server->setDebug(1);

		$message = new xmlrpcmsg($func, array(xmlrpc_encode2($args)));
		$result = $server->send($message);

		if($result) {
			if($ret = $result->value()) {
				return xmlrpc_decode2($ret);
			} else return $this->setError($result->faultCode().":".$result->faultString());
		} else return $this->setError("서버로의 접속에 장애가 생겼습니다.");
	}

	function setError($msg) {
		$this->errMsg = $msg;
		return false;
	}

}

?>