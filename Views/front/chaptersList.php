<?php

try
{
    require_once('../autoloader.php');
    
    $postManager = new PostManager();
    $userManager = new UserManager();
    
    $posts = $postManager->getAllPublishedPosts();
    
    $title = 'Liste des chapitres';
    $content = '';
    
    for($i = 0; $i < count($posts); $i++)
    {
        $postDate = new DateTime($posts[$i]->Date());

        $content .= '<a href="chapter.php?chapter='.$posts[$i]->chapterNumber().'">';
        $content .= '<h3>Chapitre '.$posts[$i]->chapterNumber().' : '.$posts[$i]->Title().'</h3>';
        $content .= '<p>Publié le '.$postDate->format('d/m/Y à H:i:s').'</p>';
        $content .= '</a>';
    }
    require('template.php');
}
catch(Exception $e)
{
    echo 'Erreur : '.$e->getMessage();
}