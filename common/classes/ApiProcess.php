<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/ApiBase.php" ; ?>
<?php

if (! class_exists("ApiProcess"))
{

	class ApiProcess extends ApiBase
	{
		
		function __construct($req)
		{
			parent::__construct($req);
		}
		
		function processRunGate()
		{
			$logData = "Call API : processRunGate";
			$this->writeFileLog($logData, 'processRunGate');
			
			$this->sendBiPush();
		}
		
		
		function getBulkPushData($push_code)
		{
			$sql = "
				SELECT *
				FROM tbl_push_target_bulk
				WHERE push_code = '{$push_code}'
			";
			$result = $this->getArray($sql);
			
			
			$sql = "
				DELETE FROM tbl_push_target_bulk WHERE push_code = '{$push_code}'	
			";
			$this->update($sql);
			
			return $result;
		}
		
		
		function sendBulkPush()
		{
			$targetList = $this->req["targetList"];
			
			
			for ($i=0; $i<sizeof($targetList); $i++)
			{
				
				$targetList[$i] = json_decode($targetList[$i], true);
			}
			
			$pushObj = new Push();
			$pushObj->pushFlag = $this->req["push_type"];
			$pushObj->pushNo = $this->req["push_no"];
			$pushObj->pushMessage = $this->req["push_msg"];
			$pushObj->sendPushArray($targetList);
		}
		
		
		/**
		 * 정보공유 푸시 전송
		 * 스케줄러 (1분)
		 */
		function sendBiPush()
		{
			$sql = "
				SELECT group_code, board_no, push_msg
				FROM tbl_bi_push
				WHERE status = 1
				GROUP BY group_code, board_no, push_msg
			";
			$groupCodeList = $this->getArray($sql);
			
			if(sizeof($groupCodeList) > 0)
			{
				$sql = "
					UPDATE tbl_bi_push
					SET status = 2
				";
				$this->update($sql);
				
				$pushObj = new Push();
				for($i = 0; $i<sizeof($groupCodeList); $i++)
				{
					$sql = "
						SELECT U.registrationKey, U.deviceTypeID
						FROM tbl_bi_push P
						JOIN tbl_user U ON(P.user_fk = U.no)
						WHERE
							P.group_code = '{$groupCodeList[$i]["group_code"]}'
							AND U.status = 'Y'
							AND U.is_push = 1
							AND U.info_push = 1
							AND U.registrationKey IS NOT NULL
							AND U.registration_key != ''
					";
					$pushTargetList = $this->getArray($sql);
					
					if(sizeof($pushTargetList) > 0)
					{
						$pushObj->pushFlag = $pushObj->PUSH_TYPE_BI;
						$pushObj->pushNo = $groupCodeList[i]["board_no"];
						$pushObj->pushMessage = $groupCodeList[i]["push_msg"];
						$pushObj->sendPushArray($pushTargetList);
					}
				}
				
			}
			
		}
		
		
		
		
		/**
		 * 포인트 충전 차감
		 * 스케줄러(매월1일 00시)
		 */
		function reChargePoint()
		{
			// 남은 포인트 차감
			$sql = "
				SELECT user_fk, group_fk, IFNULL(SUM(CASE trans_type WHEN 'I' THEN amt ELSE (amt*-1) END ), 0) AS balanceAmt
				FROM tbl_point_trans
				GROUP BY user_fk
				HAVING(balanceAmt > 0)
			";
			$targetList = $this->getArray($sql);
			for($i=0; $i<sizeof($targetList); $i++)
			{
				$this->inFn_Common_savePointTrans("O", $targetList[$i]["user_fk"], $targetList[$i]["balanceAmt"], $targetList[$i]["group_fk"], 0, $this->PAY_TYPE_RETRIEVE);			
			}
			
			
			$sql = "
				INSERT INTO tbl_point_trans(user_fk, group_fk, trans_type, amt, pay_type, reg_dt, reg_date)
				(
					SELECT U.user_fk, U.group_fk, 'I', G.group_point, '{$this->PAY_TYPE_ADMIN}', NOW(), CURDATE()
					FROM tbl_user U
					JOIN tbl_user_group G ON(U.group_fk = G.no)
					WHERE U.status = 'Y' AND U.member_type = 'M' AND G.status = 'Y' AND G.group_point > 0
				)
			";
			$this->update($sql);
			
		}
		
		function testPush() {
			
			//$targetList = $this->req["targetList"];
			
			//cPSqn8H5Ijk:APA91bF0tnaPwCqH_ifgnNUR8KOY2B6dEjYUZXdn8Uij-WoRsfa5PeWUMjKhRs9KFQ7Ajvj-hjrLf1-HnR_SVnKxnlGvj2nWj6o_rm4u6Y6qnEHVqmh7
			$targetList[] = array("registration_key" => "fDLcOYmcJTQ:APA91bGKKQG18eFaxsHTeDC7co44ykIlgurkGhOyS1GobHUWCDEQ0TeOCg2KxTjsPxrw0rOI6uc-ILVVDdGgV2054-WsFn-bsWmpNR3uReQd7p6qJjYRaI4EzN97t4SmbqfIU-HOCu6m", "device_type_id" => "1");
				
				
			$pushObj = new Push();
			$pushObj->pushFlag = $this->PUSH_TYPE_ADMIN;
			$pushObj->pushNo = $this->req["push_no"];
			$pushObj->pushMessage = "TEST";
			$pushObj->sendPushArray($targetList);
		}
		
		
		
		
	} //클래스 종료
}
?>