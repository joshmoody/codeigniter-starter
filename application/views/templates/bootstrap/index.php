<?php $this->load->helper('bootstrap_theme');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>{site_title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
	<link href="<?=bootstrap_theme_url();?>" rel="stylesheet" type="text/css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/latest/js/bootstrap.min.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
	    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<style type="text/css">
	/*
	 * Update our padding and margin.
	 */
	body, #top-nav{
	        padding: 0;
	        margin: 0;
	    }

	div#outer-container{
		margin: 0 -10px 0 -10px;
		padding: 10px 20px 60px 20px;
	}

	/* Desktop */
	@media (min-width: 768px) {
		
		div#outer-container{
			margin: 0;
			padding: 10px 20px 100px 10px;
		
		}	
	}
	</style>
</head>

<body>

<?php $this->load->view('templates/bootstrap/top_nav');?>

{body}

</body>
</html>
