<h2>Form Validation</h2>

<form method="POST" action="<?=site_url('home/demoform');?>" class="form-horizontal" id="foo" novalidate="novalidate">

	<?php echo validation_errors('<div class="error">', '</div>'); ?>

	<fieldset>

	<div class="control-group">
		<label for="name" class="control-label">Name</label>
		<div class="controls">
			<input type="text" id="name" name="name" required="required" />
			<?=form_error('name');?>
		</div>
	</div>

	<div class="control-group">
		<label for="address" class="control-label">Address</label>
		<div class="controls">
			<input type="text" id="address" name="address" class="address"/>
			<?=form_error('address');?>
		</div>
	</div>

	<div class="control-group">
		<label for="city" class="control-label">City</label>
		<div class="controls">
			<input type="text" id="city" name="city"/>
			<?=form_error('city');?>
		</div>
	</div>

	<div class="control-group">
		<label for="state" class="control-label">State</label>
		<div class="controls">
			<select id="state" name="state">
				<option value="">Choose State</option>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option selected="selected" value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="NE">Nebraska</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NV">Nevada</option>
				<option value="NY">New York</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WI">Wisconsin</option>
				<option value="WV">West Virginia</option>
				<option value="WY">Wyoming</option>
			</select>
			<?=form_error('state');?>
		</div>
	</div>

	<div class="control-group">
		<label for="zip" class="control-label">Zip Code</label>
		<div class="controls">
			<input type="text" id="zip" name="zip" class="zip" />
			<?=form_error('zip');?>
		</div>
	</div>

	<div class="control-group">
		<label for="phone" class="control-label">Phone</label>
		<div class="controls">
			<input type="tel" id="phone" name="phone" />
			<?=form_error('phone');?>
		</div>
	</div>

	<div class="control-group">
		<label for="email" class="control-label">Email</label>
		<div class="controls">
			<input type="email" id="email" name="email" />
			<?=form_error('email');?>
		</div>
	</div>

	<div class="control-group">
		<label for="url" class="control-label">Website</label>
		<div class="controls">
			<input type="url" id="url" name="url" />
			<?=form_error('url');?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Submit" />
	</div>								

</form>

<?php echo client_side_errors('home/demoform');?>

<script>
function run_jquery_validate(form_id)
{
	// Disable HTML5 validation.
	$('form').attr('novalidate', 'novalidate');

	jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
	    phone_number = phone_number.replace(/\s+/g, ""); 
		return this.optional(element) || phone_number.length > 9 &&
			phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
	}, "Please specify a valid phone number");

	jQuery.validator.addMethod("zipcode", function(zipcode, element) {
	    zipcode = zipcode.replace(/\s+/g, ""); 
		return this.optional(element) || zipcode.length == 5 && zipcode.match(/^\d{5}(-\d{4})?$/);
	}, "Please specify a valid zip code");

	jQuery.validator.addMethod("exactlength", function(value, element, param) {
	 return this.optional(element) || value.length == param;
	}, jQuery.format("Please enter exactly {0} characters."));		

	// Run jquery validation
	$('#foo').validate({
			errorElement: "span",
			errorClass: "help-inline",
			onfocusout: function(element){
				$(element).valid();
				},
			highlight: function(element, errorClass, validClass){
					indicate_field_error(element);
				},
			unhighlight: function(element, errorClass, validClass){
					remove_field_error(element);
				},
			rules: <?=jquery_validate_rules('home/demoform');?>
		});
}

$(function() {
 	run_jquery_validate('#foo')
});
</script>
