<?php
	function curl_get_contents($url)
	{
		  $ch = curl_init($url);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		  $data = curl_exec($ch);
		  curl_close($ch);
		  return $data;
	}
	
	$domainName = "mywebsite.com";
	
	$keywords_arr[] = 'keyword 1';
	$keywords_arr[] = 'keyword 2';
	$keywords_arr[] = 'keyword 3';
	
	foreach($keywords_arr as $keyword)
	{
		$kword = trim($keyword);
		$keyword=str_replace(" ","+",trim($keyword));
	
		$page=0; $num=0; $n=0; $start = 1; $end = 5;
		for($start = ($start-1)*10; $start < $end*10; $start += 10)
		{
			$page++;
			$url="http://www.google.co.in/search?ie=UTF-8&q=$keyword&start=$start";
			$data = curl_get_contents($url);
			
			$flag=false;
			$j=-1;
			while( ($j=stripos($data,"<cite>",$j+1)) !==false )
			{
				$k=stripos($data,"</cite>",$j);
				$link=strip_tags(substr($data,$j,$k-$j));
				echo ($n+1).") ".$link.'<br />';
				if (strpos($link,$domainName)!==false)
				{
					$num=($n+1);
					$flag=true;
					break;
				}
				$n++;
			}
			
			if ($flag) {
				break;
			}
		}
		
		if($flag) {
			echo "$kword on $num in link $link<br />";
		}
		else {
			echo "$kword on $num <br />";
		}
		echo '<hr />';
	}
	
?>