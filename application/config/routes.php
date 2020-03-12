<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'DashboardController';

// +++++++++++++++++++++++++++++++++++ USER +++++++++++++++++++++++++++++++++++ 
$route['user']['GET'] = 'UserController';
$route['user/(:num)']['GET'] = 'UserController/show/$1';
$route['user/add']['GET'] = 'UserController/add_get';
$route['user']['POST'] = 'UserController/add_post';
$route['user/(:num)/edit']['GET'] = 'UserController/edit_get/$1';
$route['user/(:num)/edit']['POST'] = 'UserController/edit_post/$1';
$route['user/(:num)/delete']['GET'] = 'UserController/delete/$1';
// +++++++++++++++++++++++++++++++++++ USER +++++++++++++++++++++++++++++++++++ 

// +++++++++++++++++++++++++++++++++++ PROFILE ++++++++++++++++++++++++++++++++++++++++
$route['profile']['GET'] = 'UserController/profile';

// +++++++++++++++++++++++++++++++++++ PERSONEL +++++++++++++++++++++++++++++++++++ 
$route['personel/(:num)']['GET'] ='PersonelController/personelByNRP_get/$1';
// +++++++++++++++++++++++++++++++++++ PERSONEL +++++++++++++++++++++++++++++++++++ 


// ====================== GROUP ======================
$route['group']['GET'] = 'GroupController';
$route['group/(:num)']['GET'] = 'GroupController/show/$1';
$route['group/add']['GET'] = 'GroupController/add_get';
$route['group']['POST'] = 'GroupController/add_post';
$route['group/(:num)/edit']['GET'] = 'GroupController/edit_get/$1';
$route['group/(:num)/edit']['POST'] = 'GroupController/edit_post/$1';
$route['group/(:num)/delete']['GET'] = 'GroupController/delete/$1';
// ====================== GROUP ======================

// ====================== INBOX ======================
$route['inbox']['GET'] = 'InboxController';
$route['inbox/(:num)']['GET'] = 'InboxController/show/$1';
$route['inbox/add']['GET'] = 'InboxController/add_get';
$route['inbox']['POST'] = 'InboxController/add_post';
// ====================== GROUP ======================

// +++++++++++++++++++++++++++++++++++ JENIS SURAT +++++++++++++++++++++++++++++++++++ 
$route['jenisSurat']['GET'] = 'JenisSuratController';
$route['jenisSurat/(:num)']['GET'] = 'JenisSuratController/show/$1';
$route['jenisSurat/add']['GET'] = 'JenisSuratController/add_get';
$route['jenisSurat']['POST'] = 'JenisSuratController/add_post';
$route['jenisSurat/(:num)/edit']['GET'] = 'JenisSuratController/edit_get/$1';
$route['jenisSurat/(:num)/edit']['POST'] = 'JenisSuratController/edit_post/$1';
$route['jenisSurat/(:num)/delete']['GET'] = 'JenisSuratController/delete/$1';
// +++++++++++++++++++++++++++++++++++ JENIS SURAT +++++++++++++++++++++++++++++++++++ 

// +++++++++++++++++++++++++++++++++++ JADWAL RAPAT  +++++++++++++++++++++++++++++++++++ 
$route['jadwalRapat']['GET'] = 'JadwalRapatController';
$route['jadwalRapat/(:num)']['GET'] = 'JadwalRapatController/show/$1';
$route['jadwalRapat/add']['GET'] = 'JadwalRapatController/add_get';
$route['jadwalRapat']['POST'] = 'JadwalRapatController/add_post';
$route['jadwalRapat/(:num)/edit']['GET'] = 'JadwalRapatController/edit_get/$1';
$route['jadwalRapat/(:num)/edit']['POST'] = 'JadwalRapatController/edit_post/$1';
$route['jadwalRapat/(:num)/delete']['GET'] = 'JadwalRapatController/delete/$1';
$route['jadwalRapat/deactivate/(:num)']['GET'] = 'JadwalRapatController/deactivate/$1';
// +++++++++++++++++++++++++++++++++++ JADWAL RAPAT  +++++++++++++++++++++++++++++++++++ 

// +++++++++++++++++++++++++++++++++++ RUANG RAPAT +++++++++++++++++++++++++++++++++++ 
$route['ruangRapat']['GET'] = 'RuangRapatController';
$route['ruangRapatAll']['GET'] = 'RuangRapatController/getRuangRapat';
$route['ruangRapat/(:num)']['GET'] = 'RuangRapatController/show/$1';
$route['ruangRapat/add']['GET'] = 'RuangRapatController/add_get';
$route['ruangRapat']['POST'] = 'RuangRapatController/add_post';
$route['ruangRapat/(:num)/edit']['GET'] = 'RuangRapatController/edit_get/$1';
$route['ruangRapat/(:num)/edit']['POST'] = 'RuangRapatController/edit_post/$1';
$route['ruangRapat/(:num)/delete']['GET'] = 'RuangRapatController/delete/$1';
// +++++++++++++++++++++++++++++++++++ RUANG RAPAT +++++++++++++++++++++++++++++++++++ 

// +++++++++++++++++++++++++++++++++++ PENOMORAN SURAT +++++++++++++++++++++++++++++++++++ 
$route['penomoranSurat']['GET'] = 'PenomoranSuratController';
$route['penomoranSurat/(:num)']['GET'] = 'PenomoranSuratController/show/$1';
$route['penomoranSurat/add']['GET'] = 'PenomoranSuratController/add_get';
$route['penomoranSurat']['POST'] = 'PenomoranSuratController/add_post';

$route['penomoranSurat/uploadDokumen']['POST'] = 'PenomoranSuratController/uploadDokumen_post';
$route['penomoranSurat/cekKouta/(:any)/(:num)']['GET'] = 'PenomoranSuratController/cek_kouta/$1/$2';
$route['penomoranSurat/(:num)/edit']['GET'] = 'PenomoranSuratController/edit_get/$1';
$route['penomoranSurat/(:num)/detail']['GET'] = 'PenomoranSuratController/edit_get/$1';
$route['penomoranSurat/(:num)/edit']['POST'] = 'PenomoranSuratController/edit_post/$1';
$route['penomoranSurat/(:num)/delete']['GET'] = 'PenomoranSuratController/delete/$1';
$route['penomoranSurat/(:num)/reset']['GET'] = 'PenomoranSuratController/reset/$1';
$route['penomoranSurat/deactivate/(:num)']['GET'] = 'PenomoranSuratController/deactivate/$1';
$route['penomoranSurat/(:num)/delete']['GET'] = 'PenomoranSuratController/delete/$1';
// +++++++++++++++++++++++++++++++++++ PENOMORAN SURAT +++++++++++++++++++++++++++++++++++ 

//PEJABAT
$route['pejabat']['POST'] = 'PejabatController/add_post/$1';
$route['pejabat/(:num)/delete']['GET'] = 'PejabatController/delete/$1';

//PESERTA
$route['peserta']['POST'] = 'PesertaController/add_post/$1';
$route['peserta/(:num)/delete']['GET'] = 'PesertaController/delete/$1';


//TEMBUSAN
$route['tembusan']['GET'] = 'TembusanController';

//SPRINT
$route['sprint']['GET'] = 'SprintController';
$route['sprint/getNomorSurat']['GET'] = 'SprintController/getNomorSuratSprint';
$route['sprint/(:num)']['GET'] = 'SprintController/show/$1';
$route['sprint/(:num)/edit']['GET'] = 'SprintController/edit_get/$1';
$route['sprint/(:num)/edit']['POST'] = 'SprintController/edit_post/$1';
$route['sprint/add']['GET'] = 'SprintController/add_get';
$route['sprint']['POST'] = 'SprintController/add_post';
$route['sprint/deactivate/(:num)']['GET'] = 'SprintController/deactivate/$1';



//AUTH
$route['login']['GET'] = 'LoginController';
$route['login']['POST'] = 'LoginController/authenticate';
$route['logout'] = 'LoginController/logout';


//OTHER
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;