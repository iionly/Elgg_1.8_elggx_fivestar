Elggx Fivestar plugin for Elgg 1.8
Latest Version: 1.8.6
Released: 2013-11-03
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (c) iionly (for Elgg 1.8 version), Billy Gunn


This plugin will add a voting widget to certain views on your site, for example blogs, pages, bookmarks, files and group discussions. By default the voting widget will display 5 stars but you can configure the number of stars to show. You can also configure if your members should be allowed to change their vote or not.



Installation:

(0. If you have installed a previous version of the Elggx Fivestar plugin disable the plugin in the admin section of your site and then remove the elggx_fivestar folder from the mod directory of your Elgg installation,)
1. Copy the elggx_fivestar folder into the mod directory of your Elgg installation,
2. Enable the plugin in the admin section of your site,
3. Configure then the plugin settings (section "Administer" - "Utilities" - "Elggx Fivestar"). At least it's necessary to add the rating widget to some views for the Elggx Fivestar plugin being useable. Via the plugin settings you can add the rating widget to some pre-defined default views. In the following is described in detail how the configuration of the rating widget for more views works in detail.



How to customize it:

To include the rating widget on your site after enabling the Elggx Fivestar plugin for the first time (or after upgrading from a version of Elggx Fivestar < 1.8.0) you need to set the default views on Elggx Fivestar's plugin settings page in the admin section of your site ("Administer" - "Utilities" - "Elggx Fivestar"). Click on "Set / Reset default views" and save the settings. There are already some default views defined in start.php where the rating widget will be included on your site, for example on blogs, pages and group discussions.

You can also configure on your own where the rating widget should appear. Either you can define additional views to include the widget on other pages or remove the rating widget from certain pages. If you are not happy with any of the default views and want to remove it you can do this in the plugin's setting page by removing the corresponding view. Or you can adjust the default views defined in start.php of Elggx Fivestar (function elggx_fivestar_defaults() starting at line 260) and then resetting the views on the settings page.

If you want to add the rating widget to a view you can also do this either via adding the view directly via the settings page or again by adjusting the default views in start.php. You will need to have some knowledge about the php/html code of the view you want to add the rating widget to be able able to define the correct position. The already defined default view should give you an idea how it works.

If you want to add a new view via the settings page the code to be included has to start with

    elggx_fivestar_view=

followed by the parameters to identify the view.

The method for adding the rating widget to a view as used by the defined default views or any other views you define via the settings page / start.php requires a distinct html or css tag to define the position the rating widget will be included on the corresponding page, either before or after this tag. Sometimes, this method might not be appropriate to define the exact position desired for the rating widget. There's also a second way to add the rating widget to a view that allows exact positioning. You need to modify the code of the view for this method to work.

Simply add the following at the appropriate place in your plugin code and adjust the parameters accordingly:

echo elgg_view("elggx_fivestar/voting", array(
    'entity' => $entity,
    'min' => true,
    'subclass' => 'fivestar_subclass',
    'outerId' => 'fivestar_rating_list',
    'ratingTextClass' => 'fivestar_rating_text'
));

The above code snippet includes all possible options to configure the voting widget. These are:

    * 'entity' => $entity: This defines the entity to be voted on. The variable $entity must be assigned the correct Elgg entity in the code prior calling the voting widget.
    * 'min' => true: If set to true, the voting widget will be bare only showing the stars to vote on and not the current voting stats (number of votes and average vote) for this entity.
    * 'subclass' => 'fivestar_subclass', 'outerId' => 'fivestar_rating_list', 'ratingTextClass' => 'fivestar_rating_text': These options allow you to configure the layout of the voting widget via CSS settings defined for example in Elggx Fivestar's css file (in elggx_fivestar/views/default/css/basic.php). The strings are the identifiers of the css classes and you have to define the classes prior using them.

The simpliest way to include the voting widget in the plugin code is by only giving the entity to be voted on as parameter:

    echo elgg_view("elggx_fivestar/voting", array('entity' => $entity));

In this case the default css layout of the voting widget is used. Still, you must assign the correct entity to the variable $entity in any case.



Changelog:

1.8.6:

- Fixed error in activate.php,
- Updated simple_html_dom.php library.


1.8.5:

- There're not really any changes. I only forgot to update the version number in activate.php correctly for Elggx Fivestar 1.8.4, so the version 1.8.5 does correct this - by switching directly to 1.8.5...


1.8.4:

- Fix for Elggx Fivestar plugin to work in Elgg 1.8.14 with simple cache enabled.


1.8.3:

- Some general code cleanup,
- Update of simple_html_dom library to latest version,
- Updated the default views (to use them you need to Set/Reset the default views in the Elggx Fivestar plugin configuration in the section "Administer" - "Utilities" - "Elggx Fivestar").


1.8.2:

- French translation added (thank to emanwebdev),
- German translation added.

1.8.1 (by iionly):

- Adding/removing views via the plugin settings page should work now.
(It was necessary to move the plugin settings to the "Administer" - "Utilities" section as the Elgg core save button added automatically on pages in the "Configure" - "Settings" section failed to keep the content of the views array. When upgrading please remove the old Elggx Fivestar folder before copying the files of the new version on your server.)


1.8.0 (by iionly):

- Initial release for Elgg 1.8