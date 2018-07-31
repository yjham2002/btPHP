<?
class http {

    var $fp;
    var $host;
    var $port = 80;
    var $path;
    var $variable = array();
    var $errMsg = "Not yet processed";
    var $send_data = "";
    var $received_data = "";

    function http() {
        $this->port = 80;
        $this->path = "/";
        $variable = array();
    }

    function setHost( $v_host ) {
        if ( $v_host == "" ) {
            $this->host = "localhost";
        } else {
            $this->host = $v_host;
        }
    }

    function setPort( $v_port ) {
        if ( $v_port == "" ) {
            $this->port = "80";
        } else {
            $this->port = $v_port;
        }
    }

    function setPath( $v_path ) {
        if ( $v_path == "" ) {
                $this->path = "/";
        } else {
                $this->path = $v_path;
        }
    }

    function setValue( $a_value ) {
        if ( $a_value == "" ) {
                $this->variable = array();
        } else {
                $this->variable = $a_value;
        }
    }

    function open() {
        $this->fp = fsockopen($this->host,$this->port);
        if(!$this->fp) {
            $this->errMsg = "Connection Error";
            return FALSE;
        }
        return TRUE;
    }

    function close() {
        $this->variable = array();
        fclose($this->fp);
    }

    function getMethod() {
        if($this->open() != TRUE) return FALSE;
        if($this->variable) {

            if(is_array($this->variable)) {
                $parameter = "?";
                while (list($key, $val) = each($this->variable)) {
                    $parameter .= $key."=".urlencode($val)."&";
                }
                $parameter = substr($parameter,0,-1);
            } else {
                $parameter = $this->variable;
            }

        }
        $query = "GET $this->path$parameter HTTP/1.0\r\n";
        $query .= "Host: $this->host:$this->port\r\n";
        $query .= "User-agent: PHP/class http 0.1\r\n";
        $query .= "\r\n";

        $this->send_data = $query;

        fputs($this->fp,$query);
        return true;
    }

    function postMethod() {
        if($this->open() != TRUE) return FALSE;
        if($this->variable) {
            $parameter = "\r\n";
            while (list($key, $val) = each($this->variable)) {
                    $parameter .= $key."=".urlencode($val)."&";
            }
            $parameter .= "\r\n";
        }
        $query .= "POST $this->path HTTP/1.0\r\n";
        $query .= "Host: $this->host:$this->port\r\n";
        $query .= "Content-type: application/x-www-form-urlencoded\r\n";
        $query .= "Content-length: ".strlen($parameter)."\r\n";
        if($this->variable) $query .= $parameter;
        $query .= "\r\n";

        $this->send_data = $query;

        fputs($this->fp,$query);
        return true;
    }

    function getHeader($method) {
        if($method == "get") $ret = $this->getMethod();
        else if($method == "post") $ret = $this->postMethod();

        if( $ret != TRUE ) return "";

        while(trim(fgets($this->fp,1024)) != "") {
            $buffer .= fgets($this->fp,1024);
        }
        $this->close();
        return $buffer;
    }

    function getHeaderWithCode($method) {
        if($method == "get") $ret = $this->getMethod();
        else if($method == "post") $ret = $this->postMethod();

        if( $ret != TRUE ) return "";

        $buffer = fgets($this->fp,1024);
        while(!feof($this->fp)) {
            $buffer .= fgets($this->fp,1024);
        }
        $this->close();
        return $buffer;
    }

    function getBody($method) {
        if($method == "get") $ret = $this->getMethod();
        else if($method == "post") $ret = $this->postMethod();

        if( $ret != TRUE ) return "";

        while(trim(fgets($this->fp,1024)) != "");
        while(!feof($this->fp)) {
            $buffer .= fgets($this->fp,1024);
        }
        $this->close();

        $this->received_data = $buffer;

        return $buffer;
    }

    function doGet() {
        $ret = $this->getMethod();
        if( $ret != TRUE ) return "";

        while(trim(fgets($this->fp,1024)) != "");
        while(!feof($this->fp)) {
            $buffer .= fgets($this->fp,1024);
        }
        $this->close();
        return $buffer;
    }

    function doPost() {
        $ret = $this->postMethod();
        if( $ret != TRUE ) return "";

        while(trim(fgets($this->fp,1024)) != "");
        while(!feof($this->fp)) {
            $buffer .= fgets($this->fp,1024);
        }
        $this->close();
        return $buffer;
    }
}
?>