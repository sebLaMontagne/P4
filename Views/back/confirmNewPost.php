<?php

try
{
    $title = 'confirmation du chapitre';
    include('template.php');

    $_SESSION['refresh'] = 1;
    unset($_SESSION['refresh']);

    if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != '1')
    {
        header("location:javascript://history.go(-1)");
    }
    else
    {
        $postManager = new PostManager();
        if($postManager->isChapterExist($_POST['chapterNumber']))
        {
            if(!isset($_POST['confirmation']))
            {
                echo '
                <p>Ce chapitre existe déjà. Etes-vous sûr de vouloir l\'écraser ?</p>
                <form method="post">
                    <input type="radio" name="confirmation" value="yes" id="yes" /><label for="yes">Oui</label>
                    <input type="radio" name="confirmation" value="no" id="no" /><label for="no">Non</label>
                    <input type="hidden" name="chapterNumber" value="'.$_POST['chapterNumber'].'" />
                    <input type="hidden" name="title" value="'.$_POST['title'].'" />
                    <input type="hidden" name="content" value="'.$postManager->encode($_POST['content']).'" />
                    <input type="hidden" name="publish" value="'.$_POST['publish'].'" />
                    <input type="submit" value="Confirmer" />
                </form>';
            }
            elseif($_POST['confirmation'] == 'yes')
            {
                $postManager->updatePost($postManager->getPostIDbyChapter($_POST['chapterNumber']), $_POST['chapterNumber'], $_POST['title'], $postManager->encode($_POST['content']), $_POST['publish']);
                header('Location:chaptersList.php');
            }
            elseif($_POST['confirmation'] == 'no')
            {
                $_SESSION['data']['chapterNumber'] = $_POST['chapterNumber'];
                $_SESSION['data']['title'] = $_POST['title'];
                $_SESSION['data']['content'] = $_POST['content'];
                header('location:newPost.php');
            }
        }
        else
        {
            $postManager->savePost($_SESSION['id'], $_POST['chapterNumber'], $_POST['title'], $_POST['content'], intval($_POST['publish']));
            header('Location:chaptersList.php');
        }
    }
}
catch(Exception $e)
{
    echo 'Erreur : '.$e->getMessage();
}
