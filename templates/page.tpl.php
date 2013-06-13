<?php
/**
 * @file
 * Zen theme's implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $secondary_menu_heading: The title of the menu used by the secondary links.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['navigation']: Items for the navigation region, below the main menu (if any).
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['footer']: Items for the footer region.
 * - $page['bottom']: Items to appear at the bottom of the page below the footer.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess_page()
 * @see template_process()
 */
?>

<?php
dpm($variables);
  /**
  * The point of this custom template file is to insert the patch and 
  * textual site logo on any site that uses this theme, irrespective of
  * the presence of a block of content or whatever.
  * If a site uses the uwt_v6 theme, it will have the patch and textual
  * site logo. Period.
  *
  * I guess we should have some logic that will determine which textual
  * logo to display (the big or small one) and whether or not we have a
  * a subsite link to display.
  */
  // create link to UWT Home
  $path = '<front>';
  $href = url($path);

  $patch_link = '<a href="' . $href . '">';
  $patch_link .= '<span class="graphics-uwt_logo_patch"><span class="element-invisible">UW Tacoma patch icon</span></span>';
  $patch_link .= '<span class="graphics-uwt_logo_patch_mobile"><span class="element-invisible">UW Tacoma patch icon</span>';
  $patch_link .= '</a>';


  $logo_text_link = '<a href="' . $href . '">';
  $logo_text_link .= '<span class="graphics-uwt_logo_text"><span class="element-invisible">University of washington | Tacoma</span></span>';
  $logo_text_link .= '<span class="graphics-uwt_logo_text_white"><span class="element-invisible">University of washington | Tacoma</span></span>';
  $logo_text_link .= '</a>';
  $site_home_link = '';

  if(arg(0) == 'node' && is_numeric(arg(1))) {
    $node = node_load(arg(1));
    //dpm($node);
    $wrapper = entity_metadata_wrapper('node', $node);
    if ($wrapper->field_site->value()->tid) {
      $siteid = $wrapper->field_site->value()->tid;
      //$logo_text_link = '<a href="' . $href . '">';
      //$logo_text_link .= '<span class="graphics-uwt_logo_text_small"><span class="element-invisible">University of washington | Tacoma</span></span></a>';
      //dpm('we have a site, right?');


      $parents = taxonomy_get_parents_all($siteid);
      $parent = end($parents);
      //dpm($parent);
      // Get the menu for the parent site
      $results = db_query("SELECT menu FROM uwt_menu_admin WHERE tid = :tid", array(':tid' => $parent->tid));
      $menu_name = $results->fetchObject()->menu;
      //dpm($menu_name, '$menu_name');
      $menu = menu_tree_all_data($menu_name, NULL, 1);
      //dpm($menu, '$menu');
      $home_menu_item = array_slice($menu, 0, 1); // Yes, use the first menu item in the menu
      foreach($home_menu_item as $link) { // There will only be one...the Highlander pattern.
        //dpm($link, '$link');
        $label = $link['link']['link_title'];
        $href = $link['link']['href'];
        $options = array('attributes' => array('class' => 'site-home-link'));
        //dpm($label, '$label');
        //dpm($href, '$href');
        //dpm($options, '$options');
           $site_home_link = '<span id="site-home-link">';
           $site_home_link .= l($label, $href);
           $site_home_link .= '</span>';
        /*
         */
      }
    }
  }

 ?>


<div id="page">
  <header id="header" role="banner">
    <div id="band">
    </div> <!-- /band -->

    <div id="home-links">
      <div id="patch">
        <?php echo $patch_link; ?>
      </div>
      <div id="logo_text">
        <?php echo $logo_text_link; ?>
      </div>
      <div id="site_home_link">
        <?php echo $site_home_link; ?>
      </div>    
    </div> <!-- /home-links -->
    
    <div id="global-menu">
    <?php if ($main_menu): ?>
      <nav id="main-menu" role="navigation">
        <?php print render($page['navigation']); ?>
      </nav>
    <?php endif; ?>
    </div> <!-- /global-menu -->


    <div id="global-search-container">
      <form id="global-search-form">
        <input type="text" />
      </form>
    </div> <!-- /global-search -->





  

  

  </header>

    <div id="header-botom">
      <?php print render($page['header_bottom']); ?>
    </div>

  <div id="main">

    

    <div id="content" class="column" role="main">
      <?php print render($page['highlighted']); ?>
      <?php print $breadcrumb; ?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="title" id="page-title"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div><!-- /#content -->



    <?php
      // Render the sidebars to see if there's anything in them.
      $sidebar_first  = render($page['sidebar_first']);
      $sidebar_second = render($page['sidebar_second']);
    ?>

    <?php if ($sidebar_first || $sidebar_second): ?>
      <aside class="sidebars">
        <?php print $sidebar_first; ?>
        <?php print $sidebar_second; ?>
      </aside><!-- /.sidebars -->
    <?php endif; ?>

  </div><!-- /#main -->

  <?php print render($page['footer']); ?>

</div><!-- /#page -->

<?php print render($page['bottom']); ?>
