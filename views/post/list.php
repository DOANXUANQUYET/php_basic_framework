<h2 class="text-center">List post</h2>
<table class="table">
    <thead>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>content</th>
        <th>category</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php
            if(isset($posts)){
                foreach ($posts as $post){
                   echo '<tr>';
                   echo '<td>'.$post->id_post.'</td>';
                   echo '<td>'.$post->post_title.'</td>';
                   echo '<td>'.$post->post_content.'</td>';
                   echo '<td>'.$post->title_category_post.'</td>';
                   echo '<td>
                            <a href="/php_basic_framework/post/edit/'.$post->id_post.'"><i class="bi bi-pencil-square"></i></a> |
                            <a href="/php_basic_framework/post/delete/'.$post->id_post.'"><i class="bi bi-trash "></i></a>
                        </td>';
                   echo '</tr>';
                }
            }

        ?>
    </tbody>
</table>
<a href="<?=BASE_URL.'/home'?>" class="btn btn-secondary">Back</a>
