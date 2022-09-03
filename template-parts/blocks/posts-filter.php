<?php
$filterSubjects = get_terms(array(
    'hide_empty'  => 0,
    'taxonomy'    => 'ds_objects',
));
$subjects = wp_list_filter($filterSubjects, array('parent' => 0));

$subjAct = (isset($_GET["subj"]) && !empty($_GET["subj"])) ? $_GET["subj"] : "";
?>
<div class="uk-flex uk-flex-between">
    <div class="soc-ddown uk-margin-small-right">
        <select onchange="top.location=this.value">
            <option value="<?php echo add_query_arg(['subj' => false]) ?>">Все тематические разделы</option>
            <?php foreach ($subjects as $subject) : ?>
                <option <?php echo ($subject->term_id == $subjAct) ? "selected" : ""; ?> value="<?php echo add_query_arg(['subj' => $subject->term_id]) ?>"><?php echo $subject->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="soc-ddown">
        <select onchange="top.location=this.value">
            <option value="">По новизне</option>
            <option value="<?php echo add_query_arg(['order' => 'desc']) ?>">Сначала последние</option>
            <option value="<?php echo add_query_arg(['order' => 'asc']) ?>">Сначала первые</option>
        </select>
    </div>
</div>