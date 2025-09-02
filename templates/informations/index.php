<div class="competitions">
    <h3>Des informations sur les ligues et les coupes qui t'intéressent !</h3>
    <br />
    <div class="grid-container">
        <?php

            $path = "/homepages/18/d864215150/htdocs/monwebpro.com/sites/easybet/templates/cron-tab-1/data/competitions.json";
            $myfile = fopen($path, "r") or die("Unable to open file!");
            $file = fread($myfile, filesize($path));
            fclose($myfile);
            $data = json_decode($file, true);

            $data = $data['competitions'];

            foreach($data as $competition) {

                echo "<a href='".$Url."/informations/info/".$competition['code']."' >
                        <div class='competition'>
                            <figure>
                                <img class='emblem' src='".$competition['emblem']."' alt='competition flag' />
                                <figcaption>
                                    <p class='name'>".$competition['name']."</p>
                                    <p class='areaname'><img class='flag' src='".$competition['area']['flag']."' alt='logo area' width='20px' height='20px' />".$competition['area']['name']."</p>
                                </figcaption>
                            </figure>
                        </div>
                    </a>";
                    
            }

        ?>
    </div>
</div>

<style>
    div.competitions {
        margin:100px auto;
    }
    h3 {
        font-weight:bold;
        text-align:center;
    }
    a {
        text-decoration:none;
        color:black;
    }
    a:hover div.competition {
        border-collapse:collapse;
        border: 6px solid #C8C8C8;
    }
    figure {
        background-color:white;
        text-align:center;
    }
    figcaption {
        background-color:#F8F8F8;
        padding:20px 5px 5px 5px;
        height: 100px;
        text-align:center;
    }
    div.competition {
        width: 200px;
        min-height: 200px;
        border: 2px solid #E8E8E8;
        border-collapse:collapse;
        border-bottom: 6px solid #C8C8C8;
    }
    img.emblem {
        padding: 20px;
        width:100px;
        max-height:100px;
        min-height:100px;
    }
    p.name {
        font-size:14px !important;
        font-weight:bold;
    }

    p.areaname {
        font-size:12px !important;
    }
    img.flag {
        margin-right:10px;
    }
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto auto;
        justify-content: center;
        align-items:center;
        gap: 5px;
    }

    .grid-container > div {
        background-color: white;
        text-align: center;
        font-size: 30px;
    }

    @media only screen and (max-width: 600px) {
        .grid-container {
            display: flex;
            flex-direction: column;
        }
    }
</style>
