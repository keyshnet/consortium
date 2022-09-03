<?php
//m_p(get_queried_object()->post_type);
if(in_category(89)){ // новости
	include('single-news.php');
}
elseif(get_queried_object()->post_type == "ds_network"){ // соцсеть
	include('single-social.php');
}
else{
	include('single-default.php');
}
