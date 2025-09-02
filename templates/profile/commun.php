<ul class="menu">
    <?
        $sub = array(
            '&#xe9d9;'=>'classement',
            '&#xe99e;'=>'points',
            '&#xe93b;'=>'credits',
            '&#xe99f;'=>'cadeaux',
            '&#xe971;'=>'settings',
            '&#xe9b6;'=>'Déconnexion'
        );

        foreach ($sub as $s=>$ul):
            echo '<li>';
                if ($s=='&#xe9b6;') echo '<a href="'.$Url.'/logout" class="logout">';
                else echo '<a href="'.$Url.'/'.$page.'/'.$ul.'">';
                    echo '<span class="icon">'.$s.'</span>';
                echo '</a>';
            echo '</li>';
        endforeach;
    ?>
</ul>