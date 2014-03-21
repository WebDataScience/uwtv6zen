<?php

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type (or item type string supplied by module).
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])): ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<?php
global $base_url;
//dpm($node, '$node');
$dept_wrapper = entity_metadata_wrapper('node', $node);

//dpm($dept_wrapper->getPropertyInfo(), 'getPropertyInfo()');

//dpm('do we get here? 1');
$dept_summary = '';

if(!empty($node->field_departmentsummary)){
  $dept_summary = $dept_wrapper->field_departmentsummary->value->value();
}

//dpm('do we get here? 2');
$dept_box = $dept_wrapper->field_departmentmailbox->value();
//dpm('do we get here? 3');
$dept_box_display = theme_item_list(array('items' => $dept_box, 'type' => 'ul', 'title' => 'Campus box'));

$phone = $dept_wrapper->field_departmentphonenumber->value();
$phone_display = theme_item_list(array('items' => $phone, 'type' => 'ul', 'title' => 'Phone Number'));
$dept_url = $dept_wrapper->field_departmentwebsite->value();
$dept_url_link = l($dept_url, $dept_url);
$dept_url_display = theme_item_list(
	array(
		'items' => array($dept_url_link), 
		'type' => 'ul', 
		'title' => 'Web site')
	);
//dpm($dept_wrapper, '$dept_wrapper');

$location_room = 'Room not specified.';
try {
$location_room = $dept_wrapper->field_location->field_locationroom->value();
} catch (EntityMetadataWrapperException $e){
	//dpm($e->getMessage());
}
//dpm($location_room, '$location_room');

$location_building_name = 'Building not specified';
try {
$location_building_name = $dept_wrapper->field_location->field_locationbuilding->field_buildingname->value();
} catch (EntityMetadataWrapperException $e) {
	//dpm($e->getMessage(), 'exception caught');
}


//dpm($location_building_name, '$location_building_name');

try {
$location = $dept_wrapper->field_location->field_locationbuilding->value();
} catch (EntityMetadataWrapperException $e) {
	//dpm($e->getMessage());
}


//dpm($location, '$location');
$building_url = $location->field_buildingwebsite['und'][0]['value'];
//dpm($building_url, '$building_url');

$location_link = l("$location_building_name $location_room", $building_url);

$location_display = theme_item_list(array('items' => array($location_link), 'type' => 'ul', 'title' => 'Location'));

/*
dpm($phone_display, '$phone_display');
dpm($dept_url, '$dept_url');
dpm($dept_url_link, '$dept_url_link');
dpm($dept_url_display, '$dept_url_display');
dpm($dept_summary, '$dept_summary');
dpm($dept_box_display, '$dept_box_display');
*/


?>

<li class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <h3 class="title"<?php print $title_attributes; ?>>
    <a href="<?php print $url; ?>"><span style="display:inline-block;" class="<?php print $sr_class; ?>"></span> <?php print $title; ?></a>
  </h3>
  
  <?php print render($title_suffix); ?>
  <div class="search-snippet-info">

    <?php /* if ($snippet): ?>
      <p class="search-snippet"<?php print $content_attributes; ?>><?php print $snippet; ?></p>
    <?php endif; */ ?>

    <?php if ($result): ?>
       <div class="search-result department quarters">
         <div class="summary"><?php print $dept_summary; ?></div>
         <div class="detail one-quarter-first"><?php print $phone_display;?></div>
         <div class="detail one-quarter-second"><?php print $location_display;?></div>
         <div class="detail one-quarter-third"><?php print $dept_url_display;?></div>
         <div class="detail one-quarter-fourth"><?php print $dept_box_display;?></div>
       </div>
    <?php endif; ?>

      <?php if ($search_result_sectionlink): ?>
        <p class="search-result-sectionlink">Section: <?php print $search_result_sectionlink; ?></p>
      <?php endif; ?>

      <?php if ($info): ?>
        <p class="search-result-updated">Updated: <?php print substr($info_split['date'], 0, 10); ?></p>
      <?php endif; ?>

  </div>
</li>
