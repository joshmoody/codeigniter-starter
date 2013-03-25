<?php $this->load->helper('bootstrap_theme');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>{site_title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
	<link href="<?=bootstrap_theme_url();?>" rel="stylesheet" type="text/css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/latest/js/bootstrap.min.js"></script>

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
