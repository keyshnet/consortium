<?php
$metaValues = array();
$metaValues['user_organization'] = acf_get_field('user_organization');
$metaValues['user_interest'] = acf_get_field('user_interest');
$metaValues['user_rate'] = acf_get_field('user_rate');
$metaValues['user_role_blog'] = acf_get_field('user_role_blog');
?>

<form method="get">
    <div class="cs-search uk-margin-medium-top friends__search uk-position-relative">
        <input type="text" value="<?php echo $_GET['search'] ?? ''; ?>" name="search" placeholder="Введите ФИО, телефон или электронную почту">
        <div class="uk-flex uk-align-center uk-margin-remove">
            <?php if ($args["use_filter"]) : ?>
                <button type="button" onclick="window.location.href='/<?php echo URL_NETWORK ?>/friends/'; return false;" class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle ico-close"></button>
            <?php endif; ?>
            <button type="button" onclick="return false;" id="filterTrigger" class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle uk-position-relative ico-filter">
                <?php if ($args["use_filter"]) : ?>
                    <span class="cs-badge cs-badge-right-top cs-badge-mini"></span>
                <?php endif; ?>
            </button>
            <button class="btn-search bg-reset uk-flex uk-flex-center uk-flex-middle ico-search">
            </button>
        </div>
        <div class="filter-content uk-hidden" id="filterItem">
            <div class="filter-content__title uk-margin-small-bottom">Поиск пользователей</div>
            <input type="checkbox" id="cb1" name="in_friends" value="Y" <?php echo (isset($_GET["in_friends"]) && $_GET["in_friends"] == "Y") ? "checked" : ""; ?>> <label for="cb1">В том числе среди друзей</label>

            <div class="uk-flex filter-content__block">
                <div class="callback__form-col uk-margin-medium-right">
                    <label class="uk-form-label">Роль пользователя </label>
                    <div class="form-select" name="user_role_blog">
                        <select name="user_role_blog">
                            <option value="">--Не важно--</option>
                            <?php foreach ($metaValues["user_role_blog"]["choices"] as $ur_key => $role) : ?>
                                <option value="<?php echo $ur_key ?>" <?php echo (!empty($_GET["user_role_blog"]) &&  $_GET["user_role_blog"] == $ur_key) ? 'selected' : ''; ?>> <?php echo $role ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="callback__form-col">
                    <label class="uk-form-label">Научная степень </label>
                    <div class="form-select">
                        <select name="user_rate">
                            <option value="">--Не важно--</option>
                            <?php foreach ($metaValues["user_rate"]["choices"] as $ur_key => $rate) : ?>
                                <option value="<?php echo $ur_key ?>" <?php echo (!empty($_GET["user_rate"]) &&  $_GET["user_rate"] == $ur_key) ? 'selected' : ''; ?>> <?php echo $rate ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="callback__form-col filter-content__block">
                <label class="uk-form-label">Организация </label>
                <div class="form-select">
                    <select name="user_organization">
                        <option value="">--Не важно--</option>
                        <?php foreach ($metaValues["user_organization"]["choices"] as $ua_key => $organiz) : ?>
                            <option value="<?php echo $ua_key ?>" <?php echo (!empty($_GET["user_organization"]) &&  $_GET["user_organization"] == $ua_key) ? 'selected' : ''; ?>> <?php echo $organiz ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <?php /*?><div class="callback__form-col filter-content__block">
                <label class="uk-form-label">Сфера интересов </label>
                <div class="form-select multiple-form-select">
                    <button type="button" class="ghost-btn multiple-select-btn">Выберите пункты</button>
                    <div uk-drop="mode: click; pos: bottom-right">
                        <div class="uk-card uk-card-body uk-card-default">
                            <?php $n=0; foreach ($metaValues["user_interest"]["choices"] as $ui_key => $interes): //m_p($_GET["user_interest"]);?>
                                <input type="checkbox" name="user_interest[]" value="<?php echo $ui_key?>" id="ui<?php echo $n?>" <?php echo (!empty($_GET["user_interest"]) &&  in_array($ui_key, $_GET["user_interest"]))? 'checked':'';?>> <label for="ui<?php echo $n?>"><?php echo $ui_key?></label>
                            <?php $n++; endforeach ?>
                        </div>
                    </div>
                </div>
            </div><?php */ ?>

            <div class="filter-content__btn-group">
                <button type="button" onclick="window.location.href='/<?php echo URL_NETWORK ?>/friends/'; return false;" class="ghost-btn">отмена</button>
                <button type="submit" class="cs-btn btn btn-5">поиск</button>
            </div>

        </div>
    </div>
</form>