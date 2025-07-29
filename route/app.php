<?php
use think\facade\Route;


Route::get('/', 'index/index');
Route::get('/download', 'index/download');


Route::any('/panel/get_plugin_list', 'api/get_plugin_list');
Route::any('/wpanel/get_plugin_list', 'api/get_plugin_list_win');
Route::post('/down/download_plugin', 'api/download_plugin');
Route::post('/down/download_plugin_main', 'api/download_plugin_main');
Route::post('/panel/get_soft_list_status', 'api/return_success');
Route::post('/panel/get_unbinding', 'api/return_success');
Route::post('/bt_cert', 'api/bt_cert');
Route::post('/Auth/GetAuthToken', 'api/get_auth_token');
Route::post('/Auth/GetBindCode', 'api/return_error');
Route::post('/auth/GetUserGiveAway', 'api/get_user_give_away');
Route::any('/bt_monitor/update_history', 'api/btm_update_history');
Route::any('/bt_monitor/latest_version', 'api/btm_latest_version');
Route::any('/bt_waf/get_malicious_ip', 'api/get_malicious_ip_list');
Route::any('/bt_waf/daily_count_v2', 'api/get_ssl_list');
Route::any('/bt_waf/latest_version', 'api/btwaf_latest_version');

Route::group('authorization', function () {
    Route::post('/login', 'api/authorization_login');
    Route::post('/info', 'api/authorization_info');
    Route::post('/info_v2', 'api/authorization_info');
    Route::post('/update_license', 'api/update_license');
    Route::post('/get_unactivated_licenses', 'api/get_ssl_list');
    Route::post('/is_obtained_btw_trial', 'api/is_obtained_btw_trial');
    Route::miss('api/return_error');
});

Route::group('api', function () {
    Route::any('/panel/get_soft_list', 'api/get_plugin_list');
    Route::any('/panel/get_soft_list_test', 'api/get_plugin_list');
    Route::any('/wpanel/get_soft_list', 'api/get_plugin_list_win');
    Route::any('/wpanel/get_soft_list_test', 'api/get_plugin_list_win');
    Route::get('/getUpdateLogs', 'api/get_update_logs');
    Route::get('/panel/get_version', 'api/get_version');
    Route::get('/wpanel/get_version', 'api/get_version_win');
    Route::get('/panel/get_panel_version', 'api/get_panel_version');
    Route::any('/panel/get_panel_version_v2', 'api/get_panel_version_v2');
    Route::get('/SetupCount', 'api/setup_count');
    Route::any('/panel/updateLinux', 'api/check_update');
    Route::any('/wpanel/updateWindows', 'api/check_update_win');
    Route::post('/panel/check_auth_key', 'api/check_auth_key');
    Route::post('/panel/check_domain', 'api/check_domain');
    Route::post('/panel/check_files', 'api/return_empty');
    Route::get('/index/get_time', 'api/get_time');
    Route::get('/index/get_win_date', 'api/get_win_date');
    Route::get('/panel/is_pro', 'api/is_pro');
    Route::get('/getIpAddress', 'api/get_ip_address');
    Route::get('/GetAD', 'api/return_empty');
    Route::post('/Auth/GetAuthToken', 'api/get_auth_token');
    Route::post('/Auth/GetBindCode', 'api/return_error');
    Route::post('/Auth/GetSSLList', 'api/get_ssl_list');
    Route::post('/Cert/get_order_list', 'api/return_empty_array');
    Route::post('/Cert/get_product_list', 'api/return_success');
    Route::get('/Pluginother/get_file', 'api/download_plugin_other');
    Route::get('/isCN', 'api/check_cnip');

    Route::post('/Pluginother/create_order', 'api/return_success');
    Route::post('/Pluginother/renew_order', 'api/return_success');
    Route::post('/Pluginother/order_stat', 'api/return_empty');
    Route::post('/Pluginother/re_order_stat', 'api/return_empty');
    Route::post('/Pluginother/create_order_okey', 'api/return_empty');

    Route::post('/Plugin/check_order_pay_status', 'api/return_error');
    Route::post('/Plugin/get_product_discount', 'api/return_error');
    Route::post('/Plugin/get_order_list_byuser', 'api/return_page_data');
    Route::post('/Plugin/create_order', 'api/return_error');
    Route::post('/Plugin/check_product_pays', 'api/return_error');
    Route::post('/Plugin/get_product_list', 'api/return_empty_array');
    Route::post('/Plugin/get_re_order_status', 'api/return_error');
    Route::post('/Plugin/create_order_voucher', 'api/return_error');
    Route::post('/Plugin/get_voucher', 'api/return_empty_array');
    Route::post('/Plugin/check_plugin_status', 'api/return_success');

    Route::post('/invite/get_voucher', 'api/return_empty_array');
    Route::post('/invite/get_order_status', 'api/return_error');
    Route::post('/invite/get_product_discount_by', 'api/return_error');
    Route::post('/invite/get_re_order_status', 'api/return_error');
    Route::post('/invite/create_order_voucher', 'api/return_error');
    Route::post('/invite/create_order', 'api/return_error');

    Route::post('/panel/get_plugin_remarks', 'api/get_plugin_remarks');
    Route::post('/wpanel/get_plugin_remarks', 'api/get_plugin_remarks');
    Route::post('/panel/set_user_adviser', 'api/return_success');

    Route::post('/wpanel/get_messages', 'api/return_empty_array');
    Route::post('/panel/plugin_total', 'api/return_empty');
    Route::post('/panel/plugin_score', 'api/plugin_score');
    Route::post('/panel/get_plugin_socre', 'api/get_plugin_socre');
    Route::get('/panel/s_error', 'api/return_empty');
    Route::post('/panel/get_py_module', 'api/return_error');
    Route::post('/panel/total_keyword', 'api/return_empty');
    Route::post('/panel/model_total', 'api/return_empty');
    Route::post('/wpanel/model_click', 'api/return_empty');
    Route::post('/v2/statistics/report_plugin_daily', 'api/return_error');
    Route::get('/panel/notpro', 'api/return_empty');
    Route::post('/Btdeployment/get_deplist', 'api/get_deplist');
    Route::post('/panel/get_deplist', 'api/get_deplist');
    Route::get('/ip/info_json', 'api/return_empty_array');

    Route::post('/LinuxBeta', 'api/return_error');
    Route::post('/panel/apple_beta', 'api/return_error');
    Route::post('/wpanel/apple_beta', 'api/return_error');
    Route::post('/panel/to_not_beta', 'api/return_error');
    Route::post('/wpanel/to_not_beta', 'api/return_error');
    Route::post('/panel/to_beta', 'api/return_error');
    Route::post('/wpanel/to_beta', 'api/return_error');
    Route::get('/panel/get_beta_logs', 'api/get_beta_logs');
    Route::get('/wpanel/get_beta_logs', 'api/get_beta_logs');

    Route::post('/v2/common_v1_authorization/get_pricing', 'api/return_error2');
    Route::post('/v2/common_v2_authorization/get_pricing', 'api/return_error2');
    Route::post('/v2/synchron', 'api/return_error2');
    Route::post('/v2/product/email/user_surplus', 'api/email_user_surplus');
    Route::post('/v2/product/email', 'api/return_error2');

    Route::any('/bt_waf/getSpiders', 'api/btwaf_getspiders');
    Route::any('/bt_waf/get_malicious', 'api/btwaf_getmalicious');
    Route::post('/bt_waf/addSpider', 'api/return_empty');
    Route::post('/bt_waf/getVulScanInfoList', 'api/return_empty');
    Route::post('/bt_waf/reportInterceptFail', 'api/return_empty');
    Route::any('/bt_waf/get_system_malicious', 'api/return_error2');
    Route::any('/panel/get_spider', 'api/get_spider');

    Route::post('/Auth/GetSocre', 'api/get_ssl_list');
    Route::post('/Auth/SetSocre', 'api/get_ssl_list');
    Route::post('/Auth/SubmitScore', 'api/get_ssl_list');

    Route::post('/Cert_cloud_deploy/get_cert_list', 'api/return_success');
    Route::post('/Cert_cloud_deploy/del_cert', 'api/return_success');

    Route::any('/panel/getSoftList', 'api/get_plugin_list_en');
    Route::any('/panel/getSoftListEn', 'api/get_plugin_list_en');
    Route::post('/panel/download_plugin', 'api/download_plugin_en');
    Route::get('/plugin/download', 'api/download_plugin_other');
    Route::get('/common/getClientIP', 'api/get_ip_address');
    Route::post('/panel/checkDomain', 'api/check_domain');
    Route::get('/panel/getBetaVersionLogs', 'api/get_beta_logs');
    Route::any('/panel/updateLinuxEn', 'api/check_update_en');
    Route::post('/user/verifyToken', 'api/return_success');
    Route::post('/panel/nps/check', 'api/nps_check');
    Route::post('/panel/nps/questions', 'api/nps_questions');
    Route::post('/panel/nps/submit', 'api/nps_submit');
    Route::post('/panel/submit_feature_invoked_bulk', 'api/return_success');
    Route::post('/panel/submit_expand_pack_used', 'api/return_success');
    Route::get('/panel/getLatestOfficialVersion', 'api/get_version_en');
    Route::post('/cert/user/list', 'api/nps_questions');

    Route::miss('api/return_error');
});

Route::get('/admin/verifycode', 'admin/verifycode')->middleware(\think\middleware\SessionInit::class);
Route::any('/admin/login', 'admin/login')->middleware(\think\middleware\SessionInit::class);
Route::get('/admin/logout', 'admin/logout');

Route::group('admin', function () {
    Route::get('/', 'admin/index');
    Route::any('/set', 'admin/set');
    Route::post('/setaccount', 'admin/setaccount');
    Route::post('/testbturl', 'admin/testbturl');
    Route::get('/plugins', 'admin/plugins');
    Route::get('/pluginswin', 'admin/pluginswin');
    Route::get('/pluginsen', 'admin/pluginsen');
    Route::post('/plugins_data', 'admin/plugins_data');
    Route::post('/download_plugin', 'admin/download_plugin');
    Route::get('/refresh_plugins', 'admin/refresh_plugins');
    Route::get('/record', 'admin/record');
    Route::post('/record_data', 'admin/record_data');
    Route::get('/log', 'admin/log');
    Route::post('/log_data', 'admin/log_data');
    Route::get('/list', 'admin/list');
    Route::post('/list_data', 'admin/list_data');
    Route::post('/list_op', 'admin/list_op');
    Route::get('/deplist', 'admin/deplist');
    Route::get('/refresh_deplist', 'admin/refresh_deplist');
    Route::get('/cleancache', 'admin/cleancache');
    Route::any('/ssl', 'admin/ssl');

})->middleware(\app\middleware\CheckAdmin::class);

Route::any('/installapp', 'install/index');

Route::miss(function() {
    return response('404 Not Found')->code(404);
});
