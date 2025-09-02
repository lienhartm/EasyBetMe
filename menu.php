<nav>
	<?
    $help = '&#xea09;';
    $help = '&#xe941;';
    ?>
    <a href="<?=$Url?>/aide"><span class="icon"><?=$help;?></span></a>
    <a href="<?=$Url?>/informations"><i class="fa fa-soccer-ball-o" style="padding:13px;font-size:22px;color:rgb(0,104,55);" ></i></a>
    <a href="<?=$Url?>/news"><i class="fa" style="padding:13px;font-size:22px;color:rgb(0,104,55);">&#xf1ea;</i></a>
	<? if($_SESSION['login']==1 && ($User['id']==1 || $User['id']==2  || $User['id']==31)):?>
	    <a href="<?=$Url?>/admin"><span class="icon">&#xe994;</span></a>
	<? endif; ?>
	<? if($_SESSION['login']==1):?>
	    <!--<a href="<?=$Url?>/credits"><span class="icon">&#xe93b;</span><label><?=$User['credits'];?></label></a>-->
	    <a href="<?=$Url?>/gift"><span class="icon">&#xe99f;</span><label><?=$User['gift'];?></label></a>
	<? endif; ?>
	<? if($_SESSION['login']==1034):?>
	    <a href="<?=$Url?>/points"><span class="icon">&#xe9d9;</span><label><?=$User['points'];?></label></a>
	<? endif; ?>
	<? if($_SESSION['login']==1 && $User['id']==0):?>
	    <a href="<?=$Url?>/coins"><span class="icon">&#xe939;</span><label><?=$User['coins'];?></label></a>
    <? endif; ?>
	<? if($_SESSION['login']==1):?>
	    <a href="<?=$Url?>/penalty"><span class="icon">&#xe915;</span></a>
	<? endif; ?>
	<? $nav_link = ($_SESSION['login']==1) ? $Url.'/profile' : $Url.'/login'; ?>
	<a href="<?=$nav_link;?>"><span  class="icon">&#xe971;</span></a>
</nav>
