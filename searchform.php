<?php
$obj = get_queried_object();
if ($obj->name == 'eb_course')
    $this_page = "/courses/";
else
    $this_page = ($obj->term_taxonomy_id > 0) ? get_category_link($obj->term_taxonomy_id) : home_url('/');
?>
<form role="search" method="get" id="searchform" action="/eb_course/">
    <div class="cs-search uk-margin-medium-top">
        <input type="text" value="<?php echo get_search_query() ?>" name="s" placeholder="Поиск по материалам" />
        <button type="submit" id="searchsubmit" class="btn-search"></button>
    </div>
</form>