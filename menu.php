<nav>
	<?
    $help = '&#xea09;';
    $help = '&#xe941;';
    ?>
    <a href="<?=$Url?>/aide"><span class="icon"><?=$help;?></span></a>
	<? if($_SESSION['login']==1 && ($User['id']==1 || $User['id']==2)):?>
	<a href="<?=$Url?>/admin"><span class="icon">&#xe994;</span></a>
	<? endif; ?>
	<? if($_SESSION['login']==1):?>
	<a href="<?=$Url?>/credits"><span class="icon">&#xe93b;</span><label><?=$User['credits'];?></label></a>
	<? endif; ?>
	<? if($_SESSION['login']==1034):?>
	<a href="<?=$Url?>/points"><span class="icon">&#xe9d9;</span><label><?=$User['points'];?></label></a>
	<? endif; ?>
	<? if($_SESSION['login']==1 && $User['id']==0):?>
	<a href="<?=$Url?>/coins"><span class="icon">&#xe939;</span><label><?=$User['coins'];?></label></a>
	<? endif; ?>
	
	<? $nav_link = ($_SESSION['login']==1) ? $Url.'/profile' : $Url.'/login'; ?>
	<a href="<?=$nav_link;?>"><span  class="icon">&#xe971;</span></a>
</nav>
