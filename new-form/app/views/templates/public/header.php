<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="//www.swinburne.edu.au/import/import_interim_ssl.css" />

	<script type="text/javascript" src="//www.swinburne.edu.au/import/js/jquery.js"></script>
	<script type="text/javascript" src="//www.swinburne.edu.au/import/js/swinburne.js"></script>

	<link rel="icon" href="//www.swinburne.edu.au/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="//www.swinburne.edu.au/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="/cwis/php_pages/webapps/css/website_822.css?v=20130917v1" />
	<link rel="stylesheet" type="text/css" href="/app/web-demo/asarker/legacy-form-demo/public/assets/form.css" />

	<script type="text/javascript" src="/app/web-lib/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="/app/web-lib/jquery-lib/validation/1.15.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/app/web-demo/asarker/legacy-form-demo/public/assets/jquery.validation.config.js"></script>

	<title>
		<?php echo $window_title;?>
	</title>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="<?php echo $meta_robots;?>"/>
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
</head>

<body>
	<div id="top">
		<a id="skip_content" href="#content" accesskey="S">Skip to Content</a>
	</div>
	<div id="navigation">
		<ul id="top_menu_top_row">
	        <li id="nav_li_home"><a id="nav_home" href="http://www.swinburne.edu.au/" title="Swinburne Home"  accesskey="1">Home</a></li>

	        <li><a id="nav_about" href="http://www.swinburne.edu.au/about/" onclick="pageTracker._trackEvent('Global Header Links','About',document.URL);">About</a>
	            <ul class="top_menu_top_row__sub">
	                <li><a id="nav_about_our_university" href="http://www.swinburne.edu.au/about/our-university/index.html" title="Our university">Our university</a></li>
	                <li><a id="nav_about_structure" href="http://www.swinburne.edu.au/about/our-structure" title="Our structure">Our structure</a></li>
	                <li><a id="nav_about_leadership_governance" href="http://www.swinburne.edu.au/about/leadership-governance" title="Leadership and governance">Leadership and governance</a></li>
	                <li><a id="nav_about_strategy_initiatives" href="http://www.swinburne.edu.au/about/strategy-initiatives" title="Strategy and initiatives">Strategy and initiatives</a></li>
	                <li><a id="nav_about_jobs" href="http://www.swinburne.edu.au/about/jobs" title="Jobs at Swinburne">Jobs at Swinburne</a></li>
	                <li><a id="nav_about_campuses_facilities" href="http://www.swinburne.edu.au/about/campuses-facilities" title="Campuses and facilities" >Campuses and facilities</a></li>
	                <li><a id="nav_about_faculties" href="http://www.swinburne.edu.au/about/our-structure/faculties-departments/" title="Faculties and departments" >Faculties and departments</a></li>
	                <li><a id="nav_about_alumni" href="http://www.swinburne.edu.au/alumni/" title="Alumni" >Alumni</a></li>
	                <li><a id="nav_about_giving" href="http://www.swinburne.edu.au/giving" title="Giving to Swinburne" >Giving to Swinburne</a></li>
	            </ul>
	        </li>
	        <li><a id="nav_contacts" href="http://www.swinburne.edu.au/contact/" >Contacts &amp; maps</a>
	            <ul class="top_menu_top_row__sub">
	                <li><a id="nav_contacts_contact_us" href="http://www.swinburne.edu.au/contact/" title="Contact us" >Contact us</a></li>
	                <li><a id="nav_contacts_campuses" href="http://www.swinburne.edu.au/about/campuses-facilities/campuses-maps" title="Campuses and maps" >Campuses and maps</a></li>
	                <li><a id="nav_contacts_directory" href="https://www.swin.edu.au/directory/" title="Staff directory" >Staff directory</a></li>
	                <li><a id="nav_contacts_media" href="http://www.swinburne.edu.au/news/media-contacts/" title="Media enquiries" >Media enquiries</a></li>
	            </ul>
	        </li>
	        <li><a id="nav_library" href="http://www.swinburne.edu.au/library/" title="Library" >Library</a></li>
	        <li><a id="nav_staff" href="http://www.swinburne.edu.au/staff/" title="Staff" >Staff</a></li>
	        <li><a id="nav_student" href="http://www.swinburne.edu.au/student/" title="Current Students" >Current Students</a></li>

	    </ul>
	    <ul id="top_menu_bottom_row">
	        <li><a id="nav_future" href="http://www.swinburne.edu.au/study/" >Study with us</a></li>
	        <li><a id="nav_research" href="http://www.swinburne.edu.au/research/" >Research</a></li>
	        <li><a id="nav_industry" href="http://www.swinburne.edu.au/business-partnerships/" >Business &amp; Partnerships</a></li>
	        <li><a id="nav_news" href="http://www.swinburne.edu.au/news/" >News</a></li>
	        <li><a id="nav_events" href="http://www.swinburne.edu.au/events/" >Events</a></li>
	        <li id="global-search-li">

	            <form action="//search.swinburne.edu.au/s/search.html" method="get" id="global-search" >
	                <input type="hidden" name="collection" id="collection" value="swinburne-internet-meta" />
	                <label id="global-search-query-label" for="global-search-query" style="display:none">Search the Swinburne site</label>
	                <input id="global-search-query" type="text" value="" placeholder="Search..." required name="query" />
	                <input id="global-search-submit" type="submit" value="Search" />
	            </form>

	        </li>
	    </ul>
	</div>

	<div id="main">
	    <div id="container">
			<div id="wrapper">
			    <div id="column">
			        <script type="text/javascript">
					<!--
					document.getElementById("nav_student").className = "selected";
					//-->
					</script>

					<!-- START Banner Small Search Version 3: Edited 16 Feb 2012 -->

					<div id="banner-small">
						<div>
					        <p id="banner-logo"><a href="http://www.swinburne.edu.au/"><img alt="Swinburne University of Technology - Melbourne Australia" src="//www.swinburne.edu.au/images/banners/swinburne_logo.gif" width="179" height="91" /></a></p>
					        <p id="pagetitle"><span></span><?php echo $page_title_admin;?></p>
					        <div id="search">
								<ul id="search-switcher">
									<li class="ssearch">Search Site</li>
								</ul>
								<div class="search-tab" id="site-search">
									<form action="http://www.swinburne.edu.au/search/" id="swinburne-site-search">
								    	<h3><label for="query">Search Site</label></h3>

								      	<div class="search-form">
								        	<input type="hidden" id="cof" name="cof" value="FORID:11" />
								        	<input type="hidden" id="ie" name="ie" value="UTF-8" />
								            <input type="hidden" id="analytics_event_site" name="analytics_event" value="Swinburne Site Search" />
								            <input id="cx_site_page" type="hidden" name="cx_site_page" value="http://www.swinburne.edu.au/search/results/" />
								           	<input type="text" name="query" id="query" class="searchbox" value=""/>

								           	<fieldset>
								               	<div>
										    		<input id="cx_swinburne" type="radio" name="cx" value="008801079654556728799:l2vd_fittx8" class="radio" checked="checked" style="visibility:hidden;"/>
								                    <label for="cx_swinburne"></label>
												</div>
								           	</fieldset>
								       	</div>
								        <div class="search-submit">
								        	<input type="image" name="sa" id="go" value="go" src="//www.swinburne.edu.au/images/buttons/go-small-2.gif" alt="Go" />
								       	</div>
									</form>
									<script type="text/javascript" src="//www.swinburne.edu.au/import/js/banner-search-courses-site.js"></script>
								</div>
							</div>
					    </div>
					</div>
					<!-- END Banner Small Search Version 3: Edited 16 Feb 2012 -->

			        <div id="navcol">
			             <div id="left_menu"></div>
			        </div>
			        <div id="content">
			            <div id="content-col">
			              <!-- START: Breadcrumbs -->
			                <div id="breadcrumbs">
				              	<ul>
				              		<li>&gt; <a href="https://www.swinburne.edu.au/current-students/">Current Students</a></li>
				              	</ul>
			            	</div>
							<div class="clear" ></div>

	                      <!-- END: Breadcrumbs -->
	               <!-- START: Main page content -->
