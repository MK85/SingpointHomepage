<?php
		$content = "";
		$_PAGE_LYRICS  = 1;
		$_PAGE_SEARCH  = 2;
		$_PAGE_ARTICLE = 3;
		
		startProcessing();

		
		function startProcessing() {
			global $content;
			
			global $_PAGE_LYRICS;
			global $_PAGE_SEARCH;
			global $_PAGE_ARTICLE;
					
			$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
			$url = "";
			
			if(isset($_GET['search']))
			{
				$search_string = $_GET['search'];
				$url = "http://lyrics.wikia.com/Special:Search?search=$search_string&go=1&x=0&y=0";
			} else if(isset($_GET['url'])) {
				$url = $_GET['url'];
				if(stristr($url, "lyrics.wikia.com") === false) {
					return;
				}
			} else {
				return;
			}
			
			// load document
			$dom = new DOMDocument();
			@$dom->loadHTMLFile($url);
			
			$page_type = getPageType($dom);
			
			filter($dom);
			
			switch ($page_type) {
				case $_PAGE_LYRICS  : $content = extractLyricsPage($dom); break;
				case $_PAGE_ARTICLE : $content = extractArticle($dom);    break;
				case $_PAGE_SEARCH  : $content = extractSearch($dom);     break;
				default             : $content = "search";
			}
		}
		
		
		/**
		 * @param DOMDocument $dom
		 */		
		function filter($dom) {
			$xpath = new DOMXPath($dom);
			
			$filterString  = './/span[@class = "editsection"] | ';
			$filterString .= './/span[@class = "editsection-upper"] | ';
			$filterString .= './/div[@id="catlinks"] | ';
			$filterString .= './/div[@id="TOP_RIGHT_BOXAD"] | ';
			$filterString .= './/div[@id="TOP_LEADERBOARD"] | ';
			$filterString .= './/script | .//form';
			
			$lyrics_elements3 = $xpath->query($filterString);
			if ($lyrics_elements3 !== null && $lyrics_elements3->length > 0) {
				for($i=0; $i<$lyrics_elements3->length; $i++) {
					$node = $lyrics_elements3->item($i);
					
					// remove all nodes
					while ($node->childNodes->length)
					     $node->removeChild($node->firstChild);
				}
				
			}
		}
		
		
		/**
		 * @param DOMDocument $dom
		 */		
		function getPageType($dom)
		{
			global $_PAGE_LYRICS;
			global $_PAGE_SEARCH;
			global $_PAGE_ARTICLE;
			
			$xpath = new DOMXPath($dom);
			$lyrics_elements = $xpath->query('.//title');
			
			if (!is_null($lyrics_elements)) {
				$node = $lyrics_elements->item(0);
				$pos = stristr($node->nodeValue, "Search");
				if($pos !== false) {
					return $_PAGE_SEARCH;
				}
			} 
			
			$lyrics_elements2 = $xpath->query('.//div[@class = "lyricbox"]');
			if ($lyrics_elements2 !== null && $lyrics_elements2->length > 0) {
				return $_PAGE_LYRICS;
			}
			
			$lyrics_elements3 = $xpath->query('.//div[@id = "article"]');
			if ($lyrics_elements3 !== null && $lyrics_elements3->length > 0) {
				return $_PAGE_ARTICLE;
			}
			
					
		}

		
		/**
		 * @param DOMDocument $dom
		 */
		function extractLyricsPage($dom) {
			// grab all the on the page
			$xpath = new DOMXPath($dom);
			$lyrics_elements = $xpath->query('.//div[@class = "lyricbox"]');
			
			$node = null;
					
			if (!is_null($lyrics_elements)) {
				$node = $lyrics_elements->item(0);
				
			} else {
				return;
			}
			
			
			return getInnerHTML($node);
		}
		
		
		/**
		 * @param DOMDocument $dom
		 */
		function extractSearch($dom) 
		{
			// set links to proxy
			$tags = $dom->getElementsByTagName('a');
			
			$sarchFiled = $dom->getElementById('search');
			
			// replace all hrefs to proxy
			foreach ($tags as $tag)
			{
				$pos = stristr($tag->getAttribute('href'), "http:");
				$prefix = "";
				if($pos === false) {
					$prefix = "http://lyrics.wikia.com";
				}
				$tag->setAttribute('href', ('search.php/?url='.$prefix).urlencode($tag->getAttribute('href')));
			}
			
			// grab all the on the page
			$node = $dom->getElementById('bodyContent');

			return getInnerHTML($node);
		}
		
		
		/**
		 * 
		 *
		 * @param unknown_type $dom
		 */
		function extractArticle($dom) 
		{
			// set links to proxy
			$tags = $dom->getElementsByTagName('a');
			
			$sarchFiled = $dom->getElementById('search');
			
			// replace all hrefs to proxy
			foreach ($tags as $tag)
			{
				$pos = stristr($tag->getAttribute('href'), "http:");
				$prefix = "";
				if($pos === false) {
					$prefix = "http://lyrics.wikia.com";
				}
				$tag->setAttribute('href', ('search.php/?url='.$prefix).urlencode($tag->getAttribute('href')));
			}
			
			// grab all the on the page
			$node = $dom->getElementById('article');

			return getInnerHTML($node);
		}
		
		
		/**
		 *
		 * @param DOMNode $node
		 * @return String
		 */
		function getInnerHTML($node)
		{
			foreach ($node->childNodes as $child)
			{
				$tmp_doc = new DOMDocument();
				$copy_node = $tmp_doc->importNode($child, true);
				
				
				$tmp_doc->appendChild($copy_node);
				
				$tmp = 	$tmp_doc->saveHTML();
				// filter html
				if(strpos($tmp, 'rtMatcher') === false)
				{
					$innerHTML .= $tmp;
				}
				
			}
				
			return $innerHTML;
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Insert title here</title>
</head>
<body>
	<form action="search.php" method="get">
		Song suchen: <input name="search" type="text"/>
		<input type="submit" value="Suchen"/>
	</form>
	
	<?php echo $content ?>
	
</body>
</html>