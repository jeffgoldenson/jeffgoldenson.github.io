<?php

require_once "../dompdf_config.inc.php";

//if dompdf.php runs in virtual server root, dirname does not return empty folder but '/' or '\' (windows).
//This leads to a duplicate separator in unix etc. and an error in Windows. Therefore strip off.

$dompdf = dirname(dirname($_SERVER["PHP_SELF"]));
if ( $dompdf == '/' || $dompdf == '\\') {
  $dompdf = '';
}

$dompdf .= "/dompdf.php?base_path=" . rawurlencode("www/test/");

include "head.inc"; 

?>

<script type="text/javascript">

//function resizePreview(){
//  var preview = $("#preview");
//  preview.height($(window).height() - preview.offset().top - 25);
//}

function getPath(hash) {
  var file, type;
  var parts = hash.split(/,/);
  
  file = parts[0];
  
  if (parts.length == 2) {
    type = parts[1];
  }
  
  switch(type) {
    default:
    case "html": 
      return "test/"+file;
    case "pdf":
      return "<?php echo $dompdf; ?>&options[Attachment]=0&input_file="+file+"#toolbar=0&view=FitH&statusbar=0&messages=0&navpanes=0";
  }
}

function setHash(hash) {
  location.hash = "#"+hash;
}

$(function(){
  var preview = $("#preview");
  resizePreview();

  $(window).scroll(function() {
    var scrollTop = Math.min($(this).scrollTop(), preview.height()+preview.parent().offset().top) - 2;
    preview.css("margin-top", scrollTop + "px");
  });

  $(window).resize(resizePreview);
  
  var hash = location.hash;
  var type = "html";
  if (hash) {
    hash = hash.substr(1);
    preview.attr("src", getPath(hash));
  }
});
</script>


<body onload="">

<div class="container"  id="active">
	<div class="row">
    	<div class="span12">
    		<!--<div class="center">-->
    		<div>
    			<img class="icon" src="img/ll-icon-text.png"/>
			</div>	
		</div>
	</div><!--row-->
	<div class="row">
		<div class="span12">
			<h3>Library License is an effort to create a space on the internet where works, still under copyright, may be securely made available to the public. </h2> 
		</div>
		<!--<div class="span6">
			<iframe width="560" height="315" src="http://www.youtube.com/embed/WQXlarkvG0c?list=EC1C200E17E0656FB4" frameborder="0" allowfullscreen></iframe>
		</div>-->
	</div><!--row-->
<br/><!--add spacing the old fashion way-->
		
    	<div class="row">
    		<div class="span6">
    			<div class="center">
    				<img class="icon" src="img/ll-icon.png"/>
				</div>
				
				<p>This is a simple reactive document.</p>
				
				<p>
					On the <span data-var="years" class="TKAdjustableNumber" data-min="1" data-max="20"> anniversary</span> of your works publication, the triggering event will ocurr.
				</p>
				
				

			</div>
			<div class="span6">
				<div class="contract">
					<div class="center">
						<img class="icon-small" src="img/ll-icon.png"/>
					</div>
					
					<p>
						<span class="number">1.</span> Library License. Upon the occurrence of a the Triggering Event of <span class="dynamic-variable" data-var="years"> Years</span> or <span class="dynamic-variable" data-var="time"> days</span>, both Publisher and Author agree to:
						<br/>
						<br/>
						<span class="number">1.1</span> provide each Library one digital copy of the Work at no charge to the Libraries in a format that will enable each Library to exercise the rights
						granted in Section 1.2 below; and
						<br/>
						<br/>
						<span class="number">1.2</span> automatically grant each Library a perpetual, non-exclusive, irrevocable, royalty-free, fully paid up right and license to copy and reformat the Work
						as necessary to distribute digital copies of the Work on a temporary basis to the Library’s members within the United States, subject to the following
						requirements:
						<br/>
						<br/>
						<span class="number">1.2.1</span> the Library may only distribute one copy of the Work at a time so that only one Library member may have access to the Work at any given time;
						<br/>
						<br/>
						<span class="number">1.2.2</span> the Library must limit the amount of time an individual has access to the copy pursuant to the Library’s standard lending policies; and
						<br/>
						<br/>
						<span class="number">1.2.3</span> the Library must implement a commercially reasonable Technological Mechanism in any digital copy of the Work that it loans to its members to help
						ensure that the Library complies with Sections 1.2.1 and 1.2.2. The Author and Publisher agree that nothing in this Section requires the Library to
						implement a Technological Mechanism in the digital copy of the Work that would prevent its members from exercising any rights its members may have under
						law to use copyrightable material, such as fair use or other similar rights.
						<br/>
						<br/>
						<span class="number">1.3</span> Upon the occurrence of a Triggering Event, the Author or Publisher will notify the DPLA that the rights set forth in Section 1 above are thereby
						granted to the Libraries, and the Publisher will deliver a digital copy of the Work to each Library in accordance with Section 1.1.
						<br/>
						<br/>
						<br/>
					</p>
				</div><!--contract-->
				
				
			</div><!--span6-->
    </div><!--row-->
  	
  	
  	
  	
  	
  	
  	
  	
  	<div class="row">
		<div class="span6">
			<div class="input">
				<?php
				
					$extensions = array("html");
						if ( DOMPDF_ENABLE_PHP ) {
						$extensions[] = "php";
					}
				
				// To be compatible with non-GNU systems
					if (!defined("GLOB_BRACE")) {
						$test_files = glob("test/*");
						$test_files = preg_grep("/(" . implode("|",$extensions) . ")/i", $test_files);
					}
					else {
						$test_files = glob("test/*.{".implode(",", $extensions)."}", GLOB_BRACE);
					}
				
					$sections = array(
						"print"    => array(), 
					);
				
					foreach ( $test_files as $file ) {
						preg_match("@[\\/](([^_]+)_?(.*))\.(".implode("|", $extensions).")$@i", $file, $matches);
						$prefix = $matches[2];
				
						if ( array_key_exists($prefix, $sections) ) {
							$sections[$prefix][] = array($file, $matches[3]);
						}
						else {
							$sections["other"][] = array($file, $matches[1]);
						}
					}
				
					foreach ( $sections as $section => $files ) {
						echo "<h3>$section</h3>";
				  
						echo "<ul class=\"samples\">";
						foreach ( $files as $file ) {
						$filename = basename($file[0]);
						$title = $file[1];
						
						echo "<li style=\"list-style-image: url('$arrow');\">\n";
						echo " 
						<a class=\"button\" target=\"preview\" onclick=\"setHash('$filename,html')\" href=\"test/$filename\">HTML</a> 
						<a class=\"button\" target=\"preview\" onclick=\"setHash('$filename,pdf')\" href=\"$dompdf&amp;options[Attachment]=0&amp;input_file=" . rawurlencode($filename) . "#toolbar=0&amp;view=FitH&amp;statusbar=0&amp;messages=0&amp;navpanes=0\">PDF</a> ";
						
						echo "</li>\n";
						}
					echo "</ul>";
					}
				?>
			</div><!--input-->
		</div><!--span-->
		<div class="span6 output">
			<iframe id="preview" name="preview" src="about:blank" frameborder="0" marginheight="0" marginwidth="0"></iframe>
		</div><!--output-->
		
		
	</div><!--row-->
</div><!--container-->
</body> </html>


