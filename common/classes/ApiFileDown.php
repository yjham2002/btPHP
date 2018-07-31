<?
/**
 *  PHP 파일 다운로드 함수.
*  Version 1.3
*
*  Copyright (c) 2014 성기진 Kijin Sung
*
*  License: MIT License (a.k.a. X11 License)
*  http://www.olis.or.kr/ossw/license/license/detail.do?lid=1006
*
*  아래와 같은 기능을 수행한다.
*
*  1. UTF-8 파일명이 깨지지 않도록 한다. (RFC2231/5987 표준 및 브라우저 버전별 특성 감안)
*  2. 일부 OS에서 파일명에 사용할 수 없는 문자가 있는 경우 제거 또는 치환한다.
*  3. 캐싱을 원할 경우 적절한 Cache-Control, Expires 등의 헤더를 넣어준다.
*  4. IE 8 이하에서 캐싱방지 헤더 사용시 다운로드 오류가 발생하는 문제를 보완한다.
*  5. 이어받기를 지원한다. (Range 헤더 자동 감지, Accept-Ranges 헤더 자동 생성)
*  6. 일부 PHP 버전에서 대용량 파일 다운로드시 메모리 누수를 막는다.
*  7. 다운로드 속도를 제한할 수 있다.
*
*  사용법  :  send_attachment('클라이언트에게 보여줄 파일명', '서버측 파일 경로', [캐싱할 기간], [속도 제한]);
*
*             아래의 예는 foo.jpg라는 파일을 사진.jpg라는 이름으로 다운로드한다.
*             send_attachment('사진.jpg', '/srv/www/files/uploads/foo.jpg');
*
*             아래의 예는 bar.mp3라는 파일을 24시간 동안 캐싱하고 다운로드 속도를 300KB/s로 제한한다.
*             send_attachment('bar.mp3', '/srv/www/files/uploads/bar.mp3', 60 * 60 * 24, 300);
*
*  반환값  :  전송에 성공한 경우 true, 실패한 경우 false를 반환한다.
*
*  주  의  :  1. 전송이 완료된 후 다른 내용을 또 출력하면 파일이 깨질 수 있다.
*                가능하면 그냥 곧바로 exit; 해주기를 권장한다.
*             2. PHP 5.1 미만, UTF-8 환경이 아닌 경우 정상 작동을 보장할 수 없다.
*                특히 EUC-KR 환경에서는 틀림없이 파일명이 깨진다.
*             3. FastCGI/FPM 환경에서 속도 제한 기능을 사용할 경우 PHP 프로세스를 오랫동안 점유할 수 있다.
*                따라서 가능하면 웹서버 자체의 속도 제한 기능을 사용하는 것이 좋다.
*             4. 안드로이드 일부 버전의 기본 브라우저에서 한글 파일명이 깨질 수 있다.
*             
*             
*/

if(isset($_GET["filename"])){
	send_attachment($_GET["filename"], $_GET["server_filename"]);
}

function send_attachment($filename, $server_filename, $expires = 0, $speed_limit = 0) {

	// 서버측 파일명을 확인한다.

	if (!file_exists($server_filename) || !is_readable($server_filename)) {
		return false;
	}
	if (($filesize = filesize($server_filename)) == 0) {
		return false;
	}
	if (($fp = @fopen($server_filename, 'rb')) === false) {
		return false;
	}

	// 파일명에 사용할 수 없는 문자를 모두 제거하거나 안전한 문자로 치환한다.

	$illegal = array('\\', '/', '<', '>', '{', '}', ':', ';', '|', '"', '~', '`', '@', '#', '$', '%', '^', '&', '*', '?');
	$replace = array('', '', '(', ')', '(', ')', '_', ',', '_', '', '_', '\'', '_', '_', '_', '_', '_', '_', '', '');
	$filename = str_replace($illegal, $replace, $filename);
	$filename = preg_replace('/([\\x00-\\x1f\\x7f\\xff]+)/', '', $filename);

	// 유니코드가 허용하는 다양한 공백 문자들을 모두 일반 공백 문자(0x20)로 치환한다.

	$filename = trim(preg_replace('/[\\pZ\\pC]+/u', ' ', $filename));

	// 위에서 치환하다가 앞뒤에 점이 남거나 대체 문자가 중복된 경우를 정리한다.

	$filename = trim($filename, ' .-_');
	$filename = preg_replace('/__+/', '_', $filename);
	if ($filename === '') {
		return false;
	}

	// 브라우저의 User-Agent 값을 받아온다.

	$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	$old_ie = (bool)preg_match('#MSIE [3-8]\.#', $ua);

	// 파일명에 숫자와 영문 등만 포함된 경우 브라우저와 무관하게 그냥 헤더에 넣는다.

	if (preg_match('/^[a-zA-Z0-9_.-]+$/', $filename)) {
		$header = 'filename="' . $filename . '"';
	}

	// IE 9 미만 또는 Firefox 5 미만의 경우.

	elseif ($old_ie || preg_match('#Firefox/(\d+)\.#', $ua, $matches) && $matches[1] < 5) {
		$header = 'filename="' . rawurlencode($filename) . '"';
	}

	// Chrome 11 미만의 경우.

	elseif (preg_match('#Chrome/(\d+)\.#', $ua, $matches) && $matches[1] < 11) {
		$header = 'filename=' . $filename;
	}

	// Safari 6 미만의 경우.

	elseif (preg_match('#Safari/(\d+)\.#', $ua, $matches) && $matches[1] < 6) {
		$header = 'filename=' . $filename;
	}

	// 안드로이드 브라우저의 경우. (버전에 따라 여전히 한글은 깨질 수 있다. IE보다 못한 녀석!)

	elseif (preg_match('#Android #', $ua, $matches)) {
		$header = 'filename="' . $filename . '"';
	}

	// 그 밖의 브라우저들은 RFC2231/5987 표준을 준수하는 것으로 가정한다.
	// 단, 만약에 대비하여 Firefox 구 버전 형태의 filename 정보를 한 번 더 넣어준다.

	else {
		$header = "filename*=UTF-8''" . rawurlencode($filename) . '; filename="' . rawurlencode($filename) . '"';
	}

	// 캐싱이 금지된 경우...

	if (!$expires) {

		// 익스플로러 8 이하 버전은 SSL 사용시 no-cache 및 pragma 헤더를 알아듣지 못한다.
		// 그냥 알아듣지 못할 뿐 아니라 완전 황당하게 오작동하는 경우도 있으므로
		// 캐싱 금지를 원할 경우 아래와 같은 헤더를 사용해야 한다.

		if ($old_ie) {
			header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0');
			header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
		}

		// 그 밖의 브라우저들은 말을 잘 듣는 착한 어린이!

		else {
			header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
		}
	}

	// 캐싱이 허용된 경우...

	else {
		header('Cache-Control: max-age=' . (int)$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (int)$expires) . ' GMT');
	}

	// 이어받기를 요청한 경우 여기서 처리해 준다.

	if (isset($_SERVER['HTTP_RANGE']) && preg_match('/^bytes=(\d+)-/', $_SERVER['HTTP_RANGE'], $matches)) {
		$range_start = $matches[1];
		if ($range_start < 0 || $range_start > $filesize) {
			header('HTTP/1.1 416 Requested Range Not Satisfiable');
			return false;
		}
		header('HTTP/1.1 206 Partial Content');
		header('Content-Range: bytes ' . $range_start . '-' . ($filesize - 1) . '/' . $filesize);
		header('Content-Length: ' . ($filesize - $range_start));
	} else {
		$range_start = 0;
		header('Content-Length: ' . $filesize);
	}

	// 나머지 모든 헤더를 전송한다.

	header('Accept-Ranges: bytes');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; ' . $header);

	// 출력 버퍼를 비운다.
	// 파일 앞뒤에 불필요한 내용이 붙는 것을 막고, 메모리 사용량을 줄이는 효과가 있다.

	while (ob_get_level()) {
		ob_end_clean();
	}

	// 파일을 64KB마다 끊어서 전송하고 출력 버퍼를 비운다.
	// readfile() 함수 사용시 메모리 누수가 발생하는 경우가 가끔 있다.

	$block_size = 16 * 1024;
	$speed_sleep = $speed_limit > 0 ? round(($block_size / $speed_limit / 1024) * 1000000) : 0;

	$buffer = '';
	if ($range_start > 0) {
		fseek($fp, $range_start);
		$alignment = (ceil($range_start / $block_size) * $block_size) - $range_start;
		if ($alignment > 0) {
			$buffer = fread($fp, $alignment);
			echo $buffer; unset($buffer); flush();
		}
	}
	while (!feof($fp)) {
		$buffer = fread($fp, $block_size);
		echo $buffer; unset($buffer); flush();
		usleep($speed_sleep);
	}

	fclose($fp);

	// 전송에 성공했으면 true를 반환한다.

	return true;
}

?>