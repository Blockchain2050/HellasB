<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
//setting up path so we can use it in entire file 
//if your component folder have upper and lower case characters please use same here.
define('__OSSN_HELLO_WORLD__', ossn_route()->com . 'HelloWorld/');
require_once(__OSSN_HELLO_WORLD__ . 'classes/PointClass.php');


//this function is use to initilize ossn
function ossn_hello_world() {
  /**
  * Lets add our css to ossn default css file,
  * Lets create css directory in your component directory here our
  * directory name is HelloWorld so lets create new directory name css in HelloWorld
  * directory after that create a file name helloworld.php in it and add css
  * ossn.default is name of css.
  * use following code to add css in ossn default css file
  */
   ossn_extend_view('css/ossn.default', 'css/helloworld');
   
   
  /**
  * For javascript you can do same thing , but instead of css you need to use js see code below:
  */   
   ossn_extend_view('js/opensource.socialnetwork', 'js/helloworld');
  
  /**
  * Sometime you can't extned other css or js file as it creates conflicts in css or js,
  * so for that purpose you need to create seprate js or css file.
  * Now lets create a new directory called standalone in css directory 
  * create a file called helloworld.php in your standalone directory add your css code in that file.
  * To create seprate css link in header you can use following code.
  */
   //this will just tell system that new css file for header is available
   ossn_new_css('hello.world', 'css/standalone/helloworld');
   
   //now tell system to load file in header, here the first argument in function must be same as you 
   //used in ossn_new_css(<argument>) 
   ossn_load_css('hello.world');
   
   //lets create a new page called hello and print hello for that we need to use following code.
   ossn_register_page('hello', 'ossn_hello_page');
   ossn_register_page('hello_custom_template', 'hello_custom_template_page');
   ossn_register_page('emall', 'e_mall_page');
   ossn_add_hook('points', 'points', 'points');
}


// show points function
function points()
{

  $user=ossn_loggedin_user();
  error_log($user);
  $likes = new PointClass;

  $likes = $likes->showPoints($user->guid);
  echo $likes->points;
}


//e-Mall page
function e_mall_page(){

  $content = ossn_plugin_view('helloworld/hello_custom_page');
  $title = 'e-Mall';
  
    echo ossn_view_page($title, $content, 'emall');	
}
//page function that is create by ossn_register_page('hello', 'ossn_hello_page');
//the code below is use to print hello world in page.
// vist http://mysite.com/hello to view page
function ossn_hello_page(){
	$content = ossn_plugin_view('helloworld/hello_custom_page');
	$title = '?????????????? ???? ????????????????';
  echo ossn_view_page($title, $content, 'sub_pages');
}
function hello_custom_template_page(){
		//file components/HelloWorld/plugins/default/hellowolrd/hello_custom_page.php
		//you can add custom text html inside this page
    	$content = ossn_plugin_view('helloworld/hello_custom_page');
		$title = 'ABC';
		
		//components\HelloWorld\plugins\default\theme\page\my_custom_page_template.php contain a basic html layout, you can include your stuff in head.
		//Here ossn_load_css and load_js etc won't work as this is custom page outside OSSN templating system.
    	echo ossn_view_page($title, $content, 'my_custom_page_template');	
}
//this line is used to register initliize function to ossn system
ossn_register_callback('ossn', 'init', 'ossn_hello_world');
