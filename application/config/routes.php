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
$route['default_controller'] = 'C_Main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['OrderReceivable'] = 'Managerbudget/O_Cost/C_Order_Cost/Control/Receivable'; 
$route['OrderPaid'] = 'Managerbudget/O_Cost/C_Order_Cost/Control/Paid'; 
//contratos
$route['Contracts'] = 'Contracts/C_Contracts/GetList'; 
$route['CreateContract'] = 'Contracts/C_Contracts/Form'; 
$route['InfoContract/(:num)'] = 'Contracts/C_Contracts/Form/$1'; 
//ppto interna
$route['Interna'] = 'Managerbudget/C_Ppto/GetList/7'; 
$route['Interna/Create'] = 'Managerbudget/C_Ppto/NewCreate';
$route['Interna/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Interna/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Prensa'] = 'Managerbudget/C_Ppto/GetList/1'; 
$route['Prensa/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Prensa/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Radio'] = 'Managerbudget/C_Ppto/GetList/4'; 
$route['Radio/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Radio/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';
$route['PreRadio'] = 'Managerbudget/C_Preorden/GetList/4';
$route['Radio/NewOrden/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1/true';
$route['Radio/EditOrden/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2/true';

$route['Tv'] = 'Managerbudget/C_Ppto/GetList/5'; 
$route['Tv/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Tv/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Clasificado'] = 'Managerbudget/C_Ppto/GetList/2'; 
$route['PreClasificado'] = 'Managerbudget/C_Preorden/GetList/2'; 
$route['Clasificado/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Clasificado/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';
$route['Clasificado/NewOrden/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1/true';
$route['Clasificado/EditOrden/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2/true';

$route['Revista'] = 'Managerbudget/C_Ppto/GetList/3'; 
$route['Revista/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Revista/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Externa'] = 'Managerbudget/C_Ppto/GetList/6'; 
$route['Externa/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Externa/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Exterior'] = 'Managerbudget/C_Ppto/GetList/8'; 
$route['Exterior/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Exterior/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Impreso'] = 'Managerbudget/C_Ppto/GetList/9'; 
$route['Impreso/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Impreso/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['Articulo'] = 'Managerbudget/C_Ppto/GetList/10'; 
$route['Articulo/Edit/(:num)/(:num)'] = 'Managerbudget/C_Ppto/Edit/$1/$2';
$route['Articulo/New/(:num)'] = 'Managerbudget/C_Ppto/NewP/$1';

$route['OrderC'] = 'Managerbudget/O_Cost/C_Order_Cost/GetList';
$route['OrderC/Edit/(:num)'] = 'Managerbudget/O_Cost/C_Order_Cost/Edit/$1';
$route['OrderC/New'] = 'Managerbudget/O_Cost/C_Order_Cost/NewP';
$route['OrderC/Download/(:num)'] = 'Managerbudget/O_Cost/C_Order_Cost/DownloadOrder/$1';

$route['Expense'] = 'Managerbudget/O_Expense/C_Expense/GetList';
$route['Expense/Edit/(:num)'] = 'Managerbudget/O_Expense/C_Expense/Edit/$1';
$route['Expense/New'] = 'Managerbudget/O_Expense/C_Expense/NewP';

$route['Billing'] = 'Billing/C_Bill/Panel';
$route['Billing/Edit/(:num)'] = 'Billing/C_Bill/Edit/$1';
$route['Billing/Attach/(:num)'] = 'Billing/C_Bill/Attach/$1';
$route['Billing/New'] = 'Billing/C_Bill/NewP';

$route['Document'] = 'Billing/C_Document/Panel';
$route['Document/Edit/(:num)'] = 'Billing/C_Document/Edit/$1';
$route['Document/New'] = 'Billing/C_Document/NewP';

$route['Filed'] = 'Reception/C_Filed/Panel';
$route['Filed/Edit/(:num)'] = 'Reception/C_Filed/Edit/$1';
$route['Filed/New'] = 'Reception/C_Filed/NewP';

$route['Help'] = 'Help/C_Help/Panel';
$route['Ethics'] = 'C_Main/Ethics';

$route['Process'] = 'Sgc/C_Sgc/Panel';
$route['Fomats'] = 'Sgc/C_Sgc/ListFormat';
$route['GetTableFormat/(:num)'] = 'Sgc/C_Sgc/GetTableFormat/$1';
$route['Sgc/Edit/(:num)/(:num)'] = 'Sgc/C_Sgc/Edit/$1/$2';
$route['Sgc/FormEdit/(:num)/(:num)'] = 'Sgc/C_Sgc/EditForm/$1/$2';
$route['Sgc/New/(:num)'] = 'Sgc/C_Sgc/NewP/$1';

$route['Permissions'] = 'Parameters/Security/C_Security/Permissions';
$route['Buttons'] = 'Parameters/Security/C_Security/Buttons';