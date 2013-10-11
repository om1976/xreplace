<html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'));?></h1>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth_actions/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
        <p><?php echo sprintf(lang('email_forgot_password_subheading_manual'), $forgotten_password_code) . base_url('index.php/editor/reset_password');?></p>
</body>
</html>