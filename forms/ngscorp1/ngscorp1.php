<?PHP
/*
Simfatic Forms Main Form processor script

This script does all the server side processing. 
(Displaying the form, processing form submissions,
displaying errors, making CAPTCHA image, and so on.) 

All pages (including the form page) are displayed using 
templates in the 'templ' sub folder. 

The overall structure is that of a list of modules. Depending on the 
arguments (POST/GET) passed to the script, the modules process in sequence. 

Please note that just appending  a header and footer to this script won't work.
To embed the form, use the 'Copy & Paste' code in the 'Take the Code' page. 
To extend the functionality, see 'Extension Modules' in the help.

*/

@ini_set("display_errors", 1);//the error handler is added later in FormProc
error_reporting(E_ALL);

require_once(dirname(__FILE__)."/includes/ngscorp1-lib.php");
$formproc_obj =  new SFM_FormProcessor('ngscorp1');
$formproc_obj->initTimeZone('Europe/London');
$formproc_obj->setFormID('5027981b-153a-4406-ba3c-4bd8234488ec');
$formproc_obj->setRandKey('ca228aa4-b7dd-4bca-81a4-d32cb48ab9e5');
$formproc_obj->setFormKey('041107b1-70d5-441b-a6f8-72ea1a2be540');
$formproc_obj->setLocale('en-GB','dd/MM/yyyy');
$formproc_obj->setEmailFormatHTML(true);
$formproc_obj->EnableLogging(false);
$formproc_obj->SetDebugMode(false);
$formproc_obj->setIsInstalled(true);
$formproc_obj->SetPrintPreviewPage(sfm_readfile(dirname(__FILE__)."/templ/ngscorp1_print_preview_file.txt"));
$formproc_obj->SetSingleBoxErrorDisplay(true);
$formproc_obj->setFormPage(0,sfm_readfile(dirname(__FILE__)."/templ/ngscorp1_form_page_0.txt"));
$formproc_obj->AddElementInfo('Company_name','text','');
$formproc_obj->AddElementInfo('Contact_name','text','');
$formproc_obj->AddElementInfo('Country_code','text','');
$formproc_obj->AddElementInfo('Telephone','text','');
$formproc_obj->AddElementInfo('Fax','text','');
$formproc_obj->AddElementInfo('Email','email','');
$formproc_obj->AddElementInfo('DropdownList','listbox','');
$formproc_obj->AddElementInfo('City','text','');
$formproc_obj->AddElementInfo('Time_to_call','listbox','');
$formproc_obj->AddElementInfo('Message','multiline','');
$formproc_obj->SetHiddenInputTrapVarName('t2a9e218cda69f3945bc9');
$formproc_obj->SetFromAddress('inform@ngscorp.co.uk');
$page_renderer =  new FM_FormPageDisplayModule();
$formproc_obj->addModule($page_renderer);

$validator =  new FM_FormValidator();
$validator->addValidation("Company_name","required","Please fill in Co_name");
$validator->addValidation("Contact_name","required","Please fill in Contact_name");
$validator->addValidation("Telephone","required","Please fill in Telephone");
$validator->addValidation("Email","email","The input for  should be a valid email value");
$formproc_obj->addModule($validator);

$data_email_sender =  new FM_FormDataSender(sfm_readfile(dirname(__FILE__)."/templ/ngscorp1_email_subj.txt"),sfm_readfile(dirname(__FILE__)."/templ/ngscorp1_email_body.txt"),'%Email%');
$data_email_sender->AddToAddr('inform@ngscorp.co.uk');
$formproc_obj->addModule($data_email_sender);

$tupage =  new FM_ThankYouPage();
$tupage->SetRedirURL('http://ngscorp.co.uk/thankyou.html');
$formproc_obj->addModule($tupage);

$page_renderer->SetFormValidator($validator);
$formproc_obj->ProcessForm();

?>