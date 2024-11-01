=== Transmenu ===
Contributors: LeoGermani
Donate link: http://pirex.com.br/wordpress-plugins
Tags: menu, menus, dropdown, pages, list, hover, subpages
Requires at least: 2.0
Tested up to: 2.1
Stable tag: 0.2.1

Creates a nice looking animated drop down menu for listing your pages and subpages (and more in the future)

== Description ==

OBS: All credits to this menu should go to:


 * TransMenu 
 * March, 2003
 *
 * Customizable multi-level animated DHTML menus with transparency.
 *
 * Copyright 2003-2004, Aaron Boodman (www.youngpup.net)


All I did was to put it to work on wordpress

Creates a nice looking animated drop down menu for listing your pages and subpages (and more in the future). You can see this plugin in action at http://ninhos.org. When you have subpages, it will look like this one: http://www.escoladarainha.org.br/

Cria um menu dropdown animado bonitão que lista suas páginas e subpáginas (e mais coisas no futuro)



== Installation ==

. Fa�a o download do arquivo
. Descompacte a pasta transMenu inteira no diret�rio "plugins" do seu wordpress
. Acesse o Painel de Administra��o > Plugins e ative o plugin.
. Cole o código <?php trans_list_pages('exclude=&sort_column=menu_order&title_li=' ); ?> onde você quiser que seu menu apareça no seu tema (note que o padrão é uma lista horizontal)
. Cole o código <?php trans_add_menus(); ?> logo antes da tag </body> no arquivo footer.php do seu tema 

. Download the package
. Extract the transMenu folder to the "plugins" folder of your wordpress
. In the Admin Panes go to "Plugins" and activate it
. Paste the code <?php trans_list_pages('exclude=&sort_column=menu_order&title_li=' ); ?> wherever you want your menu to be displayed in your theme (notice its a horizontal list by default)
. Paste the code <?php trans_add_menus(); ?> just before the </body> tag on you footer.php file of your theme (or in wichever file it is).


== ChangeLog ==

0.2 (01/21/2008)
. Fixed bug that the menus would display all pages, including private and drafts. Now it only displays privates when you are logged in and it never displays drafts
. Added a class style o the links of the pages to make it easier to play with the css

0.2.1 (01/26/2008)
. Fixed bug that would not display correctly submenus from the third level on
