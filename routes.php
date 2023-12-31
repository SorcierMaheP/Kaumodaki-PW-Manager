<?php

require_once __DIR__ . '/router.php';

// ##################################################
// ##################################################
// ##################################################

get('/', 'start/index.php');
get('/start', 'start/index.php');
get('/authentication', 'authentication/index.php');
post('/authentication/register', 'authentication/register.php');
get('/authentication/otp', 'authentication/register-form.php');
post('/authentication/register-otp', 'authentication/register-otp.php');
any('/authentication/location', 'authentication/location.php');
post('/authentication/signin', 'authentication/signin.php');
get('/authentication/verify-otp', 'authentication/verify-otp.php');
any('/authentication/reset-mail', 'authentication/reset-mail.php');
any('/authentication/reset-password', 'authentication/reset-password.php');
any('/authentication/contact', 'authentication/contact.php');
get('/authentication/kill-session', 'authentication/kill-session.php');
get('/authentication/terms-and-conditions', 'authentication/tnc.php');

get('/payment', 'payment/checkout_form.php');
post('/payment/checkout', 'payment/checkout.php');
any('/payment/success', 'payment/success.php');

any('/vault', 'vault/index.php');
any('/vault/enter-password', 'vault/add.php');
get('/vault/store-old', 'vault/storeold.php');
get('/vault/password', 'vault/randpwd.php');
get('/vault/passphrase', 'vault/randphr.php');
any('/vault/uploads', 'vault/upload_files.php');
get('/vault/filecontrol', 'vault/filecontrol.php');
get('/vault/logout', 'vault/logout.php');
any('/vault/add-password', 'vault/add_password.php');
any('/vault/settings', 'vault/settings.php');
post('/vault/contact', 'vault/contact.php');
post('/vault/delete', 'vault/del_entries.php');
any('/vault/edit', 'vault/edit.php');
post('/vault/edit-entry', 'vault/edit_entry.php');
get('/vault/update-details', 'vault/details_update.php');
any('/vault/view-password', 'vault/view_password.php');
post('/vault/change-master', 'vault/change_masterpwd.php');

any('/import-data', 'password_maintenance/import.php');

any('/strength-analysis', 'password_strength_analysis/analysis.php');
any('/advanced-strength', 'password_strength_analysis/zxcvbn.php');
any('/strength-analysis/leak', 'password_strength_analysis/leak_lookup.php');

any('/404', '404/404.php');
