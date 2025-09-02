<ul class="menu">
    <?
        $sub = array(
            '&#xe885;'=>'classement',
            '&#xe85d;'=>'points',
            '&#xe263;'=>'credits',
            '&#xe616;'=>'cadeaux',
            '&#xe0e1;'=>'settings',
            '&#xe879;'=>'Déconnexion'
        );

        foreach ($sub as $s=>$ul):
            echo '<li>';
                if ($s=='&#xe879;') echo '<a href="'.$Url.'/logout" class="logout">';
                else echo '<a href="'.$Url.'/'.$page.'/'.$ul.'">';
                    echo '<i class="material-icons">'.$s.'</i>';
                echo '</a>';
            echo '</li>';
        endforeach;
    ?>
</ul>